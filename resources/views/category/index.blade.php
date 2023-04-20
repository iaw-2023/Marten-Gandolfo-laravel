@extends('layouts.baseTemplate')
@include('components.navbar', ['activeLink' => 'categories'])

@section('css')
<link href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css" rel="stylesheet">
@endsection

@section('contenido')
@include('components.error-message')
<a href="categories/create" class="btn btn-primary mb-3">Nueva Categoria</a>

<table id="categories" class="table table-striped table-bordered shadow-lg" style="width:100%">
    <thead class="bg-primary text-white">
        <tr>
            <th class="text-center" scope="col">ID</th>
            <th class="text-center" scope="col">Nombre</th>
            <th class="text-center" scope="col"></th>
        </tr>
    </thead>
    
    <tbody>
        @foreach ($categories as $category)
        <tr>
            <td>{{ $category->id }}</td>
            <td>{{ $category->name }}</td>

            <td>
                <form id="delete-form-{{ $category->id }}" action="{{ route('categories.destroy', $category->id)}}" method="POST">
                    <a href="/categories/{{$category->id}}/edit" class="btn btn-info">Editar</a>
                    @csrf
                    @method('DELETE')
                    <button type="button" class="btn btn-danger" onclick="confirmDelete({{ $category->id }})">Borrar</button>
                </form>
            </td>

            <script>
            function confirmDelete(categoryId) {
                if (confirm("¿Está seguro de que desea eliminar esta categoría?")) {
                    document.getElementById('delete-form-'+categoryId).submit();
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
    $('#categories').DataTable({
        "lenghtMenu": [[5,10,20,-1],[5,10,20,"All"]]
    });
});
</script>
@endsection

@endsection