<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Pedidos') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100 dark:bg-gray-700">
                    @section('css')
                    <link href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css" rel="stylesheet">
                    @endsection

                    @include('components.error-message')

                    <table id="orders" class="table table-striped table-bordered shadow-lg" style="width:100%">
                        <thead class="bg-primary text-white">
                            <tr>
                                <th class="text-center" scope="col">ID</th>
                                <th class="text-center" scope="col">Cliente</th>
                                <th class="text-center" scope="col">Fecha - Hora</th>
                                <th class="text-center" scope="col">Monto</th>
                                <th class="text-center" scope="col">Detalle</th>
                            </tr>
                        </thead>
                        
                        <tbody>
                            @foreach ($orders as $order)
                            <tr>
                                <td>{{ $order->id }}</td>
                                <td>{{ $order->email }}</td>
                                <td>{{ $order->order_date }}</td>
                                <td>${{ $order->price }}</td>
                                <td>
                                    <a href="/orders/{{ $order->id }}/details" class="btn btn-info">Detalles</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    @section('js')
                    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
                    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
                    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>

                    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/js/bootstrap.bundle.min.js"></script>
                    <script src="https://cdn.datatables.net/responsive/2.4.1/js/dataTables.responsive.min.js"></script>
                    <script src="https://cdn.datatables.net/responsive/2.4.1/js/responsive.bootstrap5.min.js"></script>

                    <script>
                        $(document).ready(function () {
                            $('#orders').DataTable({
                                "order": [[ 2, "desc" ]],
                                "lenghtMenu": [[5,10,20,50,-1],[5,10,20,50,"All"]],
                                "language": {
                                    "emptyTable": "No hay datos disponibles para mostrar",
                                    "zeroRecords": "No se encontraron resultados para su busqueda",
                                    "infoEmpty": "Mostrando 0 pedidos",
                                    "infoFiltered": "(filtrado de un total de _MAX_ pedidos)",
                                    "lengthMenu": "Mostrar _MENU_ pedidos",
                                    "search": "Buscar:",
                                    "info": "Mostrando los pedidos _START_ - _END_ (pedidos totales _MAX_)",
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