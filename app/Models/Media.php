<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    protected $fillable = ['filename', 'path', 'disk', 'mime_type', 'size', 'alt', 'metadata'];

    protected function casts(): array
    {
        return ['metadata' => 'array'];
    }
}
