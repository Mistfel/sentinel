<?php

namespace Database\Factories;

use App\Models\PromptCheck;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PromptCheck>
 */
class PromptCheckFactory extends Factory
{
    /**
     * @var class-string<PromptCheck>
     */
    protected $model = PromptCheck::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $reasons = fake()->randomElements(
            ['pii_email', 'pii_phone_like', 'secret_like', 'jailbreak_like', 'policy_violation'],
            fake()->numberBetween(0, 3),
        );

        return [
            'prompt' => fake()->paragraph(),
            'purpose' => fake()->optional()->sentence(4),
            'sensitivity' => fake()->randomElement(['public', 'internal', 'confidential', 'pii']),
            'result' => fake()->randomElement(['pass', 'warn', 'block']),
            'score' => fake()->numberBetween(0, 100),
            'reasons' => $reasons,
            'meta' => [
                'matched_count' => count($reasons),
                'source' => 'factory',
            ],
        ];
    }
}
