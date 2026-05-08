<?php

namespace App\Http\Controllers;

use App\Models\InsurancePlan;
use App\Models\Policy;
use App\Models\Agent;
use App\Models\AgentCommission;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Checkout\Session;

class PaymentController extends Controller
{
    /**
     * Create a Stripe Checkout Session and redirect the user.
     */
    public function checkout(Request $request, InsurancePlan $plan)
    {
        // 1. Set Stripe Secret Key
        Stripe::setApiKey(env('STRIPE_SECRET'));

        // 2. Validate nominee data from the request before going to Stripe
        $request->validate([
            'nominee_name' => 'required|string|max:255',
            'nominee_relation' => 'required|string|max:255',
        ]);

        // 3. Create Stripe Checkout Session
        // Note: Stripe requires amounts in the smallest currency unit (e.g., paise for INR, cents for USD)
        // We will assume the base_premium is in whole numbers (INR/USD) and multiply by 100.
        $checkout_session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [
                [
                    'price_data' => [
                        'currency' => 'inr',
                        'product_data' => [
                            'name' => $plan->name . ' Policy',
                            'description' => 'Coverage: ' . number_format((float) $plan->coverage_amount) . ' for ' . $plan->duration_years . ' Year(s)',
                        ],
                        'unit_amount' => (int) ($plan->base_premium * 100),
                    ],
                    'quantity' => 1,
                ]
            ],
            'mode' => 'payment',
            // Pass the plan ID and nominee data through the URL so we can process it on success
            'success_url' => route('stripe.success') . '?session_id={CHECKOUT_SESSION_ID}&plan_id=' . $plan->id . '&nominee_name=' . urlencode($request->nominee_name) . '&nominee_relation=' . urlencode($request->nominee_relation),
            'cancel_url' => route('stripe.cancel', ['plan' => $plan->slug]),
        ]);

        // 4. Redirect to Stripe
        return redirect()->away($checkout_session->url);
    }

    /**
     * Handle the successful return from Stripe.
     */
    public function success(Request $request)
    {
        // 1. Verify the session
        Stripe::setApiKey(env('STRIPE_SECRET'));

        try {
            $session = Session::retrieve($request->get('session_id'));
        } catch (\Exception $e) {
            return redirect()->route('home')->with('error', 'Invalid payment session.');
        }

        // 2. Ensure payment was actually successful
        if ($session->payment_status !== 'paid') {
            return redirect()->route('home')->with('error', 'Payment was not successful.');
        }

        $plan_id = $request->get('plan_id');
        $plan = InsurancePlan::findOrFail($plan_id);

        // 3. Generate the Policy (Identical to previous FrontController logic)
        $policy = Policy::create([
            'user_id' => auth()->id(),
            'plan_id' => $plan->id,
            'policy_number' => 'POL-' . strtoupper(uniqid()),
            'premium_amount' => $plan->base_premium,
            'coverage_amount' => $plan->coverage_amount,
            'start_date' => now(),
            'end_date' => now()->addYears($plan->duration_years),
            'status' => 'active',
            'next_renewal_date' => now()->addYear(),
        ]);

        // 4. Credit Agent Commission (if the user was referred by an agent)
        $buyer = auth()->user();
        if ($buyer->referred_by_agent_id) {
            $agent = Agent::find($buyer->referred_by_agent_id);
            if ($agent && $agent->status === 'approved') {
                $commissionAmount = round($plan->base_premium * ($agent->commission_rate / 100), 2);

                AgentCommission::create([
                    'agent_id' => $agent->id,
                    'policy_id' => $policy->id,
                    'user_id' => $buyer->id,
                    'premium_amount' => $plan->base_premium,
                    'commission_amount' => $commissionAmount,
                    'commission_rate' => $agent->commission_rate,
                    'status' => 'pending',
                ]);

                // Update agent's running totals
                $agent->increment('total_earnings', $commissionAmount);
                $agent->increment('pending_payout', $commissionAmount);
            }
        }

        // 5. Send Policy Issuance Notification (Database + Email)
        $buyer->notify(new \App\Notifications\PolicyPurchasedNotification($policy));

        return redirect()->route('home')->with('success', 'Payment successful! Your ' . $plan->name . ' policy has been generated.');
    }

    /**
     * Handle the cancelled return from Stripe.
     */
    public function cancel(Request $request)
    {
        $planSlug = $request->get('plan');
        return redirect()->route('plan.apply', ['plan' => $planSlug])
            ->with('error', 'Payment was cancelled. You can try again when you are ready.');
    }
}
