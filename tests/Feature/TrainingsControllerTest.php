<?php

namespace Tests\Feature;

use App\Models\Training;
use App\Models\User;
use App\Models\Game;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TrainingsControllerTest extends TestCase
{
  use RefreshDatabase;

  protected User $user;
  protected User $otherUser;
  protected Game $game;

  protected function setUp(): void
  {
    parent::setUp();

    $this->user = User::factory()->create();
    $this->otherUser = User::factory()->create();
    $this->game = Game::factory()->create();
  }

  public function test_index_displays_trainings_for_authenticated_user(): void
  {
    $training = Training::factory()->create([
      'user_id' => $this->user->id,
      'game_id' => $this->game->id
    ]);

    $response = $this->actingAs($this->user)
      ->withSession(['current_game' => $this->game->id])
      ->get(route('user.trainings.index', ['game' => $this->game->id]));

    $response->assertStatus(200);
    $response->assertViewIs('user.trainings.index');
    $response->assertViewHas('trainings');
    $response->assertSee($training->title);
  }

  public function test_index_requires_authentication(): void
  {
    $response = $this->get(route('user.trainings.index', ['game' => $this->game->id]));

    $response->assertRedirect(route('login'));
  }

  public function test_create_displays_training_creation_form(): void
  {
    $response = $this->actingAs($this->user)
      ->get(route('user.trainings.create', ['game' => $this->game->id]));

    $response->assertStatus(200);
    $response->assertViewIs('user.trainings.create');
    $response->assertViewHas('game');
  }

  public function test_store_creates_training_with_valid_data(): void
  {
    $trainingData = [
      'title' => 'Aim Training',
      'description' => 'Practice aim for 30 minutes',
      'repeatable' => true
    ];

    $response = $this->actingAs($this->user)
      ->post(route('user.trainings.store', ['game' => $this->game->id]), $trainingData);

    $response->assertRedirect(route('user.trainings.index', ['game' => $this->game->id]));
    $response->assertSessionHas('success');

    $this->assertDatabaseHas('trainings', [
      'user_id' => $this->user->id,
      'game_id' => $this->game->id,
      'title' => 'Aim Training',
      'description' => 'Practice aim for 30 minutes',
      'repeatable' => true
    ]);
  }

  public function test_store_creates_non_repeatable_training(): void
  {
    $trainingData = [
      'title' => 'One-time Challenge',
      'description' => 'Complete this challenge once'
    ];

    $response = $this->actingAs($this->user)
      ->post(route('user.trainings.store', ['game' => $this->game->id]), $trainingData);

    $response->assertRedirect(route('user.trainings.index', ['game' => $this->game->id]));

    $this->assertDatabaseHas('trainings', [
      'user_id' => $this->user->id,
      'title' => 'One-time Challenge',
      'repeatable' => false
    ]);
  }

  public function test_store_validates_required_fields(): void
  {
    $response = $this->actingAs($this->user)
      ->post(route('user.trainings.store', ['game' => $this->game->id]), []);

    $response->assertSessionHasErrors(['title']);
  }

  public function test_store_validates_title_max_length(): void
  {
    $trainingData = [
      'title' => str_repeat('a', 256), // Exceeds 255 character limit
      'description' => 'Valid description'
    ];

    $response = $this->actingAs($this->user)
      ->post(route('user.trainings.store', ['game' => $this->game->id]), $trainingData);

    $response->assertSessionHasErrors(['title']);
  }

  public function test_edit_displays_training_edit_form_for_owner(): void
  {
    $training = Training::factory()->create([
      'user_id' => $this->user->id,
      'game_id' => $this->game->id
    ]);

    $response = $this->actingAs($this->user)
      ->get(route('user.trainings.edit', [
        'game' => $this->game->id,
        'training' => $training->id
      ]));

    $response->assertStatus(200);
    $response->assertViewIs('user.trainings.edit');
    $response->assertViewHas(['training', 'game']);
  }

  public function test_edit_denies_access_to_non_owner(): void
  {
    $training = Training::factory()->create([
      'user_id' => $this->otherUser->id,
      'game_id' => $this->game->id
    ]);

    $response = $this->actingAs($this->user)
      ->get(route('user.trainings.edit', [
        'game' => $this->game->id,
        'training' => $training->id
      ]));

    $response->assertStatus(403);
  }

  public function test_update_modifies_training_for_owner(): void
  {
    $training = Training::factory()->create([
      'user_id' => $this->user->id,
      'game_id' => $this->game->id,
      'title' => 'Original Title'
    ]);

    $updateData = [
      'title' => 'Updated Title',
      'description' => 'Updated description',
      'repeatable' => false
    ];

    $response = $this->actingAs($this->user)
      ->put(route('user.trainings.update', [
        'game' => $this->game->id,
        'training' => $training->id
      ]), $updateData);

    $response->assertRedirect(route('user.trainings.index', ['game' => $this->game->id]));

    $this->assertDatabaseHas('trainings', [
      'id' => $training->id,
      'title' => 'Updated Title',
      'description' => 'Updated description',
      'repeatable' => false
    ]);
  }

  public function test_update_denies_access_to_non_owner(): void
  {
    $training = Training::factory()->create([
      'user_id' => $this->otherUser->id,
      'game_id' => $this->game->id
    ]);

    $response = $this->actingAs($this->user)
      ->put(route('user.trainings.update', [
        'game' => $this->game->id,
        'training' => $training->id
      ]), ['title' => 'Hacked Title']);

    $response->assertStatus(403);
  }

  public function test_destroy_deletes_training_for_owner(): void
  {
    $training = Training::factory()->create([
      'user_id' => $this->user->id,
      'game_id' => $this->game->id
    ]);

    $response = $this->actingAs($this->user)
      ->delete(route('user.trainings.destroy', [
        'game' => $this->game->id,
        'training' => $training->id
      ]));

    $response->assertRedirect(route('user.trainings.index', ['game' => $this->game->id]));
    $this->assertDatabaseMissing('trainings', ['id' => $training->id]);
  }

  public function test_destroy_denies_access_to_non_owner(): void
  {
    $training = Training::factory()->create([
      'user_id' => $this->otherUser->id,
      'game_id' => $this->game->id
    ]);

    $response = $this->actingAs($this->user)
      ->delete(route('user.trainings.destroy', [
        'game' => $this->game->id,
        'training' => $training->id
      ]));

    $response->assertStatus(403);
    $this->assertDatabaseHas('trainings', ['id' => $training->id]);
  }

  public function test_complete_increments_repeatable_training(): void
  {
    $training = Training::factory()->create([
      'user_id' => $this->user->id,
      'game_id' => $this->game->id,
      'repeatable' => true,
      'completed_count' => 2
    ]);

    $response = $this->actingAs($this->user)
      ->post(route('user.trainings.complete', [
        'game' => $this->game->id,
        'training' => $training->id
      ]));

    $response->assertRedirect(route('user.trainings.index', ['game' => $this->game->id]));
    $response->assertSessionHas('success');

    $this->assertDatabaseHas('trainings', [
      'id' => $training->id,
      'completed_count' => 3
    ]);
  }

  public function test_complete_deletes_non_repeatable_training(): void
  {
    $training = Training::factory()->create([
      'user_id' => $this->user->id,
      'game_id' => $this->game->id,
      'repeatable' => false
    ]);

    $response = $this->actingAs($this->user)
      ->post(route('user.trainings.complete', [
        'game' => $this->game->id,
        'training' => $training->id
      ]));

    $response->assertRedirect(route('user.trainings.index', ['game' => $this->game->id]));
    $response->assertSessionHas('success');

    $this->assertDatabaseMissing('trainings', ['id' => $training->id]);
  }

  public function test_complete_denies_access_to_non_owner(): void
  {
    $training = Training::factory()->create([
      'user_id' => $this->otherUser->id,
      'game_id' => $this->game->id,
      'repeatable' => true,
      'completed_count' => 1
    ]);

    $response = $this->actingAs($this->user)
      ->post(route('user.trainings.complete', [
        'game' => $this->game->id,
        'training' => $training->id
      ]));

    $response->assertStatus(403);

    $this->assertDatabaseHas('trainings', [
      'id' => $training->id,
      'completed_count' => 1
    ]);
  }
}
