@extends('layouts.baseTemplate')
@include('components.navbar', ['activeLink' => 'products'])

@section('css')
<link href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css" rel="stylesheet">
@endsection

@section('contenido')
@include('components.error-message')
<a href="products/create" class="btn btn-primary mb-3">Nuevo Producto</a>

<table id="products" class="table table-striped table-bordered shadow-lg" style="width:100%">
    <thead class="bg-primary text-white">
        <tr>
            <th class="text-center" scope="col">ID</th>
            <th class="text-center" scope="col">Imagen</th>
            <th class="text-center" scope="col">Nombre</th>
            <th class="text-center" scope="col">Precio</th>
            <th class="text-center" scope="col">Categoría</th>
            <th class="text-center" scope="col">Marca</th>
            <th class="text-center" scope="col"></th>
        </tr>
    </thead>
    
    <tbody>
        @foreach ($products as $product)
        <tr>
            <td>{{ $product->id }}</td>
            <td><img src="{{ $product->product_image }}" width="150"></td>
            <td>{{ $product->name }}</td>
            <td>${{ $product->price }}</td>
            <td>{{ $product->category->name }}</td>
            <td>{{ $product->brand }}</td>

            <td>
                <form id="delete-form-{{ $product->id }}" action="{{ route('products.destroy', $product->id)}}" method="POST">
                    <a href="/products/{{$product->id}}/edit" class="btn btn-info">Editar</a>
                    @csrf
                    @method('DELETE')
                    <button type="button" class="btn btn-danger" onclick="confirmDelete({{ $product->id }})">Borrar</button>
                </form>
            </td>

            <script>
            function confirmDelete(productId) {
                if (confirm("¿Está seguro de que desea eliminar este producto?")) {
                    document.getElementById('delete-form-'+productId).submit();
                }
            }
            </script>
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