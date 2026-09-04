<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'project_category_id', 'title', 'slug', 'subtitle', 'excerpt', 'description',
        'problem', 'challenge', 'solution', 'architecture', 'features', 'development_process',
        'results', 'lessons_learned', 'role', 'thumbnail', 'hero_image', 'mobile_image',
        'video_url', 'live_url', 'github_url', 'year', 'is_featured', 'is_published',
        'sort_order', 'view_count', 'seo_title', 'seo_description', 'canonical_url',
    ];

    protected function casts(): array
    {
        return [
            'architecture' => 'array',
            'features' => 'array',
            'development_process' => 'array',
            'results' => 'array',
            'is_featured' => 'boolean',
            'is_published' => 'boolean',
            'year' => 'integer',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(ProjectCategory::class, 'project_category_id');
    }

    public function technologies(): BelongsToMany
    {
        return $this->belongsToMany(Technology::class);
    }

    public function gallery(): HasMany
    {
        return $this->hasMany(ProjectGallery::class)->orderBy('sort_order');
    }

    public function testimonials(): HasMany
    {
        return $this->hasMany(Testimonial::class);
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }
}
