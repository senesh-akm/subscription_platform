<?php

namespace App\Domain;

class Post
{
    private string $title;
    private string $description;
    private int $websiteId;

    public function __construct(string $title, string $description, int $websiteId)
    {
        $this->title = $title;
        $this->description = $description;
        $this->websiteId =$websiteId;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getWebsiteId(): int
    {
        return $this->websiteId;
    }
}
