<?php

namespace App\Http\Controllers;

use App\Application\UseCases\Website\CreateWebsite;
use App\Application\UseCases\Website\GetAllWebsites;
use App\Models\Website;
use Illuminate\Http\Request;

class WebsiteController extends Controller
{
    private CreateWebsite $createWebsite;
    private GetAllWebsites $getAllWebsites;

    public function __construct(CreateWebsite $createWebsite, GetAllWebsites $getAllWebsites)
    {
        $this->createWebsite = $createWebsite;
        $this->getAllWebsites = $getAllWebsites;
    }

    public function index()
    {
        $websites = $this->getAllWebsites->execute();
        return response()->json($websites);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'url' => 'required|url|max:255',
        ]);

        $website = $this->createWebsite->execute($validated['name'], $validated['url']);

        return response()->json($website, 201);
    }
}
