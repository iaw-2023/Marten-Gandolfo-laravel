<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ $title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form action="{{$action}}" method="POST">
                    @csrf
                    @if(isset($method))
                        @method($method)
                    @endif
                    <div class="mb-3">
                        <label for="name" class="form-label">Nombre</label>
                        <input id="name" name="name" type="text" class="form-control" tabindex="1" maxlength="255" value="{{ $name ?? '' }}" required>
                    </div>
                    <a href="/categories" class="btn bg-secondary" tabindex="5">Cancelar</a>
                    <button type="submit" class="btn bg-primary" tabindex="4">Guardar</button>
                </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

