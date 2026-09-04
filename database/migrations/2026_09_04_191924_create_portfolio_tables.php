<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('is_admin')->default(false)->after('email');
        });

        Schema::create('site_settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->string('type')->default('string');
            $table->string('group')->default('general');
            $table->timestamps();
        });

        Schema::create('social_links', function (Blueprint $table) {
            $table->id();
            $table->string('platform');
            $table->string('url');
            $table->string('icon')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('technologies', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('category')->nullable();
            $table->string('icon')->nullable();
            $table->text('description')->nullable();
            $table->unsignedInteger('years_experience')->nullable();
            $table->string('confidence_level')->nullable();
            $table->json('related_technologies')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_featured')->default(false);
            $table->timestamps();
        });

        Schema::create('skill_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('skills', function (Blueprint $table) {
            $table->id();
            $table->foreignId('skill_category_id')->constrained()->cascadeOnDelete();
            $table->foreignId('technology_id')->nullable()->constrained()->nullOnDelete();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('experience_level')->nullable();
            $table->unsignedInteger('project_count')->default(0);
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('project_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('color')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_category_id')->nullable()->constrained()->nullOnDelete();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('subtitle')->nullable();
            $table->text('excerpt')->nullable();
            $table->longText('description')->nullable();
            $table->longText('problem')->nullable();
            $table->longText('challenge')->nullable();
            $table->longText('solution')->nullable();
            $table->json('architecture')->nullable();
            $table->json('features')->nullable();
            $table->json('development_process')->nullable();
            $table->json('results')->nullable();
            $table->longText('lessons_learned')->nullable();
            $table->string('role')->nullable();
            $table->string('thumbnail')->nullable();
            $table->string('hero_image')->nullable();
            $table->string('mobile_image')->nullable();
            $table->string('video_url')->nullable();
            $table->string('live_url')->nullable();
            $table->string('github_url')->nullable();
            $table->unsignedSmallInteger('year')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_published')->default(true);
            $table->unsignedInteger('sort_order')->default(0);
            $table->unsignedBigInteger('view_count')->default(0);
            $table->string('seo_title')->nullable();
            $table->text('seo_description')->nullable();
            $table->string('canonical_url')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('project_gallery', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained()->cascadeOnDelete();
            $table->string('path');
            $table->string('alt')->nullable();
            $table->string('type')->default('image');
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('project_technology', function (Blueprint $table) {
            $table->foreignId('project_id')->constrained()->cascadeOnDelete();
            $table->foreignId('technology_id')->constrained()->cascadeOnDelete();
            $table->primary(['project_id', 'technology_id']);
        });

        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('icon')->nullable();
            $table->text('excerpt')->nullable();
            $table->longText('description')->nullable();
            $table->longText('problem')->nullable();
            $table->longText('solution')->nullable();
            $table->json('features')->nullable();
            $table->json('technologies')->nullable();
            $table->json('process')->nullable();
            $table->json('deliverables')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_published')->default(true);
            $table->string('seo_title')->nullable();
            $table->text('seo_description')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('service_features', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->text('description')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('packages', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->decimal('price', 10, 2)->nullable();
            $table->string('billing_type')->default('fixed');
            $table->string('delivery_time')->nullable();
            $table->string('cta_text')->default('Get Started');
            $table->string('cta_url')->nullable();
            $table->boolean('is_recommended')->default(false);
            $table->boolean('is_published')->default(true);
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('package_features', function (Blueprint $table) {
            $table->id();
            $table->foreignId('package_id')->constrained()->cascadeOnDelete();
            $table->string('feature');
            $table->boolean('is_included')->default(true);
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('experiences', function (Blueprint $table) {
            $table->id();
            $table->string('company');
            $table->string('role');
            $table->string('location')->nullable();
            $table->date('started_at');
            $table->date('ended_at')->nullable();
            $table->boolean('is_current')->default(false);
            $table->text('description')->nullable();
            $table->json('responsibilities')->nullable();
            $table->json('technologies')->nullable();
            $table->json('achievements')->nullable();
            $table->json('projects')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_published')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('testimonials', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->nullable()->constrained()->nullOnDelete();
            $table->string('client_name');
            $table->string('client_role')->nullable();
            $table->string('company')->nullable();
            $table->text('content');
            $table->string('avatar')->nullable();
            $table->date('testimonial_date')->nullable();
            $table->boolean('is_published')->default(true);
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('blog_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->timestamps();
        });

        Schema::create('blog_tags', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->timestamps();
        });

        Schema::create('blog_posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('blog_category_id')->nullable()->constrained()->nullOnDelete();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('excerpt')->nullable();
            $table->longText('content');
            $table->string('featured_image')->nullable();
            $table->unsignedSmallInteger('reading_time')->nullable();
            $table->string('status')->default('draft');
            $table->timestamp('published_at')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->string('seo_title')->nullable();
            $table->text('seo_description')->nullable();
            $table->string('canonical_url')->nullable();
            $table->unsignedBigInteger('view_count')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('blog_post_tag', function (Blueprint $table) {
            $table->foreignId('blog_post_id')->constrained()->cascadeOnDelete();
            $table->foreignId('blog_tag_id')->constrained()->cascadeOnDelete();
            $table->primary(['blog_post_id', 'blog_tag_id']);
        });

        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('company')->nullable();
            $table->string('project_type')->nullable();
            $table->string('budget_range')->nullable();
            $table->string('timeline')->nullable();
            $table->text('message');
            $table->string('status')->default('unread');
            $table->string('ip_address', 45)->nullable();
            $table->string('user_agent')->nullable();
            $table->timestamps();
        });

        Schema::create('contact_attachments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('contact_id')->constrained()->cascadeOnDelete();
            $table->string('path');
            $table->string('original_name');
            $table->string('mime_type');
            $table->unsignedBigInteger('size');
            $table->timestamps();
        });

        Schema::create('media', function (Blueprint $table) {
            $table->id();
            $table->string('filename');
            $table->string('path');
            $table->string('disk')->default('public');
            $table->string('mime_type')->nullable();
            $table->unsignedBigInteger('size')->nullable();
            $table->string('alt')->nullable();
            $table->json('metadata')->nullable();
            $table->timestamps();
        });

        Schema::create('analytics_events', function (Blueprint $table) {
            $table->id();
            $table->string('event_type');
            $table->string('event_label')->nullable();
            $table->string('page_url')->nullable();
            $table->json('metadata')->nullable();
            $table->string('session_id')->nullable();
            $table->timestamps();
            $table->index(['event_type', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('analytics_events');
        Schema::dropIfExists('media');
        Schema::dropIfExists('contact_attachments');
        Schema::dropIfExists('contacts');
        Schema::dropIfExists('blog_post_tag');
        Schema::dropIfExists('blog_posts');
        Schema::dropIfExists('blog_tags');
        Schema::dropIfExists('blog_categories');
        Schema::dropIfExists('testimonials');
        Schema::dropIfExists('experiences');
        Schema::dropIfExists('package_features');
        Schema::dropIfExists('packages');
        Schema::dropIfExists('service_features');
        Schema::dropIfExists('services');
        Schema::dropIfExists('project_technology');
        Schema::dropIfExists('project_gallery');
        Schema::dropIfExists('projects');
        Schema::dropIfExists('project_categories');
        Schema::dropIfExists('skills');
        Schema::dropIfExists('skill_categories');
        Schema::dropIfExists('technologies');
        Schema::dropIfExists('social_links');
        Schema::dropIfExists('site_settings');

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('is_admin');
        });
    }
};
