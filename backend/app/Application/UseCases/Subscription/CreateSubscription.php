<?php

namespace App\Application\UseCases\Subscription;

use App\Domain\Subscription;
use App\Infrastructure\Repositories\SubscriptionRepository;

class CreateSubscription
{
    private SubscriptionRepository $repository;

    public function __construct(SubscriptionRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(int $websiteId, string $email): Subscription
    {
        if ($this->repository->subscriptionExists($websiteId, $email)) {
            throw new \Exception('Already subscribed');
        }

        $subscription = new Subscription($websiteId, $email);
        $this->repository->save($subscription);

        return $subscription;
    }
}
