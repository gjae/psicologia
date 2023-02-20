@extends('adminlte::page')

@section('content')

@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">

<link rel="stylesheet" href="https://cdn.datatables.net/1.13.2/css/dataTables.bootstrap4.min.css">
@endsection

<style>
    .form-inline{
        display:block ! important;
    }
</style>

<table id="example" class="table table-striped table-bordered">
    <thead>
    <tr>
        <th>Nombre Completo</th>
        <th>Teléfono</th>
        <th>Email</th>
        <th>Edad</th>
        <th>Género</th>
    </tr>
</thead>
@foreach($users as $user)
<tbody>
    <tr>
        <td>{{$user->name}} {{$user->lastname}}</td>
        <td>{{$user->phone}}</td>
        <td>{{$user->email}}</td>
        <td>{{$user->age}}</td>
        <td>{{$user->gender}}</td>
    </tr>
</tbody>
@endforeach

</table>


    @section('js')
    <script src="https://cdn.datatables.net/1.13.2/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.2/js/dataTables.bootstrap.min.js"></script>

    <script>
    $(document).ready(function () {
        $('#example').DataTable();
    });

    </script>
        
    @endsection

@stop