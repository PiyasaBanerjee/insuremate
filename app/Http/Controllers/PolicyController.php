<?php

namespace App\Http\Controllers;

use App\Models\Policy;
use App\Models\PolicyRenewal;
use Illuminate\Http\Request;

use Barryvdh\DomPDF\Facade\Pdf;

class PolicyController extends Controller
{
    public function show(Policy $policy)
    {
        if ($policy->user_id !== auth()->id()) {
            abort(403);
        }
        return view('frontend.policy.show', compact('policy'));
    }

    public function download(Policy $policy)
    {
        if ($policy->user_id !== auth()->id()) {
            abort(403);
        }

        $pdf = Pdf::loadView('documents.policy', compact('policy'));
        return $pdf->download('policy_' . $policy->policy_number . '.pdf');
    }

    public function showRenewForm(Policy $policy)
    {
        if ($policy->user_id !== auth()->id()) {
            abort(403);
        }
        return view('frontend.renew', compact('policy'));
    }

    public function renew(Request $request, Policy $policy)
    {
        if ($policy->user_id !== auth()->id()) {
            abort(403);
        }

        // Mock Payment
        $newEndDate = $policy->end_date->addYear(); // Assuming 1 year renewal

        PolicyRenewal::create([
            'policy_id' => $policy->id,
            'renewal_date' => now(),
            'new_end_date' => $newEndDate,
            'amount_paid' => $policy->premium_amount,
            'payment_status' => 'success',
        ]);

        $policy->update([
            'end_date' => $newEndDate,
            'next_renewal_date' => $newEndDate->subMonth(), // Reminder 1 month before
            'status' => 'active',
        ]);

        return redirect()->route('home')->with('success', 'Policy renewed successfully! New end date: ' . $newEndDate->format('d M Y'));
    }
}
