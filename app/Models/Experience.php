<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Experience extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'company', 'role', 'location', 'started_at', 'ended_at', 'is_current',
        'description', 'responsibilities', 'technologies', 'achievements',
        'projects', 'sort_order', 'is_published',
    ];

    protected function casts(): array
    {
        return [
            'started_at' => 'date',
            'ended_at' => 'date',
            'is_current' => 'boolean',
            'is_published' => 'boolean',
            'responsibilities' => 'array',
            'technologies' => 'array',
            'achievements' => 'array',
            'projects' => 'array',
        ];
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }
}
