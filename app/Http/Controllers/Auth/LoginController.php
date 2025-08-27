<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function create()
    {
        return view('auth.login');
    }

    public function store()
    {
        $attributes = request()->validate([
            'login' => ['required', function ($attribute, $value, $fail) {
                if (! filter_var($value, FILTER_VALIDATE_EMAIL) && ! preg_match('/^01[0-2,5]{1}[0-9]{8}$/', $value)) {
                    $fail('The login must be a valid email address or Egyptian phone number.');
                }
            }],
            'password' => ['required', 'min:6', 'max:254'],
        ]);

        $field = filter_var($attributes['login'], FILTER_VALIDATE_EMAIL) ? 'email' : 'phone_number';

        if (! Auth::attempt([
            $field => $attributes['login'],
            'password' => $attributes['password'],
        ])) {
            throw ValidationException::withMessages([
                'login' => 'Invalid credentials.',
            ]);
        }

        request()->session()->regenerate();

        return redirect('/');
    }

    public function destroy()
    {
        Auth::logout();

        return redirect('/');
    }
}
