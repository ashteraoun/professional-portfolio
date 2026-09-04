<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Technology extends Model
{
    protected $fillable = [
        'name', 'slug', 'category', 'icon', 'description', 'years_experience',
        'confidence_level', 'related_technologies', 'sort_order', 'is_featured',
    ];

    protected function casts(): array
    {
        return [
            'related_technologies' => 'array',
            'is_featured' => 'boolean',
        ];
    }

    public function projects(): BelongsToMany
    {
        return $this->belongsToMany(Project::class);
    }
}
