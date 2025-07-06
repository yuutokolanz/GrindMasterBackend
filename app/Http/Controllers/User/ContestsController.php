<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Contest;
use App\Models\CsStat;
use App\Models\Game;
use App\Models\LolStat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContestsController extends Controller
{
    public function index()
    {
        $game = Game::findOrFail(session('current_game'));
        $games = Game::all();
        $contests = Contest::where('game_id', session('current_game'))
            ->orderBy('contest_date', 'desc')
            ->get();

        return view('user.contests.index', compact('contests', 'games'));
    }

    public function create(Game $game)
    {
        return view('user.contests.create', [
            'game' => $game,
        ]);
    }

    public function store(Request $request, Game $game)
    {
        // Validação dos campos básicos da partida
        $request->validate([
            'result' => 'required|string|max:255',
            'notes' => 'nullable|string',
            'contest_date' => 'required|date',
        ]);

        // Criar a partida (Contest)
        $contest = new Contest([
            'user_id' => Auth::id(),
            'result' => $request->result,
            'notes' => $request->notes,
            'contest_date' => $request->contest_date,
        ]);
        $game->contests()->save($contest);

        // Lógica para salvar as estatísticas específicas por jogo
        switch ($game->name) {

            case 'LeagueOfLegends':
                $request->validate([
                    'champion_played' => 'required|string|max:255',
                    'kills' => 'required|integer',
                    'deaths' => 'required|integer',
                    'assists' => 'required|integer',
                    'cs' => 'required|integer',
                ]);
                
                $stats = new LolStat([
                    'champion_played' => $request->champion_played,
                    'champion_played_icon' => 'https://ddragon.leagueoflegends.com/cdn/img/champion/tiles/' . $request->champion_played . '_0.jpg',
                    'kills' => $request->kills,
                    'deaths' => $request->deaths,
                    'assists' => $request->assists,
                    'cs' => $request->cs,
                ]);
                $contest->lolStat()->save($stats);

                break;

            case 'CS2':
                $request->validate([
                    'map_played' => 'required|string|max:255',
                    'kills' => 'required|integer',
                    'deaths' => 'required|integer',
                    'hs_percent' => 'required|numeric',
                    'mvps' => 'required|integer',
                ]);
                
                $stats = new CsStat([
                    'map_played' => $request->map_played,
                    'kills' => $request->kills,
                    'deaths' => $request->deaths,
                    'hs_percent' => $request->hs_percent,
                    'mvps' => $request->mvps,
                ]);
                $contest->csStat()->save($stats);

                break;

            default:
                return back()->with('error', 'Jogo não reconhecido.');
        }

        return redirect()->route('user.contests.index', ['game' => session('current_game')])->with('success', 'Partida salva com sucesso!');
    }

    public function edit(Game $game, Contest $contest)
    {
        // Load the stats relationship
        $contest->load(['lolStat', 'csStat']);

        return view('user.contests.edit', [
            'game' => $game,
            'contest' => $contest,
        ]);
    }

    public function update(Request $request, Game $game, Contest $contest)
    {
        // Validação dos campos básicos da partida
        $request->validate([
            'result' => 'required|string|max:255',
            'notes' => 'nullable|string',
            'contest_date' => 'required|date',
        ]);

        // Atualizar a partida (Contest)
        $contest->update([
            'result' => $request->result,
            'notes' => $request->notes,
            'contest_date' => $request->contest_date,
        ]);

        // Lógica para atualizar as estatísticas específicas por jogo
        switch ($game->name) {

            case 'LeagueOfLegends':
                $request->validate([
                    'champion_played' => 'required|string|max:255',
                    'kills' => 'required|integer',
                    'deaths' => 'required|integer',
                    'assists' => 'required|integer',
                    'cs' => 'required|integer',
                ]);

                $contest->lolStat()->updateOrCreate(
                    ['contest_id' => $contest->id],
                    [
                        'champion_played' => $request->champion_played,
                        'champion_played_icon' => 'https://ddragon.leagueoflegends.com/cdn/img/champion/tiles/' . $request->champion_played . '_0.jpg',
                        'kills' => $request->kills,
                        'deaths' => $request->deaths,
                        'assists' => $request->assists,
                        'cs' => $request->cs,
                    ]
                );

                break;

            case 'CS2':
                $request->validate([
                    'map_played' => 'required|string|max:255',
                    'kills' => 'required|integer',
                    'deaths' => 'required|integer',
                    'hs_percent' => 'required|numeric',
                    'mvps' => 'required|integer',
                ]);

                $contest->csStat()->updateOrCreate(
                    ['contest_id' => $contest->id],
                    [
                        'map_played' => $request->map_played,
                        'kills' => $request->kills,
                        'deaths' => $request->deaths,
                        'hs_percent' => $request->hs_percent,
                        'mvps' => $request->mvps,
                    ]
                );
                break;
        }

        return redirect()->route('user.contests.index', $game->id)->with('success', 'Partida atualizada com sucesso!');
    }

    public function destroy(Game $game, Contest $contest)
    {
        // Excluir a partida (Contest) e suas estatísticas associadas
        $contest->delete();

        return redirect()->route('user.contests.index', $game->id)->with('success', 'Partida excluída com sucesso!');
    }
}
