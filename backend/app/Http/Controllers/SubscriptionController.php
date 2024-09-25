<?php

namespace App\Http\Controllers;

use App\Application\UseCases\Subscription\CreateSubscription;
use Exception;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    private CreateSubscription $createSubscription;

    public function __construct(CreateSubscription $createSubscription)
    {
        $this->createSubscription =$createSubscription;
    }

    public function store(Request $request)
    {
        // Validate request
        $validated = $request->validate([
            'website_id' => 'required|exists:websites,id',
            'email' => 'required|email',
        ]);

        try {
            // Execute the use case
            $this->createSubscription->execute($validated['website_id'], $validated['email']);

            // Return a success response
            return response()->json(['message' => 'Subscribed successfully.'], 201);
        } catch (Exception $e) {
            // Handle the 'Already subscribed' case or any other error
            return response()->json(['message' => $e->getMessage()], 409);
        }
    }
}
