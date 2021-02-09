<?php

namespace Tests\Feature;

use App\Models\Provider;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CanUpdateProvidersTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function an_authenticated_user_can_update_providers()
    {        
        // Given
        $user = User::factory()->create();

        $provider = Provider::factory()->create(['name' => 'Provider one']);

        // When
        $this->actingAs($user)->putJson(
            route('providers.update', $provider), 
            ['name' => 'Provider updated']
        );

        // Then
        $this->assertDatabaseHas('providers', ['name' => 'Provider updated']);
    }

    /** @test */
    public function a_provider_requires_a_name()
    {
        // Given
        $user = User::factory()->create();

        $provider = Provider::factory()->create(['name' => 'Provider one']);

        // When
        $response = $this->actingAs($user)->putJson(
            route('providers.update', $provider), 
            []
        );

        // Then
        $response->assertStatus(422);

        $response->assertJsonStructure(['message', 'errors' => ['name']]);
    }

    /** @test */
    public function a_provider_name_requires_a_minimum_length()
    {
        // Given
        $user = User::factory()->create();

        $provider = Provider::factory()->create(['name' => 'Provider one']);

        // When
        $response = $this->actingAs($user)->putJson(
            route('providers.update', $provider), 
            ['name' => 'one']
        );
        
        // Then
        $response->assertStatus(422);

        $response->assertJsonStructure(['message', 'errors' => ['name']]);
    }

    /** @test */
    public function a_provider_name_must_be_unique()
    {
        // Given
        $user = User::factory()->create();

        $provider = Provider::factory()->create(['name' => 'Provider one']);

        // When
        $response = $this->actingAs($user)->putJson(
            route('providers.update', $provider), 
            ['name' => $provider->name]
        );

        // Then
        $response->assertStatus(422);

        $response->assertJsonStructure(['message', 'errors' => ['name']]);
    }
}
