@extends('layouts.baseTemplate')
@include('components.navbar', ['activeLink' => 'categories'])

@section('contenido')

<h2>EDITAR REGISTRO</h2>
@include('components.error-message')
<form action="/categories/{{$category->id}}" method="POST">

    @csrf

    @method('PUT')

    <div class="mb-3">
        <label for="" class="form-label">Nombre</label>
        <input id="name" name="name" type="text" class="form-control" tabindex="1" value="{{$category->name}}" required>
    </div>

    <a href="/categories" class="btn btn-secondary" tabindex="5">Cancelar</a>
    <button type="submit" class="btn btn-primary" tabindex="4">Guardar</button>

</form>

@endsection