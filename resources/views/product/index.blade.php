@extends('layouts.baseTemplate');

@section('contenido')

<a href="products/create" class="btn btn-primary">CREAR</a>

<div class="row justify-content-center">
    <table class="table table-dark table-striped table-responsive mt-4">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Category_ID</th>
                <th scope="col">Name</th>
                <th scope="col">Description</th>
                <th scope="col">Brand</th>
                <th scope="col">Price</th>
                <th scope="col">Oficial Site</th>
                <th scope="col">Image</th>
                <th scope="col">Actions</th>
            </tr>
        </thead>
        
        <tbody>
            @foreach ($products as $product)
            <tr>
                <td>{{ $product->id }}</td>
                <td>{{ $product->category_ID }}</td>
                <td>{{ $product->name }}</td>
                <td>{{ $product->description }}</td>
                <td>{{ $product->brand }}</td>
                <td>{{ $product->price }}</td>
                <td>{{ $product->product_official_site }}</td>
                <td>{{ $product->product_image }}</td>

                <td>
                    <form action="{{ route('products.destroy', $product->id)}}" method="POST">
                        <a href="/products/{{$product->id}}/edit" class="btn btn-info">Editar</a>
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger">Borrar</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection