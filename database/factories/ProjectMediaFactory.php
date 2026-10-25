<?php

namespace Database\Factories;

use App\Models\ProjectMedia;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ProjectMedia>
 */
class ProjectMediaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->words(3, true),
            'media_type' => 'image',
            'file_path' => '/storage/project-media/sample.jpg',
            'sort_order' => 0,
            'is_active' => true,
        ];
    }

    public function video(): static
    {
        return $this->state(fn (): array => [
            'media_type' => 'video',
            'file_path' => '/storage/project-media/sample.mp4',
        ]);
    }
}
