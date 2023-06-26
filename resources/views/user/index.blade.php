<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Usuarios') }}
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

                    <a href="users/create" class="btn btn-primary mb-3">Nuevo Usuario</a>

                    <div style="overflow-x: auto;">
                        <table id="users" class="table table-striped table-bordered shadow-lg" style="width:100%">
                            <thead class="bg-primary text-white">
                                <tr>
                                    <th class="text-center" scope="col">ID</th>
                                    <th class="text-center" scope="col">Email</th>
                                    <th class="text-center" scope="col">Super Admin</th>

                                    <th class="text-center" scope="col"></th>
                                </tr>
                            </thead>
                            
                            <tbody>
                                @foreach ($users as $user)
                                <tr>
                                    <td>{{ $user['id'] }}</td>
                                    <td>{{ $user['email'] }}</td>
                                    <td>{{ $user['roles']->contains('Super Admin') ? 'Si' : 'No' }}</td>

                                    <td>
                                        <form id="delete-form-{{ $user['id'] }}" action="{{ route('users.destroy', $user['id'])}}" method="POST">
                                            <a href="/users/{{$user['id']}}/edit" class="btn btn-info">Editar</a>
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn bg-danger" onclick="confirmDelete({{ $user['id'] }})">Borrar</button>
                                        </form>
                                    </td>

                                    <script>
                                    function confirmDelete(userId) {
                                        if (confirm("¿Está seguro de que desea eliminar esta usuario?")) {
                                            document.getElementById('delete-form-'+userId).submit();
                                        }
                                    }
                                    </script>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    @section('js')
                    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
                    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
                    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>

                    <script>
                        $(document).ready(function () {
                            $('#users').DataTable({
                                "lenghtMenu": [[5,10,20,50,-1],[5,10,20,50,"All"]],
                                "language": {
                                    "emptyTable": "No hay datos disponibles para mostrar",
                                    "zeroRecords": "No se encontraron resultados para su busqueda",
                                    "infoEmpty": "Mostrando 0 usuarios",
                                    "infoFiltered": "(filtrado de un total de _MAX_ usuarios)",
                                    "lengthMenu": "Mostrar _MENU_ usuarios",
                                    "search": "Buscar:",
                                    "info": "Mostrando las usuarios _START_ - _END_ (usuarios totales _MAX_)",
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