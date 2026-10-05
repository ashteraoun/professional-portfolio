<?php

namespace Tests\Feature;

use App\Models\SiteSetting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class SiteSettingsAdminTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(\Database\Seeders\PortfolioSeeder::class);
    }

    public function test_admin_can_upload_and_remove_site_branding_images(): void
    {
        Storage::fake('public');
        $admin = User::where('is_admin', true)->firstOrFail();

        $this->actingAs($admin)
            ->from(route('admin.settings.edit'))
            ->put(route('admin.settings.update'), [
                'site_name' => 'Updated Portfolio',
                'logo' => UploadedFile::fake()->image('logo.png'),
                'favicon' => UploadedFile::fake()->image('favicon.png'),
            ])
            ->assertRedirect(route('admin.settings.edit'))
            ->assertSessionHasNoErrors();

        $logoPath = SiteSetting::query()->where('key', 'logo_path')->value('value');
        $faviconPath = SiteSetting::query()->where('key', 'favicon_path')->value('value');

        $this->assertIsString($logoPath);
        $this->assertIsString($faviconPath);
        Storage::disk('public')->assertExists($logoPath);
        Storage::disk('public')->assertExists($faviconPath);

        $this->from(route('admin.settings.edit'))
            ->put(route('admin.settings.update'), [
                'site_name' => 'Updated Portfolio',
                'remove_logo' => '1',
                'remove_favicon' => '1',
            ])
            ->assertRedirect(route('admin.settings.edit'))
            ->assertSessionHasNoErrors();

        Storage::disk('public')->assertMissing($logoPath);
        Storage::disk('public')->assertMissing($faviconPath);
        $this->assertDatabaseHas('site_settings', ['key' => 'logo_path', 'value' => null]);
        $this->assertDatabaseHas('site_settings', ['key' => 'favicon_path', 'value' => null]);
    }

    public function test_branding_uploads_reject_non_image_files(): void
    {
        Storage::fake('public');
        $admin = User::where('is_admin', true)->firstOrFail();

        $this->actingAs($admin)
            ->from(route('admin.settings.edit'))
            ->put(route('admin.settings.update'), [
                'site_name' => 'Updated Portfolio',
                'logo' => UploadedFile::fake()->create('logo.txt', 10, 'text/plain'),
            ])
            ->assertRedirect(route('admin.settings.edit'))
            ->assertSessionHasErrors('logo');

        $this->assertDatabaseMissing('site_settings', ['key' => 'logo_path']);
        $this->assertSame('Your Name', SiteSetting::query()->where('key', 'site_name')->value('value'));
    }
}
