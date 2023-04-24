<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Pedidos') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
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
                                <td>{{ $order->client->email }}</td>
                                <td>{{ $order->order_date }}</td>
                                <td>${{ $order->price }}</td>
                                <td>
                                    <a href="/orders/{{ $order->id }}/details" class="btn btn-info">Detalles</a>
                                    <!--p>
                                        <button class="btn bg-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $order->id }}" aria-expanded="false" aria-controls="collapse{{ $order->id }}">Ver</button>
                                    </p>
                                    <div class="collapse" id="collapse{{ $order->id }}">
                                        <div class="card card-body">
                                            
                                            @foreach ($order->orderDetails as $detail)
                                                [{{$detail->product_ID}}] {{$detail->product->name}}    x{{$detail->units}}    ${{$detail->subtotal}}<br>
                                            @endforeach

                                        </div>
                                    </div> -->
                                </td>
                            </tr>

                            <!--div class="toast-container position-fixed bottom-0 end-0 p-3">
                                <div id="liveToast{{ $order->id }}" class="toast" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="false">
                                    <div class="toast-header">
                                        <img src="..." class="rounded me-2" alt="...">
                                        <strong class="me-auto">Detalle de orden: {{ $order->id }}</strong>
                                        <small>{{ $order->client->email }}</small>
                                        <button type="button" class="btn-close text-black" data-bs-dismiss="toast" aria-label="Close">X</button>
                                    </div>
                                    <div class="toast-body">
                                        @foreach ($order->orderDetails as $detail)
                                            [{{$detail->product_ID}}] {{$detail->product->name}}    x{{$detail->units}}    ${{$detail->subtotal}}<br>
                                        @endforeach
                                    </div>
                                </div>
                            </div-->

                            @endforeach
                        </tbody>
                    </table>

                    <!--div class="toast-container position-fixed bottom-0 end-0 p-3" id="toast-container"></div-->

                    @section('js')
                    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
                    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
                    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>

                    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/js/bootstrap.bundle.min.js"></script>
                    <script src="https://cdn.datatables.net/responsive/2.4.1/js/dataTables.responsive.min.js"></script>
                    <script src="https://cdn.datatables.net/responsive/2.4.1/js/responsive.bootstrap5.min.js"></script>

                    <script>
                        $(document).ready(function() {
                            $('#orders').DataTable( {
                                responsive: {
                                    details: {
                                        display: $.fn.dataTable.Responsive.display.modal( {
                                            header: function ( row ) {
                                                var data = row.data();
                                                return 'Details for '+data[0]+' '+data[1];
                                            }
                                        } ),
                                        renderer: $.fn.dataTable.Responsive.renderer.tableAll( {
                                            tableClass: 'table'
                                        } )
                                    }
                                }
                            } );
                        } );
                        
                        //var container = document.getElementById("toast-container");
                        //container.appendChild(document.getElementById("liveToast1"));
                        //container.appendChild(document.getElementById("liveToast2"));
                        //container.appendChild(document.getElementById("liveToast3"));
                        //container.appendChild(document.getElementById("liveToast4"));
                        //function showToast(orderId) {
                        //    var toastEl = document.getElementById('liveToast' + orderId);
                        //    var toast = new bootstrap.Toast(toastEl);
                        //    toast.show();
                        //}
                    </script>
                    @endsection
                </div>
            </div>
        </div>
    </div>
</x-app-layout>