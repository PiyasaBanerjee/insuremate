<?php

namespace App\Http\Controllers;

use App\Models\Policy;
use App\Models\Claim;
use Illuminate\Http\Request;

class ClaimController extends Controller
{
    public function create(Policy $policy)
    {
        // Ensure user owns policy
        if ($policy->user_id !== auth()->id()) {
            abort(403);
        }
        return view('frontend.claims.create', compact('policy'));
    }

    public function store(Request $request, Policy $policy)
    {
        if ($policy->user_id !== auth()->id()) {
            abort(403);
        }

        $request->validate([
            'amount' => 'required|numeric|max:' . $policy->coverage_amount,
            'description' => 'required',
            'document' => 'required|file|mimes:pdf,jpg,png|max:2048',
        ]);

        $path = $request->file('document')->store('claims', 'public');

        $claim = Claim::create([
            'user_id' => auth()->id(),
            'policy_id' => $policy->id,
            'claim_number' => 'CLM-' . strtoupper(uniqid()),
            'claim_amount' => $request->amount,
            'description' => $request->description,
            'documents' => [$path], // Store as array
            'status' => 'pending',
        ]);

        auth()->user()->notify(new \App\Notifications\ClaimSubmittedNotification($claim));

        return redirect()->route('home')->with('success', 'Claim filed successfully. We will review it shortly.');
    }

    public function download(\App\Models\Claim $claim)
    {
        if ($claim->user_id !== auth()->id()) {
            abort(403);
        }

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('documents.claim', compact('claim'));
        return $pdf->download('claim_receipt_' . $claim->claim_number . '.pdf');
    }
}
