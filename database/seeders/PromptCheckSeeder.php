<?php

namespace Database\Seeders;

use App\Models\Incident;
use App\Models\PromptCheck;
use App\Models\User;
use Illuminate\Database\Seeder;

class PromptCheckSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::query()->first() ?? User::factory()->create();

        PromptCheck::factory()
            ->count(20)
            ->state([
                'user_id' => $user->id,
            ])
            ->create()
            ->each(function (PromptCheck $promptCheck): void {
                Incident::factory()
                    ->count(2)
                    ->for($promptCheck)
                    ->state([
                        'user_id' => $promptCheck->user_id,
                        'prompt_snapshot' => $promptCheck->prompt,
                    ])
                    ->create();
            });
    }
}
