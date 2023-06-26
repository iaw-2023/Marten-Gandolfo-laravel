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

                    <div class="py-12">
                        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                            <div class="bg-gray-200 dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                                <div class="p-6 text-gray-900 dark:text-gray-100 dark:bg-gray-800">
                                    <!-- Add a container to display currency values -->
                                    <h5 class="mb-3">Aqui puedes consultar informacion de la moneda local:</h5> 

                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="usd_in_label">U$D</span>
                                        <input type="number" class="form-control" placeholder="Dolares" id="usd_in">
                                    </div>
                                
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="basic-addon1">Te duelen&nbsp;
                                            <div id="currency-container">
                                                <!-- Placeholder text until currency values are fetched -->
                                                <p>...</p>
                                            </div>
                                        </span>
                                    </div>

                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="profit_label">Margen de ganancia (%):</span>
                                        <input type="number" class="form-control" placeholder="Ingrese el porcentaje de ganancia deseado" id="profit">
                                    </div>

                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="basic-addon1">Precio final&nbsp;
                                            <div id="profit-container">
                                                <!-- Placeholder -->
                                                <p>...</p>
                                            </div>
                                        </span>
                                    </div>

                                    <h5 class="mb-3">Powered by Open Exchange Rates API</h5> 
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="price" class="form-label">Precio</label>
                        <input id="price" name="price" type="number" class="form-control" tabindex="1" value="{{ old('price', $product->price ?? '') }}" min="0.01" step="0.01" required>
                    </div>

                    <div class="mb-3">
                        <label for="official_site" class="form-label">Sitio oficial</label>
                        <input id="official_site" name="official_site" type="text" class="form-control" tabindex="1" maxlength="255" value="{{ old('official_site', $product->product_official_site ?? '') }}" required>
                    </div>

                    <!-- <div class="mb-3">
                        <label for="image" class="form-label">Imagen</label>
                        <input id="image" name="image" type="text" class="form-control" tabindex="1" maxlength="255" value="{{ old('image', $product->product_image ?? '') }}" required>
                        <img src="data:image/webp;base64,{{ old('image', $product->product_image ?? '') }}" width="150">
                    </div> -->

                    <div class="mb-3">
                        <label for="image" class="form-label">Imagen</label>
                        <input id="image-picker" name="image-picker" type="file" class="form-control p-1" tabindex="1">
                        <img id="preview-image" class="mt-2" src="data:image/webp;base64,{{ old('image', $product->product_image ?? '') }}" width="150" alt="Imagen">
                        <input id="image" name="image" type="hidden" class="form-control" value="{{ old('image', $product->product_image ?? '') }}" required>
                    </div>

                    <a href="/products" class="btn bg-secondary" tabindex="5">Cancelar</a>
                    <button type="submit" class="btn bg-primary" tabindex="4">Guardar</button>
                </form>
                </div>
            </div>
        </div>
    </div>

    @section('js')
        <script>
            function updateCurrency() {
                const usdInput = document.getElementById('usd_in');
                const currencyContainer = document.getElementById('currency-container');

                // Fetch currency values from the API
                fetch('https://openexchangerates.org/api/latest.json?app_id=095b1852234c47d58db11fb96c35ec9a')
                    .then(response => response.json())
                    .then(data => {
                        // Extract currency values from the API response
                        const currencyValues = data.rates;
                        const usd = parseFloat(usdInput.value);

                        // Update the currency container with the fetched values
                        currencyContainer.innerHTML = `
                            <p>${(usd*currencyValues.ARS).toFixed(2)} pesos + ${((usd*currencyValues.ARS)*0.75).toFixed(2)} de impuestos, total ${(usd*currencyValues.ARS+((usd*currencyValues.ARS)*0.75)).toFixed(2)}</p>
                            <input hidden id="original-price" value="${(usd*currencyValues.ARS+((usd*currencyValues.ARS)*0.75)).toFixed(2)}"/>
                            `;

                        // Revert profit changes
                        const profitContainer = document.getElementById('profit-container');
                        const profit = document.getElementById('profit');

                        profit.value = "";
                        profitContainer.innerHTML = `
                            <p>...</p>
                        `;
                    })
                    .catch(error => {
                        console.error('Error fetching currency values:', error);
                    });
            }

            function updatePrice() {
                const profitContainer = document.getElementById('profit-container');
                const profit = document.getElementById('profit');
                const originalPrice = document.getElementById('original-price');

                const price = parseFloat(originalPrice.value);
                const profitPercentage = parseFloat(profit.value);

                const calculatedPrice = (price + (price * (profitPercentage / 100))).toFixed(2);

                // Update the final
                profitContainer.innerHTML = `
                    <p>${calculatedPrice} pesos </p>
                `;
            }

            // Add event listener to the usd_in input field
            const usdInput = document.getElementById('usd_in');
            usdInput.addEventListener('input', updateCurrency);

            const profitInput = document.getElementById('profit');
            profitInput.addEventListener('input', updatePrice);

        </script>
    @endsection
    @vite(['resources/js/image-picker.js'])
    <!-- <script src="{{ asset('resources\js\image-picker.js') }}"></script> -->
</x-app-layout>

