<?php

namespace Tests\Feature\Database;

use App\Models\Incident;
use App\Models\PromptCheck;
use Database\Seeders\PromptCheckSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PromptCheckSeederTest extends TestCase
{
    use RefreshDatabase;

    public function test_prompt_check_seeder_creates_incidents_linked_to_prompt_checks(): void
    {
        $this->seed(PromptCheckSeeder::class);

        $this->assertDatabaseCount('prompt_checks', 20);
        $this->assertDatabaseCount('incidents', 40);
        $this->assertSame(0, Incident::query()->whereNull('prompt_check_id')->count());

        $incident = Incident::query()->with('promptCheck')->firstOrFail();

        $this->assertNotNull($incident->promptCheck);
        $this->assertSame($incident->promptCheck->prompt, $incident->prompt_snapshot);
        $this->assertInstanceOf(PromptCheck::class, $incident->promptCheck);
    }
}
