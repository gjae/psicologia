@extends('adminlte::page')
@section('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.3/css/dataTables.bootstrap.min.css">
  
<style>
    .form-inline{
        display:block ! important;
    }
</style>
@endsection
@section('content')
    <div class="card">
    <div class="card-header">
        <h1>
            Usuarios registrados
        </h1>
    </div>
    <div class="card-body">
        <table id="example" class="table table-responsive-lg  table-striped table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>Nombre Completo</th>
                    <th>Teléfono</th>
                    <th>Email</th>
                    <th>Edad</th>
                    <th>Género</th>
                    <th>Rol</th>
                </tr>
            </thead>
            @foreach($users as $user)
                <tr>
                    <td>{{$user->name}} {{$user->lastname}}</td>
                    <td>{{$user->phone}}</td>
                    <td>{{$user->email}}</td>
                    <td>{{$user->age}}</td>
                    <td>{{$user->gender}}</td>
                    
                    <td> @if($user->role == 1) 
                            Paciente 
                        @elseif($user->role == 3) 
                            Psicologo 
                        @elseif($user->role == 2) 
                            Administrador 
                        @endif</td>
                </tr>
            @endforeach
        </table>
    </div>
</div>

    @section('js')
        <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
        <script src="https://cdn.datatables.net/1.13.3/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.3/js/dataTables.bootstrap.min.js"></script>

        <script>
            $('#example').DataTable({
                "language": {
                    "lengthMenu": "Mostrar _MENU_ registros por pag.",
                    "search": "Buscar",
                    "zeroRecords": "No encontrado",
                    "info": "Mostrando pag. _PAGE_ de _PAGES_",
                    "previous": "Anterior",
                    "next": "Siguiente",
                    "infoEmpty": "...",
                    "infoFiltered": "(filtrado de _MAX_ registros)"
                },
                "search": {
                    "regex": true,
                    "smart": false
                }
            });

        </script>

        
    @endsection

    
@endsection







