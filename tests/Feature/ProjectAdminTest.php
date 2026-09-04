<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProjectAdminTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(\Database\Seeders\PortfolioSeeder::class);
    }

    public function test_admin_can_update_project(): void
    {
        $admin = User::where('is_admin', true)->first();
        $project = Project::first();

        $response = $this->actingAs($admin)->put(route('admin.projects.update', $project), [
            'title' => 'Updated Project Title',
            'subtitle' => 'Updated subtitle',
            'year' => 2025,
            'is_published' => '1',
            'is_featured' => '1',
            'sort_order' => 99,
        ]);

        $response->assertRedirect(route('admin.projects.edit', $project));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('projects', [
            'id' => $project->id,
            'title' => 'Updated Project Title',
            'sort_order' => 99,
        ]);
    }

    public function test_edit_page_project_form_has_no_nested_forms(): void
    {
        $admin = User::where('is_admin', true)->first();
        $project = Project::first();

        $html = $this->actingAs($admin)
            ->get(route('admin.projects.edit', $project))
            ->assertOk()
            ->getContent();

        $this->assertStringContainsString('data-project-form', $html);
        $this->assertStringNotContainsString('projects.gallery.destroy', $html);
    }
}
