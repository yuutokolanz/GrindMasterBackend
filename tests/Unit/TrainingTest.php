<?php

namespace Tests\Unit;

use App\Models\Training;
use App\Models\User;
use App\Models\Game;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TrainingTest extends TestCase
{
  use RefreshDatabase;

  protected User $user;
  protected Game $game;

  protected function setUp(): void
  {
    parent::setUp();

    // Create test data
    $this->user = User::factory()->create();
    $this->game = Game::factory()->create();
  }

  public function test_training_can_be_created_with_valid_data(): void
  {
    $trainingData = [
      'user_id' => $this->user->id,
      'game_id' => $this->game->id,
      'title' => 'Aim Training',
      'description' => 'Practice aim for 30 minutes',
      'repeatable' => true,
      'completed_count' => 0
    ];

    $training = Training::create($trainingData);

    $this->assertInstanceOf(Training::class, $training);
    $this->assertEquals($trainingData['title'], $training->title);
    $this->assertEquals($trainingData['description'], $training->description);
    $this->assertTrue($training->repeatable);
    $this->assertEquals(0, $training->completed_count);
  }

  public function test_training_belongs_to_user(): void
  {
    $training = Training::factory()->create([
      'user_id' => $this->user->id
    ]);

    $this->assertInstanceOf(User::class, $training->user);
    $this->assertEquals($this->user->id, $training->user->id);
  }

  public function test_training_belongs_to_game(): void
  {
    $training = Training::factory()->create([
      'game_id' => $this->game->id
    ]);

    $this->assertInstanceOf(Game::class, $training->game);
    $this->assertEquals($this->game->id, $training->game->id);
  }

  public function test_training_fillable_attributes(): void
  {
    $training = new Training();
    $expectedFillable = [
      'user_id',
      'game_id',
      'title',
      'description',
      'repeatable',
      'completed_count'
    ];

    $this->assertEquals($expectedFillable, $training->getFillable());
  }

  public function test_training_default_values(): void
  {
    $training = Training::factory()->create([
      'repeatable' => false,
      'completed_count' => 0
    ]);

    $this->assertFalse($training->repeatable);
    $this->assertEquals(0, $training->completed_count);
  }

  public function test_training_can_be_repeatable(): void
  {
    $training = Training::factory()->create([
      'repeatable' => true,
      'completed_count' => 5
    ]);

    $this->assertTrue($training->repeatable);
    $this->assertEquals(5, $training->completed_count);
  }

  public function test_training_can_increment_completed_count(): void
  {
    $training = Training::factory()->create([
      'repeatable' => true,
      'completed_count' => 2
    ]);

    $training->increment('completed_count');

    $this->assertEquals(3, $training->fresh()->completed_count);
  }
}
