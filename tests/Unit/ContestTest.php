<?php

namespace Tests\Unit;

use App\Models\Contest;
use App\Models\User;
use App\Models\Game;
use App\Models\LolStat;
use App\Models\CsStat;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ContestTest extends TestCase
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

  public function test_contest_can_be_created_with_valid_data(): void
  {
    $contestData = [
      'user_id' => $this->user->id,
      'game_id' => $this->game->id,
      'contest_date' => '2025-07-06',
      'result' => 'Victory',
      'notes' => 'Great game!'
    ];

    $contest = Contest::create($contestData);

    $this->assertInstanceOf(Contest::class, $contest);
    $this->assertEquals($contestData['result'], $contest->result);
    $this->assertEquals($contestData['notes'], $contest->notes);
    $this->assertEquals($contestData['contest_date'], $contest->contest_date);
    $this->assertEquals($contestData['game_id'], $contest->game_id);
  }

  public function test_contest_belongs_to_user(): void
  {
    $contest = Contest::factory()->create([
      'user_id' => $this->user->id
    ]);

    $this->assertInstanceOf(User::class, $contest->user);
    $this->assertEquals($this->user->id, $contest->user->id);
  }

  public function test_contest_belongs_to_game(): void
  {
    $contest = Contest::factory()->create([
      'game_id' => $this->game->id
    ]);

    $this->assertInstanceOf(Game::class, $contest->game);
    $this->assertEquals($this->game->id, $contest->game->id);
  }

  public function test_contest_has_one_lol_stat(): void
  {
    $contest = Contest::factory()->create();
    $lolStat = LolStat::factory()->create(['contest_id' => $contest->id]);

    $this->assertInstanceOf(LolStat::class, $contest->lolStat);
    $this->assertEquals($lolStat->id, $contest->lolStat->id);
  }

  public function test_contest_has_one_cs_stat(): void
  {
    $contest = Contest::factory()->create();
    $csStat = CsStat::factory()->create(['contest_id' => $contest->id]);

    $this->assertInstanceOf(CsStat::class, $contest->csStat);
    $this->assertEquals($csStat->id, $contest->csStat->id);
  }

  public function test_contest_fillable_attributes(): void
  {
    $contest = new Contest();
    $expectedFillable = [
      'user_id',
      'game_id',
      'contest_date',
      'result',
      'notes'
    ];

    $this->assertEquals($expectedFillable, $contest->getFillable());
  }

  public function test_contest_deletion_cascades_to_stats(): void
  {
    $contest = Contest::factory()->create();
    $lolStat = LolStat::factory()->create(['contest_id' => $contest->id]);
    $csStat = CsStat::factory()->create(['contest_id' => $contest->id]);

    $contest->delete();

    $this->assertDatabaseMissing('contests', ['id' => $contest->id]);
    $this->assertDatabaseMissing('lol_stats', ['id' => $lolStat->id]);
    $this->assertDatabaseMissing('cs_stats', ['id' => $csStat->id]);
  }
}
