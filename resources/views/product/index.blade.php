@extends('layouts.baseTemplate');

@section('css')
<link href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css" rel="stylesheet">
@endsection

@section('contenido')

<a href="products/create" class="btn btn-primary mb-3">CREAR</a>

<table id="products" class="table table-striped table-bordered shadow-lg" style="width:100%">
    <thead class="bg-primary text-white">
        <tr>
            <th scope="col">ID</th>
            <th scope="col">Category</th>
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
            <td>{{ $product->category->name }}</td>
            <td>{{ $product->name }}</td>
            <td>{{ $product->description }}</td>
            <td>{{ $product->brand }}</td>
            <td>{{ $product->price }}</td>
            <td>{{ $product->product_official_site }}</td>
            <td><img src="{{ $product->product_image }}" width="200"></td>

            <td>
                <form action="{{ route('products.destroy', $product->id)}}" method="POST">
                    <a href="/products/{{$product->id}}/edit" class="btn btn-info">Editar</a>
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Borrar</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

@section('js')
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>

<script>
    $(document).ready(function () {
    $('#products').DataTable({
        "lenghtMenu": [[5,10,20,50,-1],[5,10,20,50,"All"]]
    });
});
</script>
@endsection

@endsection