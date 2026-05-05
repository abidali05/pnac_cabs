<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use App\Models\UserDetail;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {   
        // dd($request->all());
        // $request->authenticate();

        // $request->session()->regenerate();
        // return redirect()->intended(RouteServiceProvider::HOME)
        // ->with('success', 'You are logged in successfully!');
        $user = DB::table('users')->where('email', $request->email)->first();
        // dd($user);
        if (!$user) {
            return redirect('/')->with('error', 'Email not found');
        } else {
            if ($user->status == 1) {
                $request->authenticate();
                $request->session()->regenerate();
                $user_detail = Auth::user();
                $user = $user_detail->load('userDetail');
                //  dd($user->name);

                if (
                    empty($user->name) ||
                    empty($user->userDetail?->phone_number) ||
                    empty($user->userDetail?->full_name) ||
                    empty($user->userDetail?->dob) ||
                    empty($user->userDetail?->gender) ||
                    empty($user->userDetail?->designation)
                ) {
                    return redirect()->route('profile.edit');
                }else{

                    return redirect()->route('dashboard');
                }

            } else {
                return redirect('/')->with('messages', 'Your Account is not Active please check your email to active your account');
            }
        }
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
