@extends('layouts.user')

@section('title')
<h1>Editar Treino - {{ $game->name }}</h1>
@endsection

@section('content')

<x-user.training-form :training="$training" action="{{ route('user.trainings.update', ['game' => $game->id, 'training' => $training->id]) }}">

  @section('TrainingStats')

  @switch($game->name)

  @case('League of Legends')
  <div class="space-y-3">
    <h3 class="text-lg font-semibold text-purple-400">Estatísticas específicas - League of Legends</h3>

    <div>
      <label for="champion_practiced" class="block text-sm font-medium">Campeão praticado</label>
      <input type="text" name="champion_practiced" id="champion_practiced"
        class="w-full rounded border border-[#4F9CF9] bg-[#1C1C1E] text-white text-base leading-8 px-3 py-2 outline-none transition-colors duration-200 ease-in-out focus:border-purple-500 focus:ring-2 focus:ring-purple-200"
        value="{{ old('champion_practiced', $training->champion_practiced ?? '') }}" placeholder="Ex: Yasuo, Jinx, Thresh..." />
    </div>

    <div>
      <label for="practice_type" class="block text-sm font-medium">Tipo de prática</label>
      <select name="practice_type" id="practice_type"
        class="w-full rounded border border-[#4F9CF9] bg-[#1C1C1E] text-white text-base leading-8 px-3 py-2 outline-none transition-colors duration-200 ease-in-out focus:border-purple-500 focus:ring-2 focus:ring-purple-200">
        <option value="">Selecione o tipo</option>
        <option value="Last Hit" {{ old('practice_type', $training->practice_type ?? '') == 'Last Hit' ? 'selected' : '' }}>Last Hit</option>
        <option value="Combos" {{ old('practice_type', $training->practice_type ?? '') == 'Combos' ? 'selected' : '' }}>Combos</option>
        <option value="Positioning" {{ old('practice_type', $training->practice_type ?? '') == 'Positioning' ? 'selected' : '' }}>Posicionamento</option>
        <option value="Team Fight" {{ old('practice_type', $training->practice_type ?? '') == 'Team Fight' ? 'selected' : '' }}>Team Fight</option>
        <option value="Jungle Clear" {{ old('practice_type', $training->practice_type ?? '') == 'Jungle Clear' ? 'selected' : '' }}>Jungle Clear</option>
        <option value="Lane Control" {{ old('practice_type', $training->practice_type ?? '') == 'Lane Control' ? 'selected' : '' }}>Controle de Lane</option>
      </select>
    </div>

    <div>
      <label for="duration_minutes" class="block text-sm font-medium">Duração (minutos)</label>
      <input type="number" name="duration_minutes" id="duration_minutes" min="1"
        class="w-full rounded border border-[#4F9CF9] bg-[#1C1C1E] text-white text-base leading-8 px-3 py-2 outline-none transition-colors duration-200 ease-in-out focus:border-purple-500 focus:ring-2 focus:ring-purple-200"
        value="{{ old('duration_minutes', $training->duration_minutes ?? '') }}" placeholder="Ex: 30" />
    </div>
  </div>
  @break

  @case('CS2')
  <div class="space-y-3">
    <h3 class="text-lg font-semibold text-purple-400">Estatísticas específicas - CS2</h3>

    <div>
      <label for="map_practiced" class="block text-sm font-medium">Mapa praticado</label>
      <input type="text" name="map_practiced" id="map_practiced"
        class="w-full rounded border border-[#4F9CF9] bg-[#1C1C1E] text-white text-base leading-8 px-3 py-2 outline-none transition-colors duration-200 ease-in-out focus:border-purple-500 focus:ring-2 focus:ring-purple-200"
        value="{{ old('map_practiced', $training->map_practiced ?? '') }}" placeholder="Ex: Dust2, Mirage, Inferno..." />
    </div>

    <div>
      <label for="practice_type" class="block text-sm font-medium">Tipo de prática</label>
      <select name="practice_type" id="practice_type"
        class="w-full rounded border border-[#4F9CF9] bg-[#1C1C1E] text-white text-base leading-8 px-3 py-2 outline-none transition-colors duration-200 ease-in-out focus:border-purple-500 focus:ring-2 focus:ring-purple-200">
        <option value="">Selecione o tipo</option>
        <option value="Aim Training" {{ old('practice_type', $training->practice_type ?? '') == 'Aim Training' ? 'selected' : '' }}>Aim Training</option>
        <option value="Recoil Control" {{ old('practice_type', $training->practice_type ?? '') == 'Recoil Control' ? 'selected' : '' }}>Controle de Recoil</option>
        <option value="Smokes/Flashes" {{ old('practice_type', $training->practice_type ?? '') == 'Smokes/Flashes' ? 'selected' : '' }}>Smokes/Flashes</option>
        <option value="Positioning" {{ old('practice_type', $training->practice_type ?? '') == 'Positioning' ? 'selected' : '' }}>Posicionamento</option>
        <option value="Crosshair Placement" {{ old('practice_type', $training->practice_type ?? '') == 'Crosshair Placement' ? 'selected' : '' }}>Crosshair Placement</option>
        <option value="Movement" {{ old('practice_type', $training->practice_type ?? '') == 'Movement' ? 'selected' : '' }}>Movimento</option>
        <option value="Retakes" {{ old('practice_type', $training->practice_type ?? '') == 'Retakes' ? 'selected' : '' }}>Retakes</option>
      </select>
    </div>

    <div>
      <label for="duration_minutes" class="block text-sm font-medium">Duração (minutos)</label>
      <input type="number" name="duration_minutes" id="duration_minutes" min="1"
        class="w-full rounded border border-[#4F9CF9] bg-[#1C1C1E] text-white text-base leading-8 px-3 py-2 outline-none transition-colors duration-200 ease-in-out focus:border-purple-500 focus:ring-2 focus:ring-purple-200"
        value="{{ old('duration_minutes', $training->duration_minutes ?? '') }}" placeholder="Ex: 45" />
    </div>

    <div>
      <label for="accuracy_achieved" class="block text-sm font-medium">Precisão alcançada (%)</label>
      <input type="number" step="0.1" name="accuracy_achieved" id="accuracy_achieved" min="0" max="100"
        class="w-full rounded border border-[#4F9CF9] bg-[#1C1C1E] text-white text-base leading-8 px-3 py-2 outline-none transition-colors duration-200 ease-in-out focus:border-purple-500 focus:ring-2 focus:ring-purple-200"
        value="{{ old('accuracy_achieved', $training->accuracy_achieved ?? '') }}" placeholder="Ex: 75.5" />
    </div>
  </div>
  @break

  @default
  <div class="bg-yellow-900/20 border border-yellow-500/50 rounded-lg p-4">
    <p class="text-yellow-300 text-sm">
      <strong>Informação:</strong> Este jogo ainda não possui campos específicos de treino configurados.
      Você pode usar os campos básicos acima para registrar seu treino.
    </p>
  </div>
  @endswitch

  @endsection

</x-user.training-form>

<div class="mt-6 text-center">
  <a href="{{ route('user.trainings.index', ['game' => $game->id]) }}"
    class="inline-block px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded">
    Voltar para listagem
  </a>
</div>

@endsection