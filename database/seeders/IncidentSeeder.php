<?php

namespace Database\Seeders;

use App\Models\Incident;
use App\Models\User;
use Illuminate\Database\Seeder;

class IncidentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::query()->first() ?? User::factory()->create();

        Incident::factory()
            ->count(10)
            ->state([
                'user_id' => $user->id,
            ])
            ->create();
    }
}
