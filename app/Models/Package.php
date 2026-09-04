<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Package extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name', 'slug', 'description', 'price', 'billing_type', 'delivery_time',
        'cta_text', 'cta_url', 'is_recommended', 'is_published', 'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'is_recommended' => 'boolean',
            'is_published' => 'boolean',
        ];
    }

    public function features(): HasMany
    {
        return $this->hasMany(PackageFeature::class)->orderBy('sort_order');
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }
}
