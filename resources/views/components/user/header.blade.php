<header class="text-gray-600 body-font">
  <div class="container mx-auto flex flex-wrap p-5 flex-col md:flex-row items-center justify-between">

    <a href="{{ session('current_game') ? route('user.contests.index', ['game' => session('current_game')]) : '#' }}" class="flex title-font font-medium items-center text-white mb-4 md:mb-0">
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-10 h-10 text-white p-2 bg-[#544591] hover:bg-[#4F9CF9] rounded-full" viewBox="0 0 24 24">
        <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"></path>
      </svg>
      <span class="ml-3 text-xl">{{ env('APP_NAME') }}</span>
    </a>

    @yield('select-game')

    @yield('select-view')

    <form action="{{ route('logout') }}" method="POST">
      @csrf
      <button type="submit" class="ml-4 inline-flex items-center bg-red-500 border-0 py-1 px-3 hover:bg-red-600 rounded text-base text-slate-300">Sair</button>
    </form>

  </div>
</header>