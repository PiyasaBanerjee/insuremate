<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Agent;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    use RegistersUsers;

    protected $redirectTo = '/home';

    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Override showRegistrationForm to pass referral code to view.
     */
    public function showRegistrationForm(Request $request)
    {
        $refCode = $request->query('ref');
        return view('auth.register', compact('refCode'));
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    protected function create(array $data)
    {
        // Resolve referral agent if a valid ref code was passed
        $agentId = null;
        if (!empty($data['ref_code'])) {
            $agent = Agent::where('agent_code', $data['ref_code'])
                ->where('status', 'approved')
                ->first();
            if ($agent) {
                $agentId = $agent->id;
            }
        }

        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'referred_by_agent_id' => $agentId,
        ]);
    }
}
