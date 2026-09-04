<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\SiteSettingsService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SettingAdminController extends Controller
{
    public function __construct(private SiteSettingsService $settings) {}

    public function edit(): View
    {
        return view('admin.settings.edit', ['settings' => $this->settings->all()]);
    }

    public function update(Request $request): RedirectResponse
    {
        foreach ($request->except('_token', '_method') as $key => $value) {
            $this->settings->set($key, $value);
        }

        return back()->with('success', 'Settings saved.');
    }
}
