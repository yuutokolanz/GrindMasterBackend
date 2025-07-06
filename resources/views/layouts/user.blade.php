<!DOCTYPE html>
<html>

@include('shared.head')

<body class="body-font bg-gray-600 text-slate-100">
    <x-user.header>
    @section('select-game')
    <!-- Formulário de seleção de jogo -->
    @if(isset($games))
    <form action="{{ route('user.set-game') }}" method="POST" class="flex items-center">
      @csrf
      <select name="game_id" onchange="this.form.submit()" class="rounded border border-[#4F9CF9] bg-[#1C1C1E] text-white p-2 text-gray-700 focus:border-purple-500 focus:ring-2 focus:ring-purple-200">

        @foreach ($games as $game)
        <option value="{{ $game->id }}" {{ session('current_game') == $game->id ? 'selected' : '' }}>
          {{ $game->name }}
        </option>
        @endforeach

      </select>
    </form>
    @endif
    @endsection

    @section('select-view')
    <!-- Formulário de seleção de visualização -->
    <form action="{{ route('user.toggle-view') }}" method="POST" class="flex items-center ml-4">
      @csrf
      <select name="view" onchange="this.form.submit()" class="rounded border border-[#4F9CF9] bg-[#1C1C1E] text-white p-2 text-gray-700 focus:border-purple-500 focus:ring-2 focus:ring-purple-200">
        <option value="contests" {{ session('view') == 'contests' ? 'selected' : '' }}>Contests</option>
        <option value="trainings" {{ session('view') == 'trainings' ? 'selected' : '' }}>Trainings</option>
      </select>
    </form>
    @endsection
    </x-user.header>
    <section class="container mx-auto bg-gray-600 px-5 md:px-0">

        <h1 class="py-4 text-lg font-normal">@yield('title')</h1>

        @yield('content')

    </section>
</body>

</html>