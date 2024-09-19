<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SubscriptionController extends Controller
{
    public function store(Request $request)
    {
        // Validate the incoming request
        $data = $request->validate([
            'email' => 'required|email',
            'website_id' => 'required|exists:websites,id',
        ]);

        // Check if the user is already subscribed
        $exists = DB::table('subscriptions')
                    ->where('email', $data['email'])
                    ->where('website_id', $data['website_id'])
                    ->exists();

        if ($exists) {
            return response()->json(['message' => 'Already subscribed'], 409);
        }

        // Insert the subscription directly into the subscriptions table
        DB::table('subscriptions')->insert([
            'email' => $data['email'],
            'website_id' => $data['website_id'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return response()->json(['message' => 'Subscription created successfully'], 201);
    }
}
