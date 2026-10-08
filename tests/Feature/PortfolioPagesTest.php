<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;
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

    public function test_contact_form_sends_whatsapp_template_notification_when_configured(): void
    {
        Http::fake();
        config([
            'services.whatsapp.access_token' => 'test-access-token',
            'services.whatsapp.phone_number_id' => '123456789',
            'services.whatsapp.to' => '+923446622635',
            'services.whatsapp.template_name' => 'new_contact_inquiry',
            'services.whatsapp.template_language' => 'en_US',
            'services.whatsapp.api_version' => 'v23.0',
        ]);

        $this->post('/contact', [
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'company' => 'Example Co',
            'project_type' => 'Website',
            'message' => 'Hello, I have a project idea.',
        ])->assertRedirect()->assertSessionHas('success');

        Http::assertSent(fn (Request $request) => $request->url()
            === 'https://graph.facebook.com/v23.0/123456789/messages'
            && $request->hasHeader('Authorization', 'Bearer test-access-token')
            && $request->data()['messaging_product'] === 'whatsapp'
            && $request->data()['to'] === '923446622635'
            && $request->data()['template']['name'] === 'new_contact_inquiry'
            && str_contains(
                $request->data()['template']['components'][0]['parameters'][0]['text'],
                'Hello, I have a project idea.'
            ));
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
