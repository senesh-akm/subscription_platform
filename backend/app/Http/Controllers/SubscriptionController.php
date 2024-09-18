<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'website_id' => 'required|exists:websites,id',
        ]);

        // Check if the subscription already exists
        $subscriptionExists = Subscription::where('email', $request->email)
            ->where('website_id', $request->website_id)
            ->exists();

        if ($subscriptionExists) {
            return response()->json(['message' => 'Already subscribed'], 409);
        }

        $subscription = Subscription::create([
            'email' => $request->email,
            'website_id' => $request->website_id,
        ]);

        return response()->json($subscription, 201);
    }
}
