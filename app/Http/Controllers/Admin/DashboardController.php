<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use App\Models\Contact;
use App\Models\Project;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        return view('admin.dashboard', [
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
