<form action="{{ $action }}" method="POST" class="w-full max-w-lg mx-auto">
  @csrf
  @if(isset($contest) && !empty($contest) && isset($contest['id']))
  @method('PUT')
  @endif
  <div class="space-y-4 rounded bg-[#1C1C1E] text-white p-4 shadow-lg">
    <label for="result">Resultado da partida</label>
    <input
      class="w-full rounded border border-[#4F9CF9] bg-[#1C1C1E] text-white text-base leading-8 px-3 py-2 outline-none transition-colors duration-200 ease-in-out focus:border-purple-500 focus:ring-2 focus:ring-purple-200"
      type="text" name="result" id="result" placeholder="Vitória"
      value="{{ old('result', $contest['result'] ?? '') }}" />
    @error('result')
    <p class="-mt-4 mb-4 text-sm text-red-500">{{ $message }}</p>
    @enderror

    <label for="notes">Anotações da partida</label>
    <textarea
      class="w-full rounded border border-[#4F9CF9] bg-[#1C1C1E] text-white text-base leading-8 px-3 py-2 outline-none transition-colors duration-200 ease-in-out focus:border-purple-500 focus:ring-2 focus:ring-purple-200"
      name="notes" id="notes" placeholder="Descreva a partida...">{{ old('notes', $contest['notes'] ?? '') }}</textarea>
    @error('notes')
    <p class="-mt-4 mb-4 text-sm text-red-500">{{ $message }}</p>
    @enderror

    <label for="contest_date">Data da partida</label>
    <input
      class="w-full rounded border border-[#4F9CF9] bg-[#1C1C1E] text-white text-base leading-8 px-3 py-2 outline-none transition-colors duration-200 ease-in-out focus:border-purple-500 focus:ring-2 focus:ring-purple-200"
      type="date" name="contest_date" id="contest_date"
      value="{{ old('contest_date', isset($contest['contest_date']) ? \Carbon\Carbon::parse($contest['contest_date'])->format('Y-m-d') : '') }}" />
    @error('contest_date')
    <p class="-mt-4 mb-4 text-sm text-red-500">{{ $message }}</p>
    @enderror

    @yield('ContestStats')

    <button type="submit"
      class="w-full rounded bg-purple-600 px-4 py-2 text-white hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-opacity-50">
      {{ isset($contest) && !empty($contest) && isset($contest['id']) ? 'Atualizar' : 'Salvar' }}
    </button>
  </div>
</form>