<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Game;
use App\Models\Training;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TrainingsController extends Controller
{
    public function index()
    {
        $game = Game::findOrFail(session('current_game'));
        $games = Game::all();
        $trainings = Training::where('game_id', session('current_game'))
            ->orderBy('created_at', 'desc')
            ->get();

        return view('user.trainings.index', compact('trainings', 'games'));
    }

    public function create(Game $game)
    {
        return view('user.trainings.create', [
            'game' => $game,
        ]);
    }

    public function store(Request $request, Game $game)
    {
        // Validação dos campos básicos do treino
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'repeatable' => 'boolean',
        ]);

        // Criar o treino
        $training = new Training([
            'user_id' => Auth::id(),
            'game_id' => $game->id,
            'title' => $request->title,
            'description' => $request->description,
            'repeatable' => $request->repeatable ?? false,
        ]);
        $game->trainings()->save($training);

        return redirect()->route('user.trainings.index', ['game' => $game->id])
            ->with('success', 'Treino criado com sucesso!');
    }

    public function edit(Game $game, Training $training)
    {
        // Verificar se o treino pertence ao usuário logado
        if ($training->user_id !== Auth::id()) {
            abort(403, 'Acesso negado.');
        }

        return view('user.trainings.edit', compact('training', 'game'));
    }

    public function update(Request $request, Game $game, Training $training)
    {
        // Verificar se o treino pertence ao usuário logado
        if ($training->user_id !== Auth::id()) {
            abort(403, 'Acesso negado.');
        }

        // Validação dos campos básicos do treino
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'repeatable' => 'boolean',
        ]);

        // Atualizar o treino
        $training->update([
            'title' => $request->title,
            'description' => $request->description,
            'repeatable' => $request->repeatable ?? false,
        ]);

        return redirect()->route('user.trainings.index', ['game' => $game->id])->with('success', 'Treino atualizado com sucesso!');
    }

    public function destroy(Game $game, Training $training)
    {
        // Verificar se o treino pertence ao usuário logado
        if ($training->user_id !== Auth::id()) {
            abort(403, 'Acesso negado.');
        }

        $training->delete();

        return redirect()->route('user.trainings.index', ['game' => $game->id])->with('success', 'Treino excluído com sucesso!');
    }

    public function complete(Game $game, Training $training)
    {
        // Verificar se o treino pertence ao usuário logado
        if ($training->user_id !== Auth::id()) {
            abort(403, 'Acesso negado.');
        }

        if ($training->repeatable) {
            // Se for repetível, incrementa o contador
            $training->increment('completed_count');
            return redirect()->route('user.trainings.index', ['game' => $game->id])
                ->with('success', 'Treino concluído! Total de vezes completado: ' . $training->completed_count);
        } else {
            // Se não for repetível, exclui o treino
            $training->delete();
            return redirect()->route('user.trainings.index', ['game' => $game->id])
                ->with('success', 'Treino concluído e removido da lista!');
        }
    }
}
