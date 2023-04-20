@extends('layouts.baseTemplate')
@include('components.navbar', ['activeLink' => 'categories'])

@section('contenido')
@include('components.error-message')

<h2>CREAR REGISTRO</h2>
<form action="/categories" method="POST">

    @csrf
    <div class="mb-3">
        <label for="" class="form-label">Name</label>
        <input id="name" name="name" type="text" class="form-control" tabindex="1" required>
    </div>

    <a href="/categories" class="btn btn-secondary" tabindex="5">Cancelar</a>
    <button type="submit" class="btn btn-primary" tabindex="4">Guardar</button>

</form>

@endsection