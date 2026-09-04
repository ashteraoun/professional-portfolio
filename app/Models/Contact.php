<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Contact extends Model
{
    protected $fillable = [
        'name', 'email', 'company', 'project_type', 'budget_range',
        'timeline', 'message', 'status', 'ip_address', 'user_agent',
    ];

    public function attachments(): HasMany
    {
        return $this->hasMany(ContactAttachment::class);
    }
}
