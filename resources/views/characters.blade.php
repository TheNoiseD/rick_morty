<x-app-layout xmlns:livewire="">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Mis Personajes') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div id="character-container" class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-5 p-8">
            {{--        aca debe llegar la info de los personajes del usuario en el componente card-character.blade.php--}}
                    @foreach($characters as $character)
                        <livewire:card-character
                            :id="$character->id"
                            :name="$character->name"
                            :image="$character->image"
                            :status="$character->status"
                            :species="$character->species"
                            :location="$character->location"/>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('js/cards.js') }}"></script>

</x-app-layout>
