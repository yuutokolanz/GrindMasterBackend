@extends('layouts.user')

@section('title')
<h1>Adicionar Partida - {{ $game->name }}</h1>
@endsection

@section('content')

<x-user.form :contest="[]" action="{{ route('user.contests.store', ['game' => $game->id]) }}">

    @section('ContestStats')

    @switch($game->name)
    
        @case('LeagueOfLegends')
            <label for="champion_played">Campeão utilizado</label>
            <input type="text" name="champion_played" id="champion_played"
                class="input-field" value="{{ old('champion_played') }}" />

            <label for="kills">Abates</label>
            <input type="number" name="kills" id="kills" class="input-field" value="{{ old('kills') }}" />

            <label for="deaths">Mortes</label>
            <input type="number" name="deaths" id="deaths" class="input-field" value="{{ old('deaths') }}" />

            <label for="assists">Assistências</label>
            <input type="number" name="assists" id="assists" class="input-field" value="{{ old('assists') }}" />

            <label for="cs">CS (Minions/Monstros)</label>
            <input type="number" name="cs" id="cs" class="input-field" value="{{ old('cs') }}" />
        @break


        @case('CS2')
            <label for="map_played">Mapa</label>
            <input type="text" name="map_played" id="map_played" class="input-field" value="{{ old('map_played') }}" />

            <label for="kills">Abates</label>
            <input type="number" name="kills" id="kills" class="input-field" value="{{ old('kills') }}" />

            <label for="deaths">Mortes</label>
            <input type="number" name="deaths" id="deaths" class="input-field" value="{{ old('deaths') }}" />

            <label for="hs_percent">Headshot %</label>
            <input type="number" step="0.01" name="hs_percent" id="hs_percent" class="input-field" value="{{ old('hs_percent') }}" />

            <label for="mvps">MVPs</label>
            <input type="number" name="mvps" id="mvps" class="input-field" value="{{ old('mvps') }}" />
        @break

        @default
            <p class="text-red-500">Este jogo ainda não possui campos configurados.</p>

    @endswitch
    @endsection
</x-user.form>

<div class="mt-6 text-center">
  <a href="{{ route('user.contests.index', ['game' => $game->id]) }}"
    class="inline-block px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded">
    Voltar para listagem
  </a>
</div>

@endsection
