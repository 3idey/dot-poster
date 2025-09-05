<?php

namespace App\Http\Controllers;

use App\Models\SavedPaymentMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SavedPaymentMethodController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display the user's saved payment methods
     */
    public function index()
    {
        $savedPaymentMethods = Auth::user()->savedPaymentMethods()->active()->get();
        
        return view('profile.saved-payment-methods.index', compact('savedPaymentMethods'));
    }

    /**
     * Update a saved payment method
     */
    public function update(Request $request, SavedPaymentMethod $savedPaymentMethod)
    {
        // Ensure the user owns this payment method
        if ($savedPaymentMethod->user_id !== Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'nickname' => 'nullable|string|max:255',
            'is_default' => 'nullable|boolean',
        ]);

        // If setting as default, remove default from other payment methods
        if (isset($validated['is_default']) && $validated['is_default']) {
            Auth::user()->savedPaymentMethods()->update(['is_default' => false]);
        }

        $savedPaymentMethod->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Payment method updated successfully',
            'payment_method' => $savedPaymentMethod->fresh()
        ]);
    }

    /**
     * Delete a saved payment method
     */
    public function destroy(SavedPaymentMethod $savedPaymentMethod)
    {
        // Ensure the user owns this payment method
        if ($savedPaymentMethod->user_id !== Auth::id()) {
            abort(403);
        }

        $savedPaymentMethod->delete();

        return response()->json([
            'success' => true,
            'message' => 'Payment method deleted successfully'
        ]);
    }

    /**
     * Set a payment method as default
     */
    public function setDefault(SavedPaymentMethod $savedPaymentMethod)
    {
        // Ensure the user owns this payment method
        if ($savedPaymentMethod->user_id !== Auth::id()) {
            abort(403);
        }

        // Remove default from all user's payment methods
        Auth::user()->savedPaymentMethods()->update(['is_default' => false]);
        
        // Set this one as default
        $savedPaymentMethod->update(['is_default' => true]);

        return response()->json([
            'success' => true,
            'message' => 'Default payment method updated successfully'
        ]);
    }
}
