<?php

namespace Database\Factories;

use App\Models\SiteContent;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<SiteContent> */
class SiteContentFactory extends Factory
{
    protected $model = SiteContent::class;

    public function definition(): array
    {
        return [
            'page' => 'home',
            'key' => 'home/main/section:0/text:'.fake()->unique()->numberBetween(1, 100000),
            'type' => 'text',
            'value' => fake()->sentence(),
        ];
    }
}
