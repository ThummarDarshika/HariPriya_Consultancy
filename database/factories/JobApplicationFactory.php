<?php

namespace Database\Factories;

use App\Models\JobApplication;
use App\Models\JobOpening;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<JobApplication>
 */
class JobApplicationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'job_opening_id' => JobOpening::factory(),
            'role_title' => 'Production Engineer',
            'full_name' => fake()->name(),
            'email' => fake()->safeEmail(),
            'phone' => fake()->phoneNumber(),
            'location' => 'Ahmedabad, Gujarat',
            'qualification' => 'B.E. Mechanical Engineering',
            'experience_years' => 3,
            'current_company' => null,
            'notice_period' => null,
            'cover_letter' => fake()->paragraph(),
            'resume_path' => 'job-applications/example.pdf',
        ];
    }
}
