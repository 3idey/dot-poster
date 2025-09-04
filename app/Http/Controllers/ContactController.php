<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactFormSubmission;

class ContactController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|in:general,order,artist,technical,feedback',
            'message' => 'required|string|max:2000',
        ]);

        // Send email notification
        try {
            Mail::to(config('mail.contact_email', 'hello@dotposter.com'))
                ->send(new ContactFormSubmission($validated));
            
            return redirect()->back()->with('success', 'Thank you for your message! We\'ll get back to you within 24 hours.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Sorry, there was an issue sending your message. Please try again later.');
        }
    }
}
