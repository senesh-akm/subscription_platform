<?php

namespace App\Infrastructure\Repositories;

use App\Domain\Website;
use App\Models\Website as EloquentWebsite;

class WebsiteRepository
{
    public function save(Website $website): void
    {
        EloquentWebsite::create([
            'name' => $website->getName(),
            'url' => $website->getUrl(),
        ]);
    }

    public function getAll(): array
    {
        return EloquentWebsite::all()->toArray();
    }
}
