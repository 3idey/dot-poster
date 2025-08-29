<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function create()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|max:254|confirmed',
            'phone' => 'required|numeric|digits_between:10,15',
            'address' => 'required|max:255',
            'city' => 'required|max:100',
            'avatar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);
        $avatarPath = null;
        if ($request->hasFile('avatar')) {
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'city' => $request->city,
            'address' => $request->address,
            'avatar' => $avatarPath,
            'password' => Hash::make($request->password),
        ]);

        \Illuminate\Support\Facades\Auth::login($user);

        return redirect('/')->with('success', 'Account created successfully.');
    }
}
