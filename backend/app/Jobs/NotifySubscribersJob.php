<?php

namespace App\Jobs;

use App\Mail\PostPublishedMail;
use App\Models\Post;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class NotifySubscribersJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $post;

    public function __construct(Post $post)
    {
        $this->post = $post;
    }

    public function handle()
    {
        $subscribers = $this->post->website->subscriptions;

        if ($subscribers) {
            foreach ($subscribers as $subscriber) {
                Mail::to($subscriber->email)->send(new PostPublishedMail($this->post));
            }
        } else {
            // Optionally log or handle cases where there are no subscribers
            Log::info('No subscribers found for website with ID: ' . $this->post->website_id);
        }
    }
}
