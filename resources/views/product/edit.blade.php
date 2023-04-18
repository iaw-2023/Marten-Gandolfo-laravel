@extends('layouts.baseTemplate');

@section('contenido')

<h2>EDITAR REGISTRO</h2>

<form action="/products/{{$product->id}}" method="POST">

    @csrf

    @method('PUT')

    <div class="mb-3">
        <label for="" class="form-label">Category_ID</label>
        <select id="category_id" name="category_id" type="number" class="form-control" tabindex="1">
        @foreach($categories as $category)
            <option value="{{$category->id}}" @if($category->id == $product->category_ID) selected @endif>{{$category->name}}</option>
        @endforeach
        </select>
        <!--<input id="category_id" name="category_id" type="number" class="form-control" tabindex="1" value="{{$product->category_ID}}">-->
    </div>

    <div class="mb-3">
        <label for="" class="form-label">Name</label>
        <input id="name" name="name" type="text" class="form-control" tabindex="1" value="{{$product->name}}">
    </div>

    <div class="mb-3">
        <label for="" class="form-label">Description</label>
        <input id="description" name="description" type="text" class="form-control" tabindex="1" value="{{$product->description}}">
    </div>

    <div class="mb-3">
        <label for="" class="form-label">Brand</label>
        <input id="brand" name="brand" type="text" class="form-control" tabindex="1" value="{{$product->brand}}">
    </div>

    <div class="mb-3">
        <label for="" class="form-label">Price</label>
        <input id="price" name="price" type="number" class="form-control" tabindex="1" value="{{$product->price}}">
    </div>

    <div class="mb-3">
        <label for="" class="form-label">Product official site</label>
        <input id="official_site" name="official_site" type="text" class="form-control" tabindex="1" value="{{$product->product_official_site}}">
    </div>

    <div class="mb-3">
        <label for="" class="form-label">Product image</label>
        <input id="image" name="image" type="text" class="form-control" tabindex="1" value="{{$product->product_image}}">
    </div>

    <a href="/products" class="btn btn-secondary" tabindex="5">Cancelar</a>
    <button type="submit" class="btn btn-primary" tabindex="4">Guardar</button>

</form>

@endsection