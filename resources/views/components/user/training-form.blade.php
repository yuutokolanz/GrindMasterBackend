<form action="{{ $action }}" method="POST" class="w-full max-w-lg mx-auto">
  @csrf
  @if(isset($training) && !empty($training) && isset($training['id']))
  @method('PUT')
  @endif
  <div class="space-y-4 rounded bg-[#1C1C1E] text-white p-4 shadow-lg">
    <label for="title" class="block text-sm font-medium">Título do treino</label>
    <input
      class="w-full rounded border border-[#4F9CF9] bg-[#1C1C1E] text-white text-base leading-8 px-3 py-2 outline-none transition-colors duration-200 ease-in-out focus:border-purple-500 focus:ring-2 focus:ring-purple-200"
      type="text" name="title" id="title" placeholder="Ex: Aim training, Flashbang practice..."
      value="{{ old('title', $training['title'] ?? '') }}" />
    @error('title')
    <p class="-mt-4 mb-4 text-sm text-red-500">{{ $message }}</p>
    @enderror

    <label for="description" class="block text-sm font-medium">Descrição do treino</label>
    <textarea
      class="w-full rounded border border-[#4F9CF9] bg-[#1C1C1E] text-white text-base leading-8 px-3 py-2 outline-none transition-colors duration-200 ease-in-out focus:border-purple-500 focus:ring-2 focus:ring-purple-200"
      name="description" id="description" rows="3" placeholder="Descreva o treino realizado...">{{ old('description', $training['description'] ?? '') }}</textarea>
    @error('description')
    <p class="-mt-4 mb-4 text-sm text-red-500">{{ $message }}</p>
    @enderror

    <div class="flex items-center">
      <input
        type="checkbox" name="repeatable" id="repeatable" value="1"
        class="mr-2 h-4 w-4 text-purple-600 border-gray-300 rounded focus:ring-purple-500"
        {{ old('repeatable', $training['repeatable'] ?? false) ? 'checked' : '' }} />
      <label for="repeatable" class="text-sm font-medium">Treino repetível</label>
    </div>
    @error('repeatable')
    <p class="-mt-4 mb-4 text-sm text-red-500">{{ $message }}</p>
    @enderror

    @yield('TrainingStats')

    <button type="submit"
      class="w-full rounded bg-purple-600 px-4 py-2 text-white hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-opacity-50">
      Salvar Treino
    </button>
  </div>
</form>