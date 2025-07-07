@extends('layouts.user')

@section('title')
<h1>Detalhes da Partida</h1>
@endsection

@section('content')
<div class="bg-[#1C1C1E] border border-[#544591] rounded-lg shadow-lg p-6 text-white">

  <div class="flex justify-between items-center mb-4">
    <h2 class="text-2xl font-bold">{{ $contest->game->name }}</h2>
    <span class="text-lg text-gray-400">{{ $contest->contest_date }}</span>
  </div>

  <div class="mb-4">
    <p class="mb-2">
      <strong>Resultado:</strong>
      <span class="px-2 py-1 rounded 
        @if($contest->result == 'Victory') bg-green-600 
        @elseif($contest->result == 'Defeat') bg-red-600 
        @else bg-gray-600 @endif">
        {{ $contest->result ?? 'Não informado' }}
      </span>
    </p>

    @if($contest->notes)
    <p class="mb-2">
      <strong>Notas:</strong> {{ $contest->notes }}
    </p>
    @endif
  </div>

  @if($contest->lolStat)
  <div class="bg-[#2A2A2E] p-4 rounded-lg mb-4">
    <h3 class="text-xl font-semibold mb-3">Estatísticas - League of Legends</h3>
    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
      <div>
        <strong>Campeão:</strong> {{ $contest->lolStat->champion_played }}
      </div>
      <div>
        <strong>Kills:</strong> {{ $contest->lolStat->kills }}
      </div>
      <div>
        <strong>Deaths:</strong> {{ $contest->lolStat->deaths }}
      </div>
      <div>
        <strong>Assists:</strong> {{ $contest->lolStat->assists }}
      </div>
      <div>
        <strong>CS:</strong> {{ $contest->lolStat->cs }}
      </div>
      <div>
        <strong>KDA:</strong>
        @if($contest->lolStat->deaths > 0)
        {{ number_format(($contest->lolStat->kills + $contest->lolStat->assists) / $contest->lolStat->deaths, 2) }}
        @else
        Perfeito
        @endif
      </div>
    </div>
  </div>
  @endif

  @if($contest->csStat)
  <div class="bg-[#2A2A2E] p-4 rounded-lg mb-4">
    <h3 class="text-xl font-semibold mb-3">Estatísticas - CS2</h3>
    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
      <div>
        <strong>Mapa:</strong> {{ $contest->csStat->map_played }}
      </div>
      <div>
        <strong>Kills:</strong> {{ $contest->csStat->kills }}
      </div>
      <div>
        <strong>Deaths:</strong> {{ $contest->csStat->deaths }}
      </div>
      <div>
        <strong>HS%:</strong> {{ $contest->csStat->hs_percent }}%
      </div>
      <div>
        <strong>MVPs:</strong> {{ $contest->csStat->mvps }}
      </div>
      <div>
        <strong>K/D:</strong>
        @if($contest->csStat->deaths > 0)
        {{ number_format($contest->csStat->kills / $contest->csStat->deaths, 2) }}
        @else
        Perfeito
        @endif
      </div>
    </div>
  </div>
  @endif

  <div class="flex space-x-4 mt-6">
    <a href="{{ route('user.contests.index', ['game' => $game->id]) }}" class="px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded">
      Voltar
    </a>
    <a href="{{ route('user.contest.edit', ['game' => $game->id, 'contest' => $contest->id]) }}" class="px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded">
      Editar
    </a>
  </div>

</div>
@endsection