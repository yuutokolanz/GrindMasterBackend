@extends('layouts.user')

@section('title')
<h1>Editar Partida - {{ $game->name }}</h1>
@endsection

@section('content')

<x-user.form :contest="$contest" action="{{ route('user.contests.update', ['game' => $game->id, 'contest' => $contest->id]) }}">

  @section('ContestStats')

  @switch($game->name)

  @case('LeagueOfLegends')
  <label for="champion_played">Campeão utilizado</label>
  <input type="text" name="champion_played" id="champion_played"
    class="input-field" value="{{ old('champion_played', $contest->lolStat->champion_played ?? '') }}" />

  <label for="kills">Abates</label>
  <input type="number" name="kills" id="kills" class="input-field" value="{{ old('kills', $contest->lolStat->kills ?? '') }}" />

  <label for="deaths">Mortes</label>
  <input type="number" name="deaths" id="deaths" class="input-field" value="{{ old('deaths', $contest->lolStat->deaths ?? '') }}" />

  <label for="assists">Assistências</label>
  <input type="number" name="assists" id="assists" class="input-field" value="{{ old('assists', $contest->lolStat->assists ?? '') }}" />

  <label for="cs">CS (Minions/Monstros)</label>
  <input type="number" name="cs" id="cs" class="input-field" value="{{ old('cs', $contest->lolStat->cs ?? '') }}" />
  @break

  @case('CS2')
  <label for="map_played">Mapa</label>
  <input type="text" name="map_played" id="map_played" class="input-field" value="{{ old('map_played', $contest->csStat->map_played ?? '') }}" />

  <label for="kills">Abates</label>
  <input type="number" name="kills" id="kills" class="input-field" value="{{ old('kills', $contest->csStat->kills ?? '') }}" />

  <label for="deaths">Mortes</label>
  <input type="number" name="deaths" id="deaths" class="input-field" value="{{ old('deaths', $contest->csStat->deaths ?? '') }}" />

  <label for="hs_percent">Headshot %</label>
  <input type="number" step="0.01" name="hs_percent" id="hs_percent" class="input-field" value="{{ old('hs_percent', $contest->csStat->hs_percent ?? '') }}" />

  <label for="mvps">MVPs</label>
  <input type="number" name="mvps" id="mvps" class="input-field" value="{{ old('mvps', $contest->csStat->mvps ?? '') }}" />
  @break

  @case('Valorant')
  <label for="agent_played">Agente</label>
  <input type="text" name="agent_played" id="agent_played" class="input-field" value="{{ old('agent_played', $contest->valorantStat->agent_played ?? '') }}" />

  <label for="map_played">Mapa</label>
  <input type="text" name="map_played" id="map_played" class="input-field" value="{{ old('map_played', $contest->valorantStat->map_played ?? '') }}" />

  <label for="kills">Abates</label>
  <input type="number" name="kills" id="kills" class="input-field" value="{{ old('kills', $contest->valorantStat->kills ?? '') }}" />

  <label for="deaths">Mortes</label>
  <input type="number" name="deaths" id="deaths" class="input-field" value="{{ old('deaths', $contest->valorantStat->deaths ?? '') }}" />

  <label for="assists">Assistências</label>
  <input type="number" name="assists" id="assists" class="input-field" value="{{ old('assists', $contest->valorantStat->assists ?? '') }}" />

  <label for="acs">ACS (Pontuação Média)</label>
  <input type="number" name="acs" id="acs" class="input-field" value="{{ old('acs', $contest->valorantStat->acs ?? '') }}" />
  @break

  @case('TFT')
  <label for="placement">Colocação Final</label>
  <input type="number" name="placement" id="placement" class="input-field" value="{{ old('placement', $contest->tftStat->placement ?? '') }}" />

  <label for="level_at_end">Nível Final</label>
  <input type="number" name="level_at_end" id="level_at_end" class="input-field" value="{{ old('level_at_end', $contest->tftStat->level_at_end ?? '') }}" />

  <label for="traits_used">Traits Utilizadas</label>
  <textarea name="traits_used" id="traits_used" class="input-field">{{ old('traits_used', $contest->tftStat->traits_used ?? '') }}</textarea>

  <label for="augments">Aumentos</label>
  <textarea name="augments" id="augments" class="input-field">{{ old('augments', $contest->tftStat->augments ?? '') }}</textarea>
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