<?php

namespace App\Http\Controllers;

use App\Models\Newsletter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class NewsletterController extends Controller
{
    public function subscribe(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Please provide a valid email address.'
            ], 422);
        }

        $email = $request->email;

        // Check if email already exists
        $existing = Newsletter::where('email', $email)->first();

        if ($existing) {
            if ($existing->is_active) {
                return response()->json([
                    'success' => false,
                    'message' => 'You are already subscribed to our newsletter!'
                ]);
            } else {
                // Reactivate subscription
                $existing->update([
                    'is_active' => true,
                    'subscribed_at' => now(),
                    'unsubscribed_at' => null
                ]);
                
                return response()->json([
                    'success' => true,
                    'message' => 'Welcome back! Your subscription has been reactivated.'
                ]);
            }
        }

        // Create new subscription
        Newsletter::create([
            'email' => $email,
            'subscribed_at' => now(),
            'is_active' => true
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Thank you for subscribing! You\'ll receive updates about new posters and exclusive offers.'
        ]);
    }

    public function unsubscribe(Request $request)
    {
        $email = $request->email;

        if (!$email) {
            return redirect()->back()->with('error', 'Email address is required.');
        }

        $subscription = Newsletter::where('email', $email)->first();

        if (!$subscription) {
            return redirect()->back()->with('error', 'Email address not found in our newsletter list.');
        }

        $subscription->update([
            'is_active' => false,
            'unsubscribed_at' => now()
        ]);

        return redirect()->back()->with('success', 'You have been successfully unsubscribed from our newsletter.');
    }
}
