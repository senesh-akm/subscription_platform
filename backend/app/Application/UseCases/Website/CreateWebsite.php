<?php

namespace App\Application\UseCases\Website;

use App\Domain\Website;
use App\Infrastructure\Repositories\WebsiteRepository;

class CreateWebsite
{
    private WebsiteRepository $repository;

    public function __construct(WebsiteRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(string $name, string $url): Website
    {
        $website = new Website($name, $url);
        $this->repository->save($website);
        return $website;
    }
}
