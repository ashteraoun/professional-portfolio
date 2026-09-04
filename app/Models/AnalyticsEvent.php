<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnalyticsEvent extends Model
{
    protected $fillable = ['event_type', 'event_label', 'page_url', 'metadata', 'session_id'];

    protected function casts(): array
    {
        return ['metadata' => 'array'];
    }
}
