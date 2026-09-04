<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PortfolioPagesTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(\Database\Seeders\PortfolioSeeder::class);
    }

    public function test_home_page_loads(): void
    {
        $this->get('/')->assertOk()->assertSee('Building Digital Products');
    }

    public function test_projects_index_loads(): void
    {
        $this->get('/projects')->assertOk()->assertSee('Project Alpha');
    }

    public function test_project_detail_loads(): void
    {
        $this->get('/projects/project-alpha')->assertOk()->assertSee('Project Alpha');
    }

    public function test_contact_form_submission(): void
    {
        $this->post('/contact', [
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'message' => 'Hello, I have a project idea.',
        ])->assertRedirect()->assertSessionHas('success');

        $this->assertDatabaseHas('contacts', ['email' => 'jane@example.com']);
    }

    public function test_admin_dashboard_requires_admin(): void
    {
        $user = User::factory()->create(['is_admin' => false]);
        $this->actingAs($user)->get('/admin')->assertForbidden();
    }

    public function test_admin_dashboard_accessible_for_admin(): void
    {
        $admin = User::where('is_admin', true)->first();
        $this->actingAs($admin)->get('/admin')->assertOk();
    }
}
