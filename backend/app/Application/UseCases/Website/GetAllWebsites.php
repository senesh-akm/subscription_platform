<?php

namespace App\Application\UseCases\Website;

use App\Infrastructure\Repositories\WebsiteRepository;

class GetAllWebsites
{
    private WebsiteRepository $repository;

    public function __construct(WebsiteRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(): array
    {
        return $this->repository->getAll();
    }
}
