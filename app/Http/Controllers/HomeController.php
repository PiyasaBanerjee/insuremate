<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $policies = \App\Models\Policy::with('plan')->where('user_id', auth()->id())->latest()->get();
        $claims = \App\Models\Claim::with('policy.plan')->where('user_id', auth()->id())->latest()->get();

        return view('home', compact('policies', 'claims'));
    }
}
