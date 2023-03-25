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

        <h1>Reservas</h1>

    </div>

    <div class="card-body">

        <table id="example" class="table table-responsive-lg table-striped">

            <thead class="thead-dark">

                <th>Paciente</th>

                <th>Email</th>
                <th>Teléfono</th>

                <th>Fecha de consulta</th>

                <th>Hora de consulta</th>

                <th>Psicólogo</th>

                <th>Motivo de consulta</th>

            </thead>

            @foreach($reservations as $reservation)

            <tbody>

                <td>{{$reservation->patient->name}}</td>

                <td>{{$reservation->patient->email}}</td>
                <td>{{$reservation->patient->phone}}</td>

                <td>{{$reservation->appointment_date}}  </td>

                <td>{{$reservation->schedule->schedule}}</td>

                <td>{{$reservation->schedule->AtThisHourPsyc->personalInfo->name}}</td>

                <td>{{$reservation->cause}}</td>

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

        $('#example').DataTable({

            "language": {

                    "lengthMenu": "Mostrar _MENU_ registros por pag.",

                    "search": "Buscar",

                    "zeroRecords": "No se encontraron registros",

                    "info": "Mostrando pag. _PAGE_ de _PAGES_",

                    "previous": "Anterior",

                    "next": "Siguiente",

                    "infoEmpty": "...",

                    "infoFiltered": "(filtrado de _MAX_ registros)",

                    "oPaginate":{
                        "sPrevious": "Anterior",
                        "sNext": "Siguiente"
                    }

                },

                "search": {

                    "regex": true,

                    "smart": false

                }

        });

    });



    </script>

        

    @endsection

@endsection