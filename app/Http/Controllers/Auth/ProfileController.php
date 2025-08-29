<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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

        $data = $request->validate([
            'name'            => 'required|string|max:255',
            'email'           => 'required|email|unique:users,email,' . $user->id,
            'phone'           => 'nullable|string|max:20',
            'address'         => 'nullable|string|max:255',
            'current_password' => 'required|string',
            'password'        => 'nullable|string|min:6|confirmed',
        ]);

        if (!Hash::check($data['current_password'], $user->password)) {
            return back()->withErrors(['current_password' => 'Your current password is incorrect.']);
        }

        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        unset($data['current_password']);

        $user->update($data);

        return redirect()->route('profile.show')->with('success', 'Profile updated successfully!');
    }
}
