<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight dark:bg-gray-700">
            {{ __('Productos') }}
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
                        <a href="products/create" class="btn btn-primary mb-3">Nuevo Producto</a>
                    @endif

                    <table id="products" class="table table-striped table-bordered shadow-lg" style="width:100%">
                        <thead class="bg-primary text-white">
                            <tr>
                                <th class="text-center" scope="col">ID</th>
                                <th class="text-center" scope="col">Imagen</th>
                                <th class="text-center" scope="col">Nombre</th>
                                <th class="text-center" scope="col">Precio</th>
                                <th class="text-center" scope="col">Categoría</th>
                                <th class="text-center" scope="col">Marca</th>
                                
                                @if(Auth::user()->hasRole('Super Admin'))
                                    <th class="text-center" scope="col"></th>
                                @endif
                            </tr>
                        </thead>
                        
                        <tbody>
                            @foreach ($products as $product)
                            <tr>
                                <td>{{ $product->id }}</td>
                                <td><img src="data:image/webp;base64,{{ $product->product_image }}" width="150"></td>
                                <td>{{ $product->name }}</td>
                                <td>${{ $product->price }}</td>
                                <td>{{ $product->category->name }}</td>
                                <td>{{ $product->brand }}</td>
                                
                                @if(Auth::user()->hasRole('Super Admin'))
                                    <td>
                                        <form id="delete-form-{{ $product->id }}" action="{{ route('products.destroy', $product->id)}}" method="POST">
                                            <a href="/products/{{$product->id}}/edit" class="btn btn-info mb-1">Editar</a>
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn bg-danger" onclick="confirmDelete({{ $product->id }})">Borrar</button>
                                        </form>
                                    </td>
                                @endif

                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    @section('js')
                    <script>
                        function confirmDelete(productId) {
                            if (confirm("¿Está seguro de que desea eliminar este producto?")) {
                                document.getElementById('delete-form-'+productId).submit();
                            }
                        }
                    </script>
                    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
                    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
                    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>

                    <script>
                        $(document).ready(function () {
                            $('#products').DataTable({
                                "lenghtMenu": [[5,10,20,50,-1],[5,10,20,50,"All"]],
                                "language": {
                                    "emptyTable": "No hay datos disponibles para mostrar",
                                    "zeroRecords": "No se encontraron resultados para su busqueda",
                                    "infoEmpty": "Mostrando 0 productos",
                                    "infoFiltered": "(filtrado de un total de _MAX_ productos)",
                                    "lengthMenu": "Mostrar _MENU_ productos",
                                    "search": "Buscar:",
                                    "info": "Mostrando los productos _START_ - _END_ (productos totales _MAX_)",
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