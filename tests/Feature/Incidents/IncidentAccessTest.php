<?php

namespace Tests\Feature\Incidents;

use App\Models\Incident;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class IncidentAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_only_returns_incidents_for_the_authenticated_user(): void
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();

        $ownedIncident = Incident::factory()->for($user)->create();
        $otherIncident = Incident::factory()->for($otherUser)->create();

        $response = $this->actingAs($user)
            ->withHeader('X-Inertia', 'true')
            ->get(route('incidents.index'));

        $response->assertOk();
        $response->assertJsonCount(1, 'props.incidents.data');
        $response->assertJsonPath('props.incidents.data.0.id', $ownedIncident->id);
        $response->assertJsonMissingPath('props.incidents.data.1.id');
        $response->assertJsonMissing(['id' => $otherIncident->id]);
    }

    public function test_users_cannot_view_other_users_incidents(): void
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();
        $otherUsersIncident = Incident::factory()->for($otherUser)->create();

        $this->actingAs($user)
            ->get(route('incidents.show', $otherUsersIncident))
            ->assertNotFound();
    }

    public function test_users_cannot_update_other_users_incidents(): void
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();
        $otherUsersIncident = Incident::factory()->for($otherUser)->create([
            'status' => 'open',
            'notes' => null,
        ]);

        $this->actingAs($user)
            ->patch(route('incidents.update', $otherUsersIncident), [
                'status' => 'closed',
                'notes' => 'Not allowed',
            ])
            ->assertNotFound();

        $this->assertDatabaseHas('incidents', [
            'id' => $otherUsersIncident->id,
            'status' => 'open',
            'notes' => null,
        ]);
    }
}
