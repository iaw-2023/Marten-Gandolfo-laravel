@extends('layouts.baseTemplate')

@section('css')
<link href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css" rel="stylesheet">
@endsection

@section('contenido')

<table id="orders" class="table table-striped table-bordered shadow-lg" style="width:100%">
    <thead class="bg-primary text-white">
        <tr>
            <th scope="col">Detalle</th>
            <th scope="col">Orden ID</th>
            <th scope="col">Cliente ID</th>
            <th scope="col">Fecha - Hora</th>
            <th scope="col">Monto</th>
        </tr>
    </thead>
    
    <tbody>
        @foreach ($orders as $order)
        <tr>
            <td>
                <p>
                    <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $order->id }}" aria-expanded="false" aria-controls="collapse{{ $order->id }}">Ver</button>
                </p>
                <div class="collapse" id="collapse{{ $order->id }}">
                    <div class="card card-body">
                        
                        @php $productn = 1; @endphp
                        @foreach ($details as $detail)
                            @if($detail->order_ID == $order->id)
                                {{ "--- Producto $productn ---" }}<br>
                                {{ "Producto ID: $detail->product_ID" }}<br>

                                @php $product = App\Models\Product::find($detail->product_ID); @endphp
                                
                                {{ "Producto: $product->name" }}<br>
                                {{ "Unidades: $detail->units" }}<br>
                                {{ "Subtotal: $detail->subtotal" }}<br><br>
                                
                                @php $productn++; @endphp
                            @endif
                        @endforeach

                    </div>
                </div>
            </td>
            <td>{{ $order->id }}</td>
            <td>{{ $order->client_ID }}</td>
            <td>{{ $order->order_date }}</td>
            <td>{{ $order->price }}</td>
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
    $('#orders').DataTable({
        "lenghtMenu": [[5,10,20,-1],[5,10,20,"All"]]
    });
});
</script>
@endsection

@endsection