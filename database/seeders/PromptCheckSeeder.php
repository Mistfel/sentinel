<?php

namespace Database\Seeders;

use App\Models\Incident;
use App\Models\PromptCheck;
use Illuminate\Database\Seeder;

class PromptCheckSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PromptCheck::factory()
            ->count(20)
            ->create()
            ->each(function (PromptCheck $promptCheck): void {
                Incident::factory()
                    ->count(2)
                    ->for($promptCheck)
                    ->state([
                        'prompt_snapshot' => $promptCheck->prompt,
                    ])
                    ->create();
            });
    }
}
