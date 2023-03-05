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

<div class="card">
    <div class="card-header">
        <h1>Psicólogos registrados</h1>
    </div>
    <div class="card-body">
        <table id="example" class="table table-responsive table-striped table-bordered">
            <thead class="thead-dark">
            <tr>
                <th></th>
                <th>Nombre Completo</th>
                <th>Teléfono</th>
                <th>Email</th>
                <th>Edad</th>
                <th>Género</th>
                <th>Especialidad</th>
                <th>Tipo de terapia que maneja</th>
                <th>Descripción</th>
                <th>Teléfono personal</th>
                <th>Teléfono de empresa</th>
            </tr>
            </thead>
            @foreach($psicologos as $psicologo)
            <tbody>
                <tr>
                    <td><img src="{{ asset($psicologo->photo) }}" class="img-circle" alt="" height="52" width="52"></td>
                    <td>{{$psicologo->personalInfo->name}} {{$psicologo->personalInfo->lastname}}</td>
                    <td>{{$psicologo->personalInfo->phone}}</td>
                    <td>{{$psicologo->personalInfo->email}}</td>
                    <td>{{$psicologo->personalInfo->age}}</td>
                    <td>{{$psicologo->personalInfo->gender}}</td>
                    <td>{{$psicologo->specialty}}</td>
                    <td>{{$psicologo->therapy->therapy_type}}</td>
                    <td>{{$psicologo->therapy->description}}</td>
                    <td>{{$psicologo->personal_phone}}</td>
                    <td>{{$psicologo->bussiness_phone}}</td>
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

@stop
