@extends('adminlte::page')

@section('css')

<link rel="stylesheet" href="https://cdn.datatables.net/1.13.3/css/dataTables.bootstrap.min.css">

  
<script>
    function psicologos(){
        return {
            info_psicologo(psicologo){
                fetch(`psicologos/${psicologo}`)
                        .then(r => r.json())
                        .then((data) => {
                            
                        }

                        ).catch()
            },
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


                <th>BIO</th>

                <th>Tipo de terapia que maneja</th>

                <th>Teléfono personal</th>

                <th>Teléfono de empresa</th>
                
                <th>Eliminar</th>

            </tr>

            </thead>

            @foreach($psicologos as $psicologo)

                <tr>

                    <td>
                        <a href="{{route('psicologos.show', $psicologo->id)}}">
                            <img src="{{ asset($psicologo->photo) }}" class="img-circle" alt="" height="52" width="52">
                        </a>
                    </td>

                    <td>{{$psicologo->personalInfo->name}} {{$psicologo->personalInfo->lastname}}</td>

                    <td>{{$psicologo->personalInfo->email}}</td>

                    <td>{{$psicologo->personalInfo->age}}</td>

                    <td>{{$psicologo->personalInfo->gender}}</td>

                    <td>{{$psicologo->bio}}</td>

                    <td>
                        <ul>
                            @foreach($psicologo->therapiesOffered as $tipo_therapy)
                                <li><p>{{$tipo_therapy->therapy->therapy_type}}</p></li>

                                
                                @foreach($tipo_therapy->ProblemsTreated as $problem)
                                   <p><span class="breadcrumb" style="background:info;"> {{ App\Models\Problems::find($problem->id_problem)->problem}}</span></p>
                                @endforeach
                                
                            @endforeach    
                        </ul>
                    </td>

                    <td>{{$psicologo->personal_phone}}</td>

                    <td>{{$psicologo->bussiness_phone}}</td>

                    <td><button class="btn btn-danger" x-on:click="eliminarpsicologos({{$psicologo->personalInfo->id}})">
                       Eliminar</button></td>
                </tr>

            @endforeach

        </table>


        <template id="my-template">

            <swal-title>

            </swal-title>

            <swal-html> 

                <h4>Está de acuerdo?</h4>

                <p>4 sesiones x S/ 360</p>

                <p>6 sesionesx S/ 450</p>

                <p>8 sesionesx S/ 650</p>

                <p>12 sesionesx S/ 700</p>

            </swal-html>

            <swal-icon type="warning" color="red"></swal-icon>

                <swal-button type="confirm">

                    Si

                </swal-button>

                <swal-button type="cancel">

                    No

                </swal-button>

            <swal-param name="allowEscapeKey" value="false" />

            <swal-param

            name="customClass"

            value='{ "popup": "my-popup" }' />

            <swal-function-param

            name="didOpen"

            value="popup => console.log(popup)" />

        </template>
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



        </script>



        
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @endsection



    

@endsection















