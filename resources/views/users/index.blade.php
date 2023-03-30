@extends('adminlte::page')

@section('css')

<link rel="stylesheet" href="https://cdn.datatables.net/1.13.3/css/dataTables.bootstrap.min.css">

  
<script>
    function usuarios(){
        return {
            eliminarusuarios(id){
                Swal.fire({

                    title: 'Está seguro de eliminar a éste usuario y las reservas que ha hecho?',
                    icon: 'warning',
                    cancelButtonText: "No",

                    confirmButtonColor: '#3085d6',
                    showCancelButton: true,
                    confirmButtonText: 'Si',
                    

                }).then((opt)=>{
                    if (opt.isConfirmed){
                            fetch(`usuarios/${id}`,

                        {
                            method: 'DELETE',
                                headers: {

                                    'Content-Type': 'application/json',

                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                                    

                                },

                                body:id

                        }).then((data) => {

                            Swal.fire({

                            icon: 'success',

                            title: 'Listo!!',

                            })
                            
                           // location.reload()

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

            Usuarios registrados

        </h1>

    </div>

    <div class="card-body" x-data="usuarios()">

        <table id="example" class="table table-responsive-lg  table-striped table-bordered">

            <thead class="thead-dark">

                <tr>

                    <th>Nombre Completo</th>

                    <th>Teléfono</th>

                    <th>Email</th>

                    <th>Edad</th>

                    <th>Género</th>

                    <th>Rol</th>
                    
                    <th>Eliminar</th>
                </tr>

            </thead>

            @foreach($users as $user)
                @if(!$user->hasRole('administrador'))
                <tr>

                    <td>{{$user->name}} {{$user->lastname}}</td>

                    <td>

                    @if($user->hasRole('paciente')) 

                            {{$user->phone}} 

                        @elseif($user->hasRole('psicologo')) 

                            {{$user->IsPsychologist->personal_phone}}

                        @elseif($user->hasRole('administrador')) 

                            Administrador 

                    @endif

                        </td>

                    <td>{{$user->email}}</td>

                    <td>{{$user->age}}</td>

                    <td>{{$user->gender}}</td>

                    

                    <td> @if($user->hasRole('paciente')) 

                            Paciente 

                        @elseif($user->hasRole('psicologo')) 

                            Psicologo 

                        @elseif($user->hasRole('administrador')) 

                            Administrador 

                        @endif</td>

                        <td><button class="btn btn-danger" x-on:click="eliminarusuarios({{$user->id}})">
                       Eliminar</button></td>

                </tr>
                
                @endif
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

                    "Previous": "Anterior",

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















