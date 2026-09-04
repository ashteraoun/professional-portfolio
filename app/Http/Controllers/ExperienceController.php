<?php

namespace App\Http\Controllers;

use App\Models\Experience;
use Illuminate\View\View;

class ExperienceController extends Controller
{
    public function index(): View
    {
        return view('pages.experience', [
            'experiences' => Experience::published()
                ->orderByDesc('started_at')
                ->get(),
        ]);
    }
}
