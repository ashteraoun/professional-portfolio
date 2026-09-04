<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

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

    public static function storageUrl(?string $path): ?string
    {
        if (! $path) {
            return null;
        }

        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }

        return Storage::disk('public')->url($path);
    }

    public function coverImage(): ?string
    {
        return static::storageUrl(
            $this->hero_image ?? $this->thumbnail ?? $this->gallery->first()?->path
        );
    }

    public function previewImage(): ?string
    {
        return static::storageUrl(
            $this->thumbnail ?? $this->hero_image ?? $this->gallery->first()?->path
        );
    }

    public function toPreviewArray(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'subtitle' => $this->subtitle,
            'excerpt' => $this->excerpt,
            'category' => $this->category?->name,
            'year' => $this->year,
            'role' => $this->role,
            'image' => $this->previewImage(),
            'cover' => $this->coverImage(),
            'live_url' => $this->live_url,
            'github_url' => $this->github_url,
            'video_url' => $this->video_url,
            'url' => route('projects.show', $this->slug),
            'technologies' => $this->technologies->pluck('name'),
            'gallery' => $this->gallery->map(fn ($item) => [
                'path' => static::storageUrl($item->path),
                'alt' => $item->alt ?? $this->title,
            ]),
        ];
    }
}
