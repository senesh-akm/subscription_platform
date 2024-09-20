<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function store(Request $request)
    {
        // Validate request
        $validated = $request->validate([
            'website_id' => 'required|exists:websites,id',
            'email' => 'required|email',
        ]);

        // Create the subscription
        Subscription::create([
            'website_id' => $validated['website_id'],
            'email' => $validated['email'],
        ]);

        // Return a success response
        return response()->json([
            'message' => 'Subscribed successfully.'
        ], 201);
    }
}
