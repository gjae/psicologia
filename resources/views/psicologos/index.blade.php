@extends('adminlte::page')

@section('css')

<link rel="stylesheet" href="https://cdn.datatables.net/1.13.3/css/dataTables.bootstrap.min.css">

  
<script>
    function psicologos(){
        return {
            eliminarpsicologos(id){
                Swal.fire({

                    title: 'Está seguro de eliminar a éste psicólogo y las reservas que han hecho con él?',
                    icon: 'warning',
                    cancelButtonText: "No",

                    confirmButtonColor: '#3085d6',
                    showCancelButton: true,
                    confirmButtonText: 'Si'

                }).then((opt)=>{
                    if (opt.isConfirmed){
                            fetch(`psicologos/${id}`,

                        {
                            method: 'DELETE',
                                headers: {

                                    'Content-Type': 'application/json',

                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')

                                },

                                body:id

                        }).then((data) => {

                            Swal.fire({

                            icon: 'success',

                            title: 'Listo!!',

                            })
                            
                            location.reload()

                        }).catch()

                    
                    }
                })
            }
        }
    }
</script>

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

            Psicologos registrados

        </h1>

    </div>

    <div class="card-body" x-data="psicologos()">

        <table id="example" class="table table-responsive  table-striped table-bordered">

            <thead class="thead-dark">

                <tr>

                <th></th>

                <th>Nombre Completo</th>

                <th>Email</th>

                <th>Edad</th>

                <th>Género</th>

                <th>Especialidad</th>

                <th>BIO</th>

                <th>Tipo de terapia que maneja</th>

                <th>Teléfono personal</th>

                <th>Teléfono de empresa</th>
                
                <th>Eliminar</th>

            </tr>

            </thead>

            @foreach($psicologos as $psicologo)

                <tr>

                    <td><img src="{{ asset($psicologo->photo) }}" class="img-circle" alt="" height="52" width="52"></td>

                    <td>{{$psicologo->personalInfo->name}} {{$psicologo->personalInfo->lastname}}</td>

                    <td>{{$psicologo->personalInfo->email}}</td>

                    <td>{{$psicologo->personalInfo->age}}</td>

                    <td>{{$psicologo->personalInfo->gender}}</td>

                    <td>{{$psicologo->specialty}}</td>

                    <td>{{$psicologo->bio}}</td>

                    <td>{{$psicologo->therapy->therapy_type}}</td>

                    <td>{{$psicologo->personal_phone}}</td>

                    <td>{{$psicologo->bussiness_phone}}</td>

                    <td><button class="btn btn-danger" x-on:click="eliminarpsicologos({{$psicologo->personalInfo->id}})">
                       Eliminar</button></td>
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

                    "zeroRecords": "No se encontraron registros",

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



        
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @endsection



    

@endsection















