<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'subscriber_id' => 'required|exists:subscribers,id',
            'website_id' => 'required|exists:websites,id',
        ]);

        $subscription = Subscription::create($request->all());

        return response()->json($subscription, 201);
    }
}
