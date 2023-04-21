@extends('layouts.baseTemplate')
@include('components.navbar', ['activeLink' => 'categories'])

@section('contenido')
@include('components.error-message')

<h2>Crear Categoría</h2>
@include('components.category-form', ['action' => '/categories'])

@endsection