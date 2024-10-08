<?php

namespace App\Infrastructure\Repositories;

use App\Domain\Subscription;
use App\Models\Subscription as EloquentSubscription;

class SubscriptionRepository
{
    public function subscriptionExists(int $websiteId, string $email)
    {
        return EloquentSubscription::where('website_id', $websiteId)
                                    ->where('email', $email)
                                    ->exists();
    }

    public function save(Subscription $subscription)
    {
        EloquentSubscription::create([
            'website_id' => $subscription->getWebsiteId(),
            'email' => $subscription->getEmail(),
        ]);
    }

    public function getByWebsiteId(int $websiteId): array
    {
        $subscriptions = EloquentSubscription::where('website_id', $websiteId)->get();

        return $subscriptions->map(function ($subscription) {
            return new Subscription($subscription->website_id, $subscription->email);
        })->toArray();
    }
}
