<div class="p-4 shadow-md rounded-md {{ $this->getBackgroundColor($location) }}">
    <h2 class="text-lg font-bold mb-4">{{ $name }}</h2>
    <img src="{{ $image }}" alt="Imagen del Personaje" class="w-full h-auto rounded mb-4">
    <p class="text-gray-600 mb-4">
        <ul>
            <li><strong>Status:</strong> {{ $status }}</li>
            <li><strong>Species:</strong> {{ $species }}</li>
        </ul>
    </p>
    <div class="p-4 flex justify-center">
        <button data-id="{{$id}}"  class="del-character mx-auto top-0 right-0 p-2 text-white  bg-red-600 hover:bg-red-800 rounded-full focus:outline-none focus:shadow-outline-red">
            Eliminar
        </button>
    </div>
</div>

