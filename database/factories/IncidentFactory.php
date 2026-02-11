<?php

namespace Database\Factories;

use App\Models\Incident;
use App\Models\PromptCheck;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Incident>
 */
class IncidentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<\Illuminate\Database\Eloquent\Model>
     */
    protected $model = Incident::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'title' => rtrim(fake()->sentence(4), '.'),
            'category' => fake()->randomElement(['pii', 'secrets', 'jailbreak', 'policy', 'other']),
            'severity' => fake()->randomElement(['low', 'medium', 'high', 'critical']),
            'status' => fake()->randomElement(['open', 'investigating', 'resolved', 'closed']),
            'prompt_snapshot' => fake()->paragraph(),
            'prompt_check_id' => PromptCheck::factory(),
            'notes' => fake()->optional()->sentence(8),
        ];
    }
}
