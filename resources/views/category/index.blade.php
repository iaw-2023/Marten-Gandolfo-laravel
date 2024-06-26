<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Categorias') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @include('components.error-message')
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100 dark:bg-gray-700">
                    @section('css')
                    <link href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css" rel="stylesheet">
                    @endsection

                    @if(Auth::user()->hasRole('Super Admin'))
                        <a href="categories/create" class="btn btn-primary mb-3">Nueva Categoria</a>
                    @endif

                    <table id="categories" class="table table-striped table-bordered shadow-lg" style="width:100%">
                        <thead class="bg-primary text-white">
                            <tr>
                                <th class="text-center" scope="col">ID</th>
                                <th class="text-center" scope="col">Nombre</th>

                                @if(Auth::user()->hasRole('Super Admin'))
                                    <th class="text-center" scope="col"></th>
                                @endif
                            </tr>
                        </thead>
                        
                        <tbody>
                            @foreach ($categories as $category)
                            <tr>
                                <td>{{ $category->id }}</td>
                                <td>{{ $category->name }}</td>

                                @if(Auth::user()->hasRole('Super Admin'))
                                    <td>
                                        <form id="delete-form-{{ $category->id }}" action="{{ route('categories.destroy', $category->id)}}" method="POST">
                                            <a href="/categories/{{$category->id}}/edit" class="btn btn-info">Editar</a>
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn bg-danger" onclick="confirmDelete({{ $category->id }})">Borrar</button>
                                        </form>
                                    </td>
                                @endif

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
                                "lenghtMenu": [[5,10,20,50,-1],[5,10,20,50,"All"]],
                                "language": {
                                    "emptyTable": "No hay datos disponibles para mostrar",
                                    "zeroRecords": "No se encontraron resultados para su busqueda",
                                    "infoEmpty": "Mostrando 0 categorias",
                                    "infoFiltered": "(filtrado de un total de _MAX_ categorias)",
                                    "lengthMenu": "Mostrar _MENU_ categorias",
                                    "search": "Buscar:",
                                    "info": "Mostrando las categorias _START_ - _END_ (categorias totales _MAX_)",
                                    "paginate": {
                                        "previous": "Anterior",
                                        "next": "Siguiente"
                                    }
                                }
                            });
                        });
                    </script>
                    @endsection
                </div>
            </div>
        </div>
    </div>
</x-app-layout>