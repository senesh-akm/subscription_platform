<?php

namespace App\Jobs;

use App\Models\Post;
use App\Models\Subscription;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendPostNotification implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    protected $post;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Post $post)
    {
        $this->post = $post;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $subscriptions = Subscription::where('website_id', $this->post->website_id)->get();

        foreach ($subscriptions as $subscription) {
            $subscriber = $subscription->subscriber;

            Mail::raw("New post published: {$this->post->title}\n\n{$this->post->description}", function ($message) use ($subscriber) {
                $message->to($subscriber->email)
                        ->subject('New Post Notification');
            });
        }
    }
}
