<?php

namespace Database\Seeders;

use App\Models\BlogCategory;
use App\Models\BlogPost;
use App\Models\BlogTag;
use App\Models\Experience;
use App\Models\Package;
use App\Models\PackageFeature;
use App\Models\Project;
use App\Models\ProjectCategory;
use App\Models\Service;
use App\Models\SiteSetting;
use App\Models\Skill;
use App\Models\SkillCategory;
use App\Models\SocialLink;
use App\Models\Technology;
use App\Models\User;
use App\Services\SiteSettingsService;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class PortfolioSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::updateOrCreate(
            ['email' => 'admin@portfolio.test'],
            [
                'name' => 'Portfolio Admin',
                'password' => Hash::make('password'),
                'is_admin' => true,
                'email_verified_at' => now(),
            ]
        );

        $this->seedSettings();
        $this->seedSocialLinks();
        $technologies = $this->seedTechnologies();
        $this->seedSkills($technologies);
        $categories = $this->seedProjectCategories();
        $this->seedProjects($categories, $technologies);
        $this->seedServices();
        $this->seedPackages();
        $this->seedExperiences();
        $this->seedBlog($admin);

        app(SiteSettingsService::class)->forget();
    }

    private function seedSettings(): void
    {
        $settings = [
            'site_name' => 'Your Name',
            'site_tagline' => 'Software Engineer & Full-Stack Developer',
            'hero_status' => 'AVAILABLE FOR SELECT PROJECTS',
            'hero_headline' => 'Building Digital Products That Move Ideas Forward.',
            'hero_subheadline' => 'I design and engineer scalable web applications, SaaS platforms, and AI-integrated products — from architecture to deployment.',
            'hero_cta_primary' => 'View Selected Work',
            'hero_cta_secondary' => "Let's Talk",
            'years_experience' => '5+',
            'projects_delivered' => '30+',
            'location' => 'Remote · UTC+5',
            'about_intro' => 'I am a software engineer focused on building thoughtful digital products. My work spans full-stack development, API design, and product engineering — always with an emphasis on clarity, performance, and maintainability.',
            'about_philosophy' => 'Great software is not just functional — it is intentional. I prioritize user experience, clean architecture, and shipping work that teams can evolve confidently.',
            'footer_statement' => 'Have an idea worth building?',
            'footer_cta' => 'Start a Conversation',
            'contact_email' => 'hello@yourdomain.com',
            'seo_default_title' => 'Software Engineer Portfolio',
            'seo_default_description' => 'Professional portfolio showcasing full-stack development, SaaS engineering, and digital product work.',
            'github_url' => 'https://github.com',
            'linkedin_url' => 'https://linkedin.com',
            'resume_url' => '/resume',
        ];

        foreach ($settings as $key => $value) {
            SiteSetting::updateOrCreate(['key' => $key], ['value' => $value, 'type' => 'string', 'group' => 'general']);
        }
    }

    private function seedSocialLinks(): void
    {
        $links = [
            ['platform' => 'GitHub', 'url' => 'https://github.com', 'icon' => 'github', 'sort_order' => 1],
            ['platform' => 'LinkedIn', 'url' => 'https://linkedin.com', 'icon' => 'linkedin', 'sort_order' => 2],
            ['platform' => 'Email', 'url' => 'mailto:hello@yourdomain.com', 'icon' => 'mail', 'sort_order' => 3],
        ];

        foreach ($links as $link) {
            SocialLink::updateOrCreate(['platform' => $link['platform']], $link + ['is_active' => true]);
        }
    }

    private function seedTechnologies(): array
    {
        $items = [
            ['name' => 'Laravel', 'slug' => 'laravel', 'category' => 'Backend', 'is_featured' => true, 'years_experience' => 4, 'confidence_level' => 'Production'],
            ['name' => 'React', 'slug' => 'react', 'category' => 'Frontend', 'is_featured' => true, 'years_experience' => 4, 'confidence_level' => 'Production'],
            ['name' => 'JavaScript', 'slug' => 'javascript', 'category' => 'Frontend', 'is_featured' => true, 'years_experience' => 5, 'confidence_level' => 'Production'],
            ['name' => 'TypeScript', 'slug' => 'typescript', 'category' => 'Frontend', 'is_featured' => true],
            ['name' => 'PHP', 'slug' => 'php', 'category' => 'Backend', 'is_featured' => true],
            ['name' => 'MySQL', 'slug' => 'mysql', 'category' => 'Database', 'is_featured' => true],
            ['name' => 'Node.js', 'slug' => 'nodejs', 'category' => 'Backend', 'is_featured' => true],
            ['name' => 'AI / LLMs', 'slug' => 'ai', 'category' => 'AI', 'is_featured' => true],
            ['name' => 'Docker', 'slug' => 'docker', 'category' => 'DevOps'],
            ['name' => 'Git', 'slug' => 'git', 'category' => 'DevOps'],
        ];

        $map = [];
        foreach ($items as $i => $item) {
            $map[$item['slug']] = Technology::updateOrCreate(
                ['slug' => $item['slug']],
                $item + ['sort_order' => $i + 1, 'related_technologies' => []]
            );
        }

        return $map;
    }

    private function seedSkills(array $technologies): void
    {
        $categories = [
            'Frontend' => ['React', 'TypeScript', 'JavaScript', 'Tailwind CSS'],
            'Backend' => ['Laravel', 'PHP', 'Node.js', 'REST APIs'],
            'Database' => ['MySQL', 'Redis', 'Database Design'],
            'AI' => ['LLM Integration', 'AI APIs', 'NLP Workflows'],
            'DevOps' => ['Git', 'Docker', 'CI/CD'],
        ];

        $order = 1;
        foreach ($categories as $name => $skills) {
            $cat = SkillCategory::updateOrCreate(
                ['slug' => Str::slug($name)],
                ['name' => $name, 'sort_order' => $order++]
            );

            foreach ($skills as $j => $skillName) {
                $tech = collect($technologies)->first(fn ($t) => str_contains(strtolower($skillName), strtolower($t->name)));
                Skill::updateOrCreate(
                    ['skill_category_id' => $cat->id, 'name' => $skillName],
                    [
                        'technology_id' => $tech?->id,
                        'experience_level' => 'Production',
                        'project_count' => rand(3, 12),
                        'sort_order' => $j + 1,
                    ]
                );
            }
        }
    }

    private function seedProjectCategories(): array
    {
        $cats = [
            ['name' => 'Web Application', 'slug' => 'web', 'color' => '#22d3ee'],
            ['name' => 'SaaS', 'slug' => 'saas', 'color' => '#a78bfa'],
            ['name' => 'AI Product', 'slug' => 'ai', 'color' => '#f59e0b'],
            ['name' => 'Backend / API', 'slug' => 'backend', 'color' => '#34d399'],
        ];

        $map = [];
        foreach ($cats as $i => $cat) {
            $map[$cat['slug']] = ProjectCategory::updateOrCreate(['slug' => $cat['slug']], $cat + ['sort_order' => $i + 1]);
        }

        return $map;
    }

    private function seedProjects(array $categories, array $technologies): void
    {
        $projects = [
            [
                'title' => 'Project Alpha',
                'slug' => 'project-alpha',
                'category' => 'saas',
                'subtitle' => 'Multi-tenant SaaS platform',
                'excerpt' => 'A scalable SaaS application with subscription billing, role-based access, and real-time dashboards.',
                'role' => 'Lead Full-Stack Developer',
                'year' => 2025,
                'is_featured' => true,
                'tech' => ['laravel', 'react', 'mysql', 'docker'],
                'problem' => 'The client needed a reliable SaaS foundation that could onboard teams quickly without sacrificing security or performance.',
                'solution' => 'Designed a modular Laravel backend with React frontend, implementing tenant isolation, queued jobs, and a clean API layer.',
            ],
            [
                'title' => 'Insight Engine',
                'slug' => 'insight-engine',
                'category' => 'ai',
                'subtitle' => 'AI-assisted analytics workflow',
                'excerpt' => 'An internal tool that transforms unstructured data into actionable insights using LLM-powered pipelines.',
                'role' => 'Full-Stack Engineer',
                'year' => 2024,
                'is_featured' => true,
                'tech' => ['laravel', 'react', 'ai', 'nodejs'],
                'problem' => 'Teams spent hours manually summarizing reports and extracting patterns from large document sets.',
                'solution' => 'Built an AI integration layer with caching, prompt orchestration, and human-in-the-loop review workflows.',
            ],
            [
                'title' => 'Commerce Core',
                'slug' => 'commerce-core',
                'category' => 'web',
                'subtitle' => 'High-performance e-commerce platform',
                'excerpt' => 'Custom storefront and admin system optimized for conversion, inventory management, and checkout reliability.',
                'role' => 'Full-Stack Developer',
                'year' => 2024,
                'is_featured' => true,
                'tech' => ['laravel', 'javascript', 'mysql'],
            ],
            [
                'title' => 'API Gateway Hub',
                'slug' => 'api-gateway-hub',
                'category' => 'backend',
                'subtitle' => 'Unified API orchestration layer',
                'excerpt' => 'Centralized API gateway with authentication, rate limiting, and observability for microservices.',
                'role' => 'Backend Engineer',
                'year' => 2023,
                'is_featured' => false,
                'tech' => ['laravel', 'php', 'docker'],
            ],
        ];

        foreach ($projects as $i => $data) {
            $techSlugs = $data['tech'];
            unset($data['tech'], $data['category']);

            $project = Project::updateOrCreate(
                ['slug' => $data['slug']],
                array_merge($data, [
                    'project_category_id' => $categories[$projects[$i]['category'] ?? 'web']->id ?? null,
                    'description' => $data['excerpt'],
                    'challenge' => $data['problem'] ?? null,
                    'solution' => $data['solution'] ?? null,
                    'architecture' => ['frontend' => 'React', 'backend' => 'Laravel', 'database' => 'MySQL'],
                    'features' => ['Authentication', 'Admin dashboard', 'API layer', 'Responsive UI'],
                    'development_process' => ['Research', 'Architecture', 'Development', 'Testing', 'Deployment'],
                    'is_published' => true,
                    'sort_order' => $i + 1,
                    'seo_title' => $data['title'].' — Case Study',
                ])
            );

            $project->technologies()->sync(
                collect($techSlugs)->map(fn ($s) => $technologies[$s]->id ?? null)->filter()->values()
            );
        }
    }

    private function seedServices(): void
    {
        $services = [
            ['title' => 'Full-Stack Development', 'slug' => 'full-stack-development', 'icon' => 'layers', 'excerpt' => 'End-to-end product development from database design to polished interfaces.'],
            ['title' => 'SaaS Development', 'slug' => 'saas-development', 'icon' => 'cloud', 'excerpt' => 'Subscription platforms, multi-tenancy, billing integrations, and scalable architecture.'],
            ['title' => 'AI Integration', 'slug' => 'ai-integration', 'icon' => 'cpu', 'excerpt' => 'Practical AI features embedded into real products — not demos.'],
            ['title' => 'API & Backend Engineering', 'slug' => 'api-backend', 'icon' => 'server', 'excerpt' => 'Robust APIs, authentication, queues, caching, and performance optimization.'],
            ['title' => 'UI/UX Implementation', 'slug' => 'ui-ux', 'icon' => 'layout', 'excerpt' => 'Translating design systems into responsive, accessible frontends.'],
            ['title' => 'Performance & Optimization', 'slug' => 'performance', 'icon' => 'zap', 'excerpt' => 'Core Web Vitals, query optimization, and frontend bundle reduction.'],
        ];

        foreach ($services as $i => $service) {
            Service::updateOrCreate(
                ['slug' => $service['slug']],
                array_merge($service, [
                    'description' => $service['excerpt'],
                    'technologies' => ['Laravel', 'React', 'MySQL'],
                    'process' => ['Discovery', 'Planning', 'Build', 'Launch', 'Support'],
                    'deliverables' => ['Source code', 'Documentation', 'Deployment support'],
                    'is_featured' => true,
                    'is_published' => true,
                    'sort_order' => $i + 1,
                ])
            );
        }
    }

    private function seedPackages(): void
    {
        $packages = [
            [
                'name' => 'Starter',
                'slug' => 'starter',
                'description' => 'For personal brands and small businesses launching their first professional web presence.',
                'price' => 2500,
                'delivery_time' => '2–3 weeks',
                'is_recommended' => false,
                'features' => ['Up to 5 pages', 'Responsive design', 'Contact form', 'Basic SEO setup', '2 revision rounds'],
            ],
            [
                'name' => 'Professional',
                'slug' => 'professional',
                'description' => 'For growing businesses that need a custom web application with admin capabilities.',
                'price' => 7500,
                'delivery_time' => '4–6 weeks',
                'is_recommended' => true,
                'features' => ['Custom web application', 'Admin dashboard', 'Database-driven CMS', 'API integration', 'Performance optimization', '4 revision rounds'],
            ],
            [
                'name' => 'Premium',
                'slug' => 'premium',
                'description' => 'For advanced digital products requiring complex architecture and ongoing collaboration.',
                'price' => 15000,
                'delivery_time' => '8–12 weeks',
                'is_recommended' => false,
                'features' => ['Full product architecture', 'SaaS / multi-tenant ready', 'AI feature integration', 'Advanced analytics', 'Priority support', 'Post-launch iteration'],
            ],
        ];

        foreach ($packages as $i => $pkg) {
            $features = $pkg['features'];
            unset($pkg['features']);

            $package = Package::updateOrCreate(
                ['slug' => $pkg['slug']],
                array_merge($pkg, [
                    'billing_type' => 'fixed',
                    'cta_text' => 'Discuss Project',
                    'cta_url' => '/contact',
                    'is_published' => true,
                    'sort_order' => $i + 1,
                ])
            );

            $package->features()->delete();
            foreach ($features as $j => $feature) {
                PackageFeature::create([
                    'package_id' => $package->id,
                    'feature' => $feature,
                    'is_included' => true,
                    'sort_order' => $j + 1,
                ]);
            }
        }
    }

    private function seedExperiences(): void
    {
        $items = [
            [
                'company' => '[Company Name]',
                'role' => 'Senior Software Engineer',
                'started_at' => '2023-01-01',
                'is_current' => true,
                'description' => 'Leading full-stack development for customer-facing products and internal platforms.',
                'responsibilities' => ['Architect scalable features', 'Mentor junior developers', 'Own deployment pipelines'],
                'technologies' => ['Laravel', 'React', 'MySQL', 'Docker'],
                'achievements' => ['Reduced page load time through targeted optimization', 'Shipped major product modules on schedule'],
            ],
            [
                'company' => '[Previous Company]',
                'role' => 'Full-Stack Developer',
                'started_at' => '2021-06-01',
                'ended_at' => '2022-12-31',
                'is_current' => false,
                'description' => 'Built and maintained web applications for diverse client projects.',
                'responsibilities' => ['Develop REST APIs', 'Implement responsive UIs', 'Write automated tests'],
                'technologies' => ['PHP', 'JavaScript', 'Laravel', 'Vue.js'],
            ],
        ];

        foreach ($items as $i => $item) {
            Experience::updateOrCreate(
                ['company' => $item['company'], 'role' => $item['role']],
                array_merge($item, ['sort_order' => $i + 1, 'is_published' => true])
            );
        }
    }

    private function seedBlog(User $admin): void
    {
        $category = BlogCategory::updateOrCreate(
            ['slug' => 'engineering'],
            ['name' => 'Engineering', 'description' => 'Technical articles and development insights.']
        );

        $tag = BlogTag::updateOrCreate(['slug' => 'laravel'], ['name' => 'Laravel']);

        BlogPost::updateOrCreate(
            ['slug' => 'building-scalable-laravel-apis'],
            [
                'user_id' => $admin->id,
                'blog_category_id' => $category->id,
                'title' => 'Building Scalable Laravel APIs',
                'excerpt' => 'Principles for designing APIs that remain maintainable as products grow.',
                'content' => "## Introduction\n\nScalable APIs start with clear boundaries.\n\n## Validation & Resources\n\nUse form requests and API resources consistently.\n\n## Caching Strategy\n\nCache expensive queries thoughtfully.\n\n```php\nCache::remember('projects.featured', 3600, fn () => Project::featured()->get());\n```\n\n## Conclusion\n\nInvest in conventions early — they compound over time.",
                'reading_time' => 5,
                'status' => 'published',
                'published_at' => now()->subDays(7),
                'is_featured' => true,
                'seo_title' => 'Building Scalable Laravel APIs',
                'seo_description' => 'A practical guide to Laravel API architecture.',
            ]
        )->tags()->sync([$tag->id]);
    }
}
