<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * Display the user's profile.
     *
     * @return \Illuminate\View\View
     */
    public function show(Request $request)
    {
        $user = $request->user();
        $orders = $user->orders()->latest()->get();

        return view('auth.profile', compact('user', 'orders'));
    }

    public function edit(Request $request)
    {
        $user = $request->user();

        return view('auth.edit-profile', compact('user'));
    }

    public function update(Request $request)
    {
        $user = $request->user();

        // Different validation rules for Google OAuth users
        $validationRules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'avatar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ];

        // Only require password validation for non-Google users
        if (!$user->google_id) {
            $validationRules['current_password'] = 'required|string';
            $validationRules['password'] = 'nullable|string|min:6|confirmed';
        }

        $data = $request->validate($validationRules);

        // Password verification for non-Google users only
        if (!$user->google_id && !Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Your current password is incorrect.']);
        }

        // Handle password updates for non-Google users only
        if (!$user->google_id && $request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        } else {
            unset($data['password']);
        }

        unset($data['current_password']);
        if ($request->hasFile('avatar')) {
            // Only delete local avatar files, not Google URLs
            if ($user->avatar && !str_starts_with($user->avatar, 'http') && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }

            $avatarPath = $request->file('avatar')->store('avatars', 'public');
            $data['avatar'] = $avatarPath;
        }

        $user->update($data);

        return redirect()->route('profile.show')->with('success', 'Profile updated successfully!');
    }
}
