<form action="{{ $action }}" method="POST">
    @csrf
    @if(isset($method))
        @method($method)
    @endif
    <div class="mb-3">
        <label for="" class="form-label">Categoría</label>
        <select id="category_id" name="category_id" type="number" class="form-control" tabindex="1" required>
            @foreach($categories as $category)
                <option value="{{$category->id}}" {{ isset($product) && $category->id == $product->category_ID ? 'selected' : '' }}>{{$category->name}}</option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label for="name" class="form-label">Nombre</label>
        <input id="name" name="name" type="text" class="form-control" tabindex="1" value="{{ $product->name ?? '' }}" required>
    </div>

    <div class="mb-3">
        <label for="description" class="form-label">Descripción</label>
        <textarea id="description" name="description" type="text" class="form-control" tabindex="1" rows="3" required>{{ $product->description ?? '' }}</textarea>
    </div>

    <div class="mb-3">
        <label for="brand" class="form-label">Marca</label>
        <input id="brand" name="brand" type="text" class="form-control" tabindex="1" value="{{ $product->brand ?? '' }}" required>
    </div>

    <div class="mb-3">
        <label for="price" class="form-label">Precio</label>
        <input id="price" name="price" type="number" class="form-control" tabindex="1" value="{{ $product->price ?? '' }}" required>
    </div>

    <div class="mb-3">
        <label for="official_site" class="form-label">Sitio oficial</label>
        <input id="official_site" name="official_site" type="text" class="form-control" tabindex="1" value="{{ $product->product_official_site ?? '' }}" required>
    </div>

    <div class="mb-3">
        <label for="image" class="form-label">Imagen</label>
        <input id="image" name="image" type="text" class="form-control" tabindex="1" value="{{ $product->product_image ?? '' }}" required>
    </div>

    <a href="/products" class="btn btn-secondary" tabindex="5">Cancelar</a>
    <button type="submit" class="btn btn-primary" tabindex="4">Guardar</button>
</form>