<?php

namespace App\Http\Middleware;

use App\Models\SocialLink;
use App\Services\SiteSettingsService;
use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    protected $rootView = 'app';

    public function share(Request $request): array
    {
        return [
            ...parent::share($request),
            'site' => fn () => app(SiteSettingsService::class)->all(),
            'socialLinks' => fn () => SocialLink::query()
                ->where('is_active', true)
                ->orderBy('sort_order')
                ->get(['platform', 'url']),
            'auth' => [
                'user' => fn () => $request->user(),
            ],
            'flash' => [
                'success' => fn () => $request->session()->get('success'),
                'status' => fn () => $request->session()->get('status'),
                'error' => fn () => $request->session()->get('error'),
            ],
        ];
    }
}
