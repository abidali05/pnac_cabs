<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\UserDetail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        $user_detail = UserDetail::where('user_id', auth()->user()->id)->first();
        return view('profile.edit', [
            'user' => $request->user(),
            'user_detail' => $user_detail,
        ]);
    }

    /**
     * Update the user's profile information.
     */
  public function update(ProfileUpdateRequest $request): RedirectResponse
{
    $user = $request->user();

    // Update User table fields
    $user->fill($request->only(['name', 'email']));

    if ($user->isDirty('email')) {
        $user->email_verified_at = null;
    }

    // Handle image upload
    if ($request->hasFile('image')) {
        $file = $request->file('image');
        $filename = time() . '_' . $file->getClientOriginalName();
        $file->storeAs('public/profile_images', $filename);
        $user->image = $filename;
    }

    $user->save();

    // Update or create UserDetail
    $user->userDetail()->updateOrCreate(
        ['user_id' => $user->id],
        $request->only([
            'full_name',
            'dob',
            'gender',
            'designation',
            'home_address',
            'phone_number',
            'office_no',
            'fax_no',
            'relationship'
        ])
    );

    return Redirect::route('dashboard')->with('success', 'Profile updated successfully');
}

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
