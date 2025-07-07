<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\User\ContestsController;
use App\Http\Controllers\User\TrainingsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'authenticate'])->name('authenticate');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::group(['prefix' => 'user', 'middleware' => 'auth'], function () {
    Route::post('/set-game', function (Request $request) {
        $request->validate(['game_id' => 'required|exists:games,id']);
        session(['current_game' => $request->game_id]);
        return back();
    })->name('user.set-game');

    Route::post('/toggle-view', function (Request $request) {
        $request->validate(['view' => 'required|in:contests,trainings']);
        session(['view' => $request->view]);

        $currentGame = session('current_game');
        if ($request->view === 'contests') {
            return redirect()->route('user.contests.index', ['game' => $currentGame]);
        } else {
            return redirect()->route('user.trainings.index', ['game' => $currentGame]);
        }
    })->name('user.toggle-view');

    Route::group(['prefix' => '{game}/contests'], function () {
        Route::get('/', [ContestsController::class, 'index'])->name('user.contests.index');
        Route::get('/create', [ContestsController::class, 'create'])->name('user.contest.create');
        Route::post('/', [ContestsController::class, 'store'])->name('user.contests.store');
        Route::get('/{contest}/edit', [ContestsController::class, 'edit'])->name('user.contest.edit');
        Route::put('/{contest}', [ContestsController::class, 'update'])->name('user.contests.update');
        Route::delete('/{contest}', [ContestsController::class, 'destroy'])->name('user.contest.destroy');
        Route::get('/{contest}/show', [ContestsController::class, 'show'])->name('user.contest.show');
    });

    Route::group(['prefix' => '{game}/trainings'], function () {
        Route::get('/', [TrainingsController::class, 'index'])->name('user.trainings.index');
        Route::get('/create', [TrainingsController::class, 'create'])->name('user.trainings.create');
        Route::post('/', [TrainingsController::class, 'store'])->name('user.trainings.store');
        Route::get('/{training}/edit', [TrainingsController::class, 'edit'])->name('user.trainings.edit');
        Route::put('/{training}', [TrainingsController::class, 'update'])->name('user.trainings.update');
        Route::delete('/{training}', [TrainingsController::class, 'destroy'])->name('user.trainings.destroy');
        Route::post('/{training}/complete', [TrainingsController::class, 'complete'])->name('user.trainings.complete');
    });
});
