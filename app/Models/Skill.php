<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Skill extends Model
{
    protected $fillable = [
        'skill_category_id', 'technology_id', 'name', 'description',
        'experience_level', 'project_count', 'sort_order',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(SkillCategory::class, 'skill_category_id');
    }

    public function technology(): BelongsTo
    {
        return $this->belongsTo(Technology::class);
    }
}
