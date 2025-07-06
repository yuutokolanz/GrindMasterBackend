@extends('layouts.user')

@section('title')
<h1>Listagem de treinos</h1>
@endsection

@section('content')
<a href="{{ route('user.trainings.create', ['game' => session('current_game')]) }}" class="inline-block mb-4 px-4 py-2 bg-green-500 hover:bg-green-600 text-white rounded">
  Criar treino
</a>
@forelse ($trainings as $training)
<div class="bg-[#1C1C1E] border border-[#544591] rounded-lg shadow-lg p-4 mb-4 text-white">

  <div class="flex justify-between items-center mb-2">
    <h2 class="text-lg font-bold">{{ $training->game->name }}</h2>
    <span class="text-sm text-gray-400">{{ $training->created_at->format('d/m/Y') }}</span>
  </div>

  <p class="mb-2">
    <strong>Título:</strong> {{ $training->title ?? 'Não informado' }}
  </p>

  <p class="mb-2">
    <strong>Descrição:</strong> {{ $training->description ?? 'Não informado' }}
  </p>

  <p class="mb-2">
    <strong>Repetível:</strong> {{ $training->repeatable ? 'Sim' : 'Não' }}
  </p>

  @if($training->completed_count > 0)
  <p class="mb-2">
    <strong>Vezes completado:</strong>
    <span class="inline-flex items-center px-2 py-1 text-xs font-medium bg-green-600 text-white rounded-full">
      {{ $training->completed_count }}x
    </span>
  </p>
  @endif

  <div class="flex justify-between items-center mt-4">
    <div class="flex space-x-2">
      @if($training->repeatable)
      <form action="{{ route('user.trainings.complete', ['game' => session('current_game'), 'training' => $training->id]) }}" method="POST"
        onsubmit="return confirm('Marcar treino como concluído?')">
        @csrf
        <button type="submit" class="px-3 py-1 bg-green-600 hover:bg-green-700 text-white rounded">
          Concluir
        </button>
      </form>
      @else
      <form action="{{ route('user.trainings.complete', ['game' => session('current_game'), 'training' => $training->id]) }}" method="POST"
        onsubmit="return confirm('Concluir e remover este treino?')">
        @csrf
        <button type="submit" class="px-3 py-1 bg-green-600 hover:bg-green-700 text-white rounded">
          Finalizar
        </button>
      </form>
      @endif
    </div>

    <div class="flex space-x-2">
      <a href="{{ route('user.trainings.edit', ['game' => session('current_game'), 'training' => $training->id]) }}"
        class="px-3 py-1 bg-[#544591] hover:bg-[#4F9CF9] text-white rounded">Editar</a>

      <form action="{{ route('user.trainings.destroy', ['game' => session('current_game'), 'training' => $training->id]) }}" method="POST" onsubmit="return confirm('Tem certeza?')">
        @csrf
        @method('DELETE')
        <button type="submit" class="px-3 py-1 bg-red-600 hover:bg-red-700 text-white rounded">Excluir</button>
      </form>
    </div>
  </div>
</div>

@empty
<div class="text-red-500 text-center">Nenhum treino encontrado para esse jogo.</div>
@endforelse
@endsection