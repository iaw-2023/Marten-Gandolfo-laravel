@extends('layouts.baseTemplate')
@include('components.navbar', ['activeLink' => 'products'])

@section('contenido')
@include('components.error-message')

<h2>Crear Producto</h2>
@include('components.product-form', ['action' => '/products', 'categories' => $categories])

@endsection