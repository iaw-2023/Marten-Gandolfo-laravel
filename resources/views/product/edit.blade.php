@extends('layouts.baseTemplate')
@include('components.navbar', ['activeLink' => 'products'])

@section('contenido')
@include('components.error-message')

<h2>Editar Producto</h2>
@include('components.product-form', ['action' => '/products/'.$product->id, 'product' => $product, 'categories' => $categories, 'method' => 'PUT'])

@endsection