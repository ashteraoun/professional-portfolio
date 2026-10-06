<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use App\Models\Contact;
use App\Models\Project;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Admin', [
            'page' => 'dashboard',
            'stats' => [
                'projects' => Project::count(),
                'posts' => BlogPost::count(),
                'unread_messages' => Contact::where('status', 'unread')->count(),
                'total_messages' => Contact::count(),
            ],
            'recentMessages' => Contact::latest()->limit(5)->get(),
            'popularProjects' => Project::orderByDesc('view_count')->limit(5)->get(),
        ]);
    }
}
