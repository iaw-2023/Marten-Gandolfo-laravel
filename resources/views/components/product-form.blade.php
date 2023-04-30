<style>
    @media (prefers-color-scheme: dark) {
        #name, #description, #brand, #price, #official_site, #image, #category_id {
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
                    <form action="{{ $action }}" method="POST">
                    @csrf
                    @if(isset($method))
                        @method($method)
                    @endif
                    <div class="mb-3">
                        <label for="" class="form-label">Categoría</label>
                        <select id="category_id" name="category_id" type="number" class="form-control" tabindex="1" required>
                            @foreach($categories as $category)
                                <option value="{{$category->id}}" {{ (old('category_id') ? (old('category_id') == $category->id ? 'selected' : '') : ((isset($product) && $category->id == $product->category_ID) ? 'selected' : '')) }}>{{$category->name}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="name" class="form-label">Nombre</label>
                        <input id="name" name="name" type="text" class="form-control" tabindex="1" maxlength="255" value="{{ old('name', $product->name ?? '') }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Descripción</label>
                        <textarea id="description" name="description" type="text" class="form-control" tabindex="1" maxlength="1000" rows="3" required>{{ old('description', $product->description ?? '') }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label for="brand" class="form-label">Marca</label>
                        <input id="brand" name="brand" type="text" class="form-control" tabindex="1" maxlength="255" value="{{ old('brand', $product->brand ?? '') }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="price" class="form-label">Precio</label>
                        <input id="price" name="price" type="number" class="form-control" tabindex="1" value="{{ old('price', $product->price ?? '') }}" min="0.01" step="0.01" required>
                    </div>

                    <div class="mb-3">
                        <label for="official_site" class="form-label">Sitio oficial</label>
                        <input id="official_site" name="official_site" type="text" class="form-control" tabindex="1" maxlength="255" value="{{ old('official_site', $product->product_official_site ?? '') }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="image" class="form-label">Imagen</label>
                        <input id="image" name="image" type="text" class="form-control" tabindex="1" maxlength="255" value="{{ old('image', $product->product_image ?? '') }}" required>
                    </div>

                    <a href="/products" class="btn bg-secondary" tabindex="5">Cancelar</a>
                    <button type="submit" class="btn bg-primary" tabindex="4">Guardar</button>
                </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

