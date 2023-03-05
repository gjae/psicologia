@extends('adminlte::page')
@section('content')
@section('css')
<style>
    .form-inline{
        display:block ! important;
    }
    table{
        width:100%;
        table-layout:fixed;
    }
</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.2/css/dataTables.bootstrap4.min.css">
@endsection
 



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
            <tbody>
                <tr>
                    <td data-filter="nombre">{{$user->name}} {{$user->lastname}}</td>
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
            </tbody>
            @endforeach
        </table>
    </div>
</div>

    @section('js')
    <script src="https://cdn.datatables.net/1.13.2/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.2/js/dataTables.bootstrap.min.js"></script>

    <script>
    $(document).ready(function () {
        $('#example').DataTable();
    });

    </script>
        
    @endsection
@endsection
