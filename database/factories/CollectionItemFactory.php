<?php

namespace Database\Factories;

use App\Models\CollectionItem;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/** @extends Factory<CollectionItem> */
class CollectionItemFactory extends Factory
{
    protected $model = CollectionItem::class;

    public function definition(): array
    {
        $title = fake()->unique()->sentence(3);

        return [
            'collection' => 'services',
            'title' => $title,
            'slug' => Str::slug($title),
            'description' => fake()->paragraph(),
            'status' => 'published',
            'sort_order' => 0,
        ];
    }
}
