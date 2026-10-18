<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CollectionItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'collection', 'title', 'slug', 'category', 'description', 'summary',
        'article_subheading', 'video_url', 'price',
        'image', 'icon', 'gallery', 'features', 'status', 'client_name', 'designation', 'company',
        'rating', 'role', 'material', 'capability', 'size_range', 'metric',
        'display_date', 'social_links', 'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'gallery' => 'array',
            'features' => 'array',
            'social_links' => 'array',
            'price' => 'decimal:2',
            'rating' => 'integer',
            'sort_order' => 'integer',
        ];
    }
}
