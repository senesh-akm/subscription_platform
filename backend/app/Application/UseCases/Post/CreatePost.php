<?php

namespace App\Application\UseCases\Post;

use App\Models\Post as EloquentPost;
use App\Infrastructure\Repositories\PostRepository;
use App\Infrastructure\Repositories\SubscriptionRepository;
use App\Infrastructure\Services\NotificationService;

class CreatePost
{
    private PostRepository $postRepository;
    private SubscriptionRepository $subscriptionRepository;
    private NotificationService $notificationService;

    public function __construct(PostRepository $postRepository, SubscriptionRepository $subscriptionRepository, NotificationService $notificationService)
    {
        $this->postRepository = $postRepository;
        $this->subscriptionRepository = $subscriptionRepository;
        $this->notificationService = $notificationService;
    }

    public function execute(string $title, string $description, int $websiteId): void
    {
        // Create the post using Eloquent
        $eloquentPost = EloquentPost::create([
            'title' => $title,
            'description' => $description,
            'website_id' => $websiteId,
        ]);

        // Notify all subscribers using EloquentPost
        $subscribers = $this->subscriptionRepository->getByWebsiteId($websiteId);
        foreach ($subscribers as $subscriber) {
            $this->notificationService->sendPostNotification($subscriber->getEmail(), $eloquentPost);
        }
    }
}
