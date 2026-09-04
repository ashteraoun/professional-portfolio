<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title', 'slug', 'icon', 'excerpt', 'description', 'problem', 'solution',
        'features', 'technologies', 'process', 'deliverables', 'sort_order',
        'is_featured', 'is_published', 'seo_title', 'seo_description',
    ];

    protected function casts(): array
    {
        return [
            'features' => 'array',
            'technologies' => 'array',
            'process' => 'array',
            'deliverables' => 'array',
            'is_featured' => 'boolean',
            'is_published' => 'boolean',
        ];
    }

    public function serviceFeatures(): HasMany
    {
        return $this->hasMany(ServiceFeature::class)->orderBy('sort_order');
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }
}
