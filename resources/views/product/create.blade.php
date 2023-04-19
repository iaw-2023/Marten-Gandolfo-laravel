@extends('layouts.baseTemplate')
@include('components.navbar', ['activeLink' => 'products'])

@section('contenido')

<h2>CREAR REGISTRO</h2>

<form action="/products" method="POST">

    @csrf

    <div class="mb-3">
        <label for="" class="form-label">Categoría</label>
        <select id="category_id" name="category_id" type="number" class="form-control" tabindex="1" required>
        @foreach($categories as $category)
            <option value="{{$category->id}}">{{$category->name}}</option>
        @endforeach
        </select>
        <!--<input id="category_id" name="category_id" type="number" class="form-control" tabindex="1">-->
    </div>

    <div class="mb-3">
        <label for="" class="form-label">Nombre</label>
        <input id="name" name="name" type="text" class="form-control" tabindex="1" required>
    </div>

    <div class="mb-3">
        <label for="" class="form-label">Descripción</label>
        <textarea id="description" name="description" type="text" class="form-control" tabindex="1" rows="3" required></textarea>
    </div>

    <div class="mb-3">
        <label for="" class="form-label">Marca</label>
        <input id="brand" name="brand" type="text" class="form-control" tabindex="1" required>
    </div>

    <div class="mb-3">
        <label for="" class="form-label">Precio</label>
        <input id="price" name="price" type="number" class="form-control" tabindex="1" required>
    </div>

    <div class="mb-3">
        <label for="" class="form-label">Sitio oficial</label>
        <input id="official_site" name="official_site" type="text" class="form-control" tabindex="1" required>
    </div>

    <div class="mb-3">
        <label for="" class="form-label">Imagen</label>
        <input id="image" name="image" type="text" class="form-control" tabindex="1" required>
    </div>

    <a href="/products" class="btn btn-secondary" tabindex="5">Cancelar</a>
    <button type="submit" class="btn btn-primary" tabindex="4">Guardar</button>

</form>

@endsection