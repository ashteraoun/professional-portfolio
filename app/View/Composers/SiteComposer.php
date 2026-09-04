<?php

namespace App\View\Composers;

use App\Models\SocialLink;
use App\Services\SiteSettingsService;
use Illuminate\View\View;

class SiteComposer
{
    public function __construct(private SiteSettingsService $settings) {}

    public function compose(View $view): void
    {
        $view->with([
            'site' => $this->settings->all(),
            'socialLinks' => SocialLink::query()
                ->where('is_active', true)
                ->orderBy('sort_order')
                ->get(),
        ]);
    }
}
