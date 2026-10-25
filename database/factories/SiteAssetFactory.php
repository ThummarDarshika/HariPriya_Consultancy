<?php

namespace Database\Factories;

use App\Models\SiteAsset;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<SiteAsset>
 */
class SiteAssetFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'key' => fake()->unique()->bothify('test.asset.####'),
            'page' => 'home',
            'label' => fake()->words(3, true),
            'kind' => 'image',
            'value' => '/assets/cta-bg-CKwZ5V_V.png',
        ];
    }
}
