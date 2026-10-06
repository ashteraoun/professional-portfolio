<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use App\Models\Project;
use App\Models\Service;
use App\Models\Technology;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class SearchController extends Controller
{
    public function index(Request $request): Response
    {
        $query = trim($request->query('q', ''));

        if ($query === '') {
            return Inertia::render('Portfolio', [
                'page' => 'search',
                'query' => '',
                'projects' => collect(),
                'posts' => collect(),
                'services' => collect(),
                'technologies' => collect(),
            ]);
        }

        return Inertia::render('Portfolio', [
            'page' => 'search',
            'query' => $query,
            'projects' => Project::published()
                ->where('title', 'like', "%{$query}%")
                ->orWhere('excerpt', 'like', "%{$query}%")
                ->limit(10)
                ->get(),
            'posts' => BlogPost::published()
                ->where('title', 'like', "%{$query}%")
                ->orWhere('excerpt', 'like', "%{$query}%")
                ->limit(10)
                ->get(),
            'services' => Service::published()
                ->where('title', 'like', "%{$query}%")
                ->limit(5)
                ->get(),
            'technologies' => Technology::query()
                ->where('name', 'like', "%{$query}%")
                ->limit(10)
                ->get(),
        ]);
    }
}
