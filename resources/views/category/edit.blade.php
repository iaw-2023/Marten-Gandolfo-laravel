@extends('layouts.baseTemplate')
@include('components.navbar', ['activeLink' => 'categories'])

@section('contenido')
@include('components.error-message')

<h2>Editar Categoría</h2>
@include('components.category-form', ['action' => '/categories/'.$category->id, 'method' => 'PUT', 'name' => $category->name])

@endsection