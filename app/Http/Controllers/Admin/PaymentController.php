<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $query = Payment::with('user', 'policy.plan')->latest();

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('transaction_id', 'like', "%{$s}%")
                    ->orWhereHas('user', fn($u) => $u->where('name', 'like', "%{$s}%")
                        ->orWhere('email', 'like', "%{$s}%"));
            });
        }

        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        if ($request->filled('method') && $request->method !== 'all') {
            $query->where('payment_method', $request->method);
        }

        $payments = $query->paginate(15)->withQueryString();
        $allPayments = Payment::all();
        $totalRevenue = $allPayments->where('status', 'success')->sum('amount');
        $totalCount = $allPayments->count();
        $successCount = $allPayments->where('status', 'success')->count();
        $failedCount = $allPayments->where('status', 'failed')->count();
        $methods = Payment::distinct()->pluck('payment_method')->filter()->values();

        return view('admin.payments.index', compact(
            'payments',
            'totalRevenue',
            'totalCount',
            'successCount',
            'failedCount',
            'methods'
        ));
    }
}
