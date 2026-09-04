<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Testimonial extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'project_id', 'client_name', 'client_role', 'company', 'content',
        'avatar', 'testimonial_date', 'is_published', 'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'testimonial_date' => 'date',
            'is_published' => 'boolean',
        ];
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }
}
