<?php

namespace Tests\Feature;

use App\Models\Contest;
use App\Models\User;
use App\Models\Game;
use App\Models\LolStat;
use App\Models\CsStat;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ContestsControllerTest extends TestCase
{
  use RefreshDatabase;

  protected User $user;
  protected Game $game;

  protected function setUp(): void
  {
    parent::setUp();

    $this->user = User::factory()->create();
    $this->game = Game::factory()->create(['name' => 'LeagueOfLegends']);

    // Set the session values that the header component expects
    session(['current_game' => $this->game->id]);
  }

  public function test_index_displays_contests_for_authenticated_user(): void
  {
    $contest = Contest::factory()->create([
      'user_id' => $this->user->id,
      'game_id' => $this->game->id
    ]);

    $response = $this->actingAs($this->user)
      ->withSession(['current_game' => $this->game->id])
      ->get(route('user.contests.index', ['game' => $this->game->id]));

    $response->assertStatus(200);
    $response->assertViewIs('user.contests.index');
    $response->assertViewHas('contests');
    $response->assertSee($contest->result);
  }

  public function test_index_requires_authentication(): void
  {
    $response = $this->get(route('user.contests.index', ['game' => $this->game->id]));

    $response->assertRedirect(route('login'));
  }

  public function test_create_displays_contest_creation_form(): void
  {
    $response = $this->actingAs($this->user)
      ->get(route('user.contest.create', ['game' => $this->game->id]));

    $response->assertStatus(200);
    $response->assertViewIs('user.contests.create');
    $response->assertViewHas('game');
  }

  public function test_store_creates_contest_with_lol_stats(): void
  {
    $contestData = [
      'result' => 'Victory',
      'notes' => 'Great game!',
      'contest_date' => '2025-07-06',
      'champion_played' => 'Jinx',
      'kills' => 10,
      'deaths' => 2,
      'assists' => 8,
      'cs' => 150
    ];

    $response = $this->actingAs($this->user)
      ->post(route('user.contests.store', ['game' => $this->game->id]), $contestData);

    $response->assertRedirect(route('user.contests.index', ['game' => $this->game->id]));
    $response->assertSessionHas('success');

    $this->assertDatabaseHas('contests', [
      'user_id' => $this->user->id,
      'game_id' => $this->game->id,
      'result' => 'Victory',
      'notes' => 'Great game!'
    ]);

    $contest = Contest::where('user_id', $this->user->id)->first();
    $this->assertDatabaseHas('lol_stats', [
      'contest_id' => $contest->id,
      'champion_played' => 'Jinx',
      'kills' => 10,
      'deaths' => 2,
      'assists' => 8,
      'cs' => 150
    ]);
  }

  public function test_store_creates_contest_with_cs_stats(): void
  {
    $csGame = Game::factory()->create(['name' => 'CS2']);

    $contestData = [
      'result' => 'Victory',
      'notes' => 'Good round!',
      'contest_date' => '2025-07-06',
      'map_played' => 'de_dust2',
      'kills' => 25,
      'deaths' => 15,
      'hs_percent' => 65.5,
      'mvps' => 3
    ];

    $response = $this->actingAs($this->user)
      ->post(route('user.contests.store', ['game' => $csGame->id]), $contestData);

    $response->assertRedirect(route('user.contests.index', ['game' => $csGame->id]));

    $contest = Contest::where('user_id', $this->user->id)->first();
    $this->assertDatabaseHas('cs_stats', [
      'contest_id' => $contest->id,
      'map_played' => 'de_dust2',
      'kills' => 25,
      'deaths' => 15,
      'hs_percent' => 65.5,
      'mvps' => 3
    ]);
  }

  public function test_store_validates_required_fields(): void
  {
    $response = $this->actingAs($this->user)
      ->post(route('user.contests.store', ['game' => $this->game->id]), []);

    $response->assertSessionHasErrors(['result', 'contest_date']);
  }

  public function test_store_validates_lol_specific_fields(): void
  {
    $contestData = [
      'result' => 'Victory',
      'contest_date' => '2025-07-06'
      // Missing LoL specific fields
    ];

    $response = $this->actingAs($this->user)
      ->post(route('user.contests.store', ['game' => $this->game->id]), $contestData);

    $response->assertSessionHasErrors([
      'champion_played',
      'kills',
      'deaths',
      'assists',
      'cs'
    ]);
  }

  public function test_edit_displays_contest_edit_form(): void
  {
    $contest = Contest::factory()->create([
      'user_id' => $this->user->id,
      'game_id' => $this->game->id
    ]);

    $response = $this->actingAs($this->user)
      ->get(route('user.contest.edit', [
        'game' => $this->game->id,
        'contest' => $contest->id
      ]));

    $response->assertStatus(200);
    $response->assertViewIs('user.contests.edit');
    $response->assertViewHas(['game', 'contest']);
  }

  public function test_update_modifies_existing_contest(): void
  {
    $contest = Contest::factory()->create([
      'user_id' => $this->user->id,
      'game_id' => $this->game->id
    ]);

    $lolStat = LolStat::factory()->create(['contest_id' => $contest->id]);

    $updateData = [
      'result' => 'Defeat',
      'notes' => 'Updated notes',
      'contest_date' => '2025-07-07',
      'champion_played' => 'Ashe',
      'kills' => 5,
      'deaths' => 8,
      'assists' => 12,
      'cs' => 120
    ];

    $response = $this->actingAs($this->user)
      ->put(route('user.contests.update', [
        'game' => $this->game->id,
        'contest' => $contest->id
      ]), $updateData);

    $response->assertRedirect(route('user.contests.index', $this->game->id));

    $this->assertDatabaseHas('contests', [
      'id' => $contest->id,
      'result' => 'Defeat',
      'notes' => 'Updated notes'
    ]);

    $this->assertDatabaseHas('lol_stats', [
      'contest_id' => $contest->id,
      'champion_played' => 'Ashe',
      'kills' => 5
    ]);
  }

  public function test_destroy_deletes_contest(): void
  {
    $contest = Contest::factory()->create([
      'user_id' => $this->user->id,
      'game_id' => $this->game->id
    ]);

    $response = $this->actingAs($this->user)
      ->delete(route('user.contest.destroy', [
        'game' => $this->game->id,
        'contest' => $contest->id
      ]));

    $response->assertRedirect(route('user.contests.index', $this->game->id));
    $this->assertDatabaseMissing('contests', ['id' => $contest->id]);
  }
}
