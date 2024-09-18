<?php

namespace App\Http\Controllers;

use App\Models\Website;
use Illuminate\Http\Request;

class WebsiteController extends Controller
{
    public function index()
    {
        $websites = Website::all();
        return response()->json($websites, 200); // Ensure status 200 for retrieval
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'url' => 'required|url|unique:websites,url',
        ]);

        $website = Website::create($request->all());

        return response()->json($website, 201); // Ensure status 201 for creation
    }
}
