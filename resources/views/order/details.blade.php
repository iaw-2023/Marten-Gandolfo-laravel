<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Detalles de la orden {{ $order->id }}, cliente {{ $order->email }}, fecha {{ $order->order_date }}
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

                    <table id="details" class="table table-striped table-bordered shadow-lg" style="width:100%">
                        <thead class="bg-primary text-white">
                            <tr>
                                <th class="text-center" scope="col">ID Producto</th>
                                <th class="text-center" scope="col">Producto</th>
                                <th class="text-center" scope="col">Unidades</th>
                                <th class="text-center" scope="col">Subtotal</th>
                            </tr>
                        </thead>
                        
                        <tbody>
                            @foreach ($order->orderDetails as $detail)
                                <tr>
                                    <td>{{ $detail->product_ID }}</td>
                                    <td>{{ $detail->product()->withTrashed()->first()->name }}</td>
                                    <td>{{ $detail->units }}</td>
                                    <td>${{ $detail->subtotal }}</td>
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
                            $('#details').DataTable({
                                "lenghtMenu": [[5,10,20,50,-1],[5,10,20,50,"All"]],
                                "language": {
                                    "emptyTable": "No hay datos disponibles para mostrar",
                                    "zeroRecords": "No se encontraron resultados para su busqueda",
                                    "infoEmpty": "Mostrando 0 detalles de la orden",
                                    "infoFiltered": "(filtrado de un total de _MAX_ detalles de la orden)",
                                    "lengthMenu": "Mostrar _MENU_ detalles de la orden",
                                    "search": "Buscar:",
                                    "info": "Mostrando los detalles _START_ - _END_ (detalles totales de la orden _MAX_)",
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
