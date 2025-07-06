@extends('layouts.user')

@section('title')
<h1>Adicionar Treino - {{ $game->name }}</h1>
@endsection

@section('content')

<x-user.training-form :training="[]" action="{{ route('user.trainings.store', ['game' => $game->id]) }}" />

<div class="mt-6 text-center">
  <a href="{{ route('user.trainings.index', ['game' => $game->id]) }}"
    class="inline-block px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded">
    Voltar para listagem
  </a>
</div>

@endsection