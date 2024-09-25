<?php

namespace App\Domain;

class Subscription
{
    private int $websiteId;
    private string $email;

    public function __construct(int $websiteId, string $email)
    {
        $this->websiteId = $websiteId;
        $this->email = $email;
    }

    public function getWebsiteId(): int
    {
        return $this->websiteId;
    }

    public function getEmail(): string
    {
        return $this->email;
    }
}
