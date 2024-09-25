<?php

namespace App\Infrastructure\Services;

use App\Mail\PostNotification;
use App\Models\Post;
use Illuminate\Support\Facades\Mail;

class NotificationService
{
    public function sendPostNotification(string $email, Post $post): void
    {
        Mail::to($email)->send(new PostNotification($post));
    }
}
