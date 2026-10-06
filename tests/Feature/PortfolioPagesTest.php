<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia as Assert;
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
        $this->get('/')->assertOk()->assertInertia(fn (Assert $page) => $page
            ->component('Portfolio')
            ->where('page', 'home')
            ->has('featuredProjects'));
    }

    public function test_projects_index_loads(): void
    {
        $this->get('/projects')->assertOk()->assertInertia(fn (Assert $page) => $page
            ->component('Portfolio')
            ->where('page', 'projects-index')
            ->has('projects.data')
            ->where('projects.data.0.slug', 'project-alpha'));
    }

    public function test_project_detail_loads(): void
    {
        $this->get('/projects/project-alpha')->assertOk()->assertInertia(fn (Assert $page) => $page
            ->component('Portfolio')
            ->where('page', 'project-show')
            ->where('project.slug', 'project-alpha'));
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
