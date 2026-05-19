<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureProfileIsComplete
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user()->load('userDetail');

        // Check required profile fields
        if (empty($user->name) || empty($user->userDetail->full_name) || empty($user->userDetail->dob) || empty($user->userDetail->gender) || empty($user->userDetail->designation) || empty($user->userDetail->phone_number ) || empty($user->userDetail->relationship )) {

            return redirect()->route('profile.edit')->with('error', 'please complete you profile first');
        }
        return $next($request);
    }
}
