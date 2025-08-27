<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;

class RegisterController extends Controller
{
    public function create()
    {
        return view('auth.register');
    }

    public function store()
    {
        $attributes = request()->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|max:254|confirmed',
            'phone_number' => 'required|numeric|digits_between:10,15',
            'address' => 'required|max:255',
            'city' => 'required|max:100',
        ]);

        $user = \App\Models\User::create($attributes);

        \Illuminate\Support\Facades\Auth::login($user);

        return redirect('/');
    }
}
