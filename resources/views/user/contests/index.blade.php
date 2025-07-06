@extends('layouts.user')

@section('title')
<h1>Listagem de partidas</h1>
@endsection

@section('content')
<a href="{{ route('user.contest.create', ['game' => session('current_game')]) }}" class="inline-block mb-4 px-4 py-2 bg-green-500 hover:bg-green-600 text-white rounded">
  Criar partida
</a>
@forelse ($contests as $contest)
<div class="bg-[#1C1C1E] border border-[#544591] rounded-lg shadow-lg p-4 mb-4 text-white">

  <div class="flex justify-between items-center mb-2">
    <h2 class="text-lg font-bold">{{ $contest->game->name }}</h2>
    <span class="text-sm text-gray-400">{{ $contest->contest_date }}</span>
  </div>

  <p class="mb-2">
    <strong>Resultado:</strong> {{ $contest->result ?? 'Não informado' }}
  </p>

  <p class="mb-2">
    <strong>Anotações:</strong> {{ $contest->notes ? $contest->notes : 'Não informado' }}
  </p>

  <!-- Estatísticas específicas por jogo -->
  <div class="bg-[#2C2C2E] rounded-lg p-3 mb-3">
    @switch($contest->game->name)
    @case('LeagueOfLegends')
    @if($contest->lolStat)
    <div class="flex items-center space-x-4">
      @if($contest->lolStat->champion_played_icon)
      <img src="{{ $contest->lolStat->champion_played_icon }}" alt="Campeão" class="w-12 h-12 rounded-full">
      @endif
      <div class="flex-1">
        <p class="text-sm"><strong>Campeão:</strong> {{ $contest->lolStat->champion_played ?? 'Não informado' }}</p>
        <div class="flex space-x-4 text-sm mt-1">
          <span class="text-green-400">K: {{ $contest->lolStat->kills ?? 0 }}</span>
          <span class="text-red-400">D: {{ $contest->lolStat->deaths ?? 0 }}</span>
          <span class="text-yellow-400">A: {{ $contest->lolStat->assists ?? 0 }}</span>
          <span class="text-blue-400">CS: {{ $contest->lolStat->cs ?? 0 }}</span>
        </div>
        @if($contest->lolStat->kills && $contest->lolStat->deaths)
        <p class="text-xs text-gray-400 mt-1">
          KDA: {{ number_format(($contest->lolStat->kills + $contest->lolStat->assists) / max($contest->lolStat->deaths, 1), 2) }}
        </p>
        @endif
      </div>
    </div>
    @else
    <p class="text-gray-400 text-sm">Estatísticas do LoL não disponíveis</p>
    @endif
    @break

    @case('CS2')
    @if($contest->csStat)
    <div class="space-y-2">
      <p class="text-sm"><strong>Mapa:</strong> {{ $contest->csStat->map_played ?? 'Não informado' }}</p>
      <div class="flex space-x-4 text-sm">
        <span class="text-green-400">K: {{ $contest->csStat->kills ?? 0 }}</span>
        <span class="text-red-400">D: {{ $contest->csStat->deaths ?? 0 }}</span>
        <span class="text-yellow-400">HS: {{ $contest->csStat->hs_percent ?? 0 }}%</span>
        <span class="text-blue-400">MVPs: {{ $contest->csStat->mvps ?? 0 }}</span>
      </div>
      @if($contest->csStat->kills && $contest->csStat->deaths)
      <p class="text-xs text-gray-400">
        K/D: {{ number_format($contest->csStat->kills / max($contest->csStat->deaths, 1), 2) }}
      </p>
      @endif
    </div>
    @else
    <p class="text-gray-400 text-sm">Estatísticas do CS2 não disponíveis</p>
    @endif
    @break

    @default
    <p class="text-gray-400 text-sm">Estatísticas não disponíveis para este jogo</p>
    @endswitch
  </div>

  <div class="flex justify-end space-x-2 mt-4">
    <a href="{{ route('user.contest.edit', ['game' => session('current_game'), 'contest' => $contest->id]) }}"
      class="px-3 py-1 bg-[#544591] hover:bg-[#4F9CF9] text-white rounded">Editar</a>

    <form action="{{ route('user.contest.destroy', ['game' => session('current_game'), 'contest' => $contest->id]) }}" method="POST" onsubmit="return confirm('Tem certeza?')">
      @csrf
      @method('DELETE')
      <button type="submit" class="px-3 py-1 bg-red-600 hover:bg-red-700 text-white rounded">Excluir</button>
    </form>
  </div>
</div>

@empty
<div class="text-red-500 text-center">Nenhuma partida encontrada.</div>
@endforelse
@endsection