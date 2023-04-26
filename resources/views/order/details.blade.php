<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Detalles de la orden {{ $order->id }}, cliente {{ $order->client->email }}, fecha {{ $order->order_date }}
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

                </div>
            </div>
        </div>
    </div>
</x-app-layout>