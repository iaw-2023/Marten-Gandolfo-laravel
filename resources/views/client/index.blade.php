@extends('layouts.baseTemplate')
@include('components.navbar', ['activeLink' => 'clients'])

@section('css')
<link href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css" rel="stylesheet">
@endsection

@section('contenido')

<table id="clients" class="table table-striped table-bordered shadow-lg" style="width:100%">
    <thead class="bg-primary text-white">
        <tr>
            <th scope="col">ID</th>
            <th scope="col">email</th>
        </tr>
    </thead>
    
    <tbody>
        @foreach ($clients as $client)
        <tr>
            <td>{{ $client->id }}</td>
            <td>{{ $client->email }}</td>
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