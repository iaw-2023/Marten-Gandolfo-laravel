<style>
    @media (prefers-color-scheme: dark) {
        #name, #email, #username, #password, #passwordconfirmation, #superadmin {
            color: white;
            background-color: black;
        }
    }
</style>

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ $title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @include('components.error-message')
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100 dark:bg-gray-700">
                    <form action="{{$action}}" method="POST">
                    @csrf
                    @if(isset($method))
                        @method($method)
                    @endif
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input id="email" name="email" {{isset($method) ? 'disabled' : ''}} type="text" class="form-control" tabindex="1" maxlength="255" value="{{ old('email', $email ?? '') }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="name" class="form-label">Nombre</label>
                        <input id="name" name="name" type="text" class="form-control" tabindex="1" maxlength="255" value="{{ old('name', $name ?? '') }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="username" class="form-label">Nombre de Usuario</label>
                        <input id="username" name="username" type="text" class="form-control" tabindex="1" maxlength="255" value="{{ old('username', $username ?? '') }}" required>
                    </div>
                    @if(!isset($method))
                        <div class="mb-3">
                            <label for="password" class="form-label">Contraseña</label>
                            <input id="password" name="password" type="password" class="form-control" tabindex="1" maxlength="255" required>
                        </div>
                        <div class="mb-3">
                            <label for="passwordconfirmation" class="form-label">Confirmar Contraseña</label>
                            <input id="passwordconfirmation" name="passwordconfirmation" type="password" class="form-control" tabindex="1" maxlength="255" required>
                        </div>
                    @endif
                    <div class="mb-3">
                        <input id="superadmin" name="superadmin" type="checkbox" class="form-control" tabindex="1" value="1" {{ old('superadmin', $superadmin ?? 0) ? 'checked' : '' }} >
                        <label for="passwordconfirmation" class="form-label">Super Admin</label>
                    </div>
                    <a href="/users" class="btn bg-secondary" tabindex="5">Cancelar</a>
                    <button type="submit" class="btn bg-primary" tabindex="4">Guardar</button>
                </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

