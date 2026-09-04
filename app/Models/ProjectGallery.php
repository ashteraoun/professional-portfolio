<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProjectGallery extends Model
{
    protected $table = 'project_gallery';

    protected $fillable = ['project_id', 'path', 'alt', 'type', 'sort_order'];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }
}
