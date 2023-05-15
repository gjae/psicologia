@extends('adminlte::page')



@section('content')



@section('css')

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">



    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.2/css/dataTables.bootstrap4.min.css">

@endsection



<script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>



<style>

    .form-inline{

        display:block ! important;

    }

</style>





<body>

    <div class="card" x-data="ranking()">
        
            <div class="card-header">

                <h1>Evaluar psicólogos</h1>

            </div>

            <div class="card-body">

                <table id="example" class="table table-responsive table-striped table-bordered">

                    <thead class="thead-dark">

                    <tr>

                        <th>Evaluar</th>

                        <th></th>

                        <th>Puntuación</th>

                        <th>Nombre Completo</th>

                        <th>Email</th>

                        <th>Edad</th>

                        <th>Género</th>


                        <th>BIO</th>

                        <th>Tipo de terapia que maneja</th>

                        <th>Teléfono personal</th>

                        <th>Teléfono de empresa</th>

                    </tr>

                    </thead>

                    @foreach($psicologos as $psicologo)

                    <tbody>

                        <tr>

                            <td> 

                                <button class="btn btn-warning" x-on:click="suma({{$psicologo->id}})"> 

                                    <i class="fa fa-arrow-up" aria-hidden="true" title="Suma dos puntos al rating del psicólogo" ></i>

                                </button>

                            

                            <button class="btn btn-danger" title="Resta un punto al rating del psicólogo" @click="resta({{$psicologo->id}})"> <i class="fa fa-arrow-down" aria-hidden="true"></i></button>



                            </td>

                            <td><img src="{{ asset($psicologo->photo) }}" class="img-circle" alt="" height="52" width="52"></td>

                            <td>{{$psicologo->ranking}}</td>

                            <td>{{$psicologo->personalInfo->name}} {{$psicologo->personalInfo->lastname}}</td>

                            <td>{{$psicologo->personalInfo->email}}</td>

                            <td>{{$psicologo->personalInfo->age}}</td>

                            <td>{{$psicologo->personalInfo->gender}}</td>

                            <td>{{$psicologo->bio}}</td>

                            <td>
                                <ul>
                                    @foreach($psicologo->therapiesOffered as $tipo_therapy)
                                        <li><p>{{$tipo_therapy->therapy->therapy_type}}</p></li>
                                        
                                    @endforeach    
                                </ul>
                            </td>

                            <td>{{$psicologo->personal_phone}}</td>

                            <td>{{$psicologo->bussiness_phone}}</td>

                            

                        </tr>

                    </tbody>

                    @endforeach

                </table>

            </div>

       

    </div>

</body>





    @section('js')

    <script src="https://cdn.datatables.net/1.13.2/js/jquery.dataTables.min.js"></script>

    <script src="https://cdn.datatables.net/1.13.2/js/dataTables.bootstrap.min.js"></script>



    

    <script>

    function ranking(){

        return {

            suma(id){

                var datos= {

                    id: id,

                    opcion: 1

                }

                Swal.fire({

                    title: 'Está seguro?',

                    text: "Quieres sumar 2 puntos a  éste psicólogo?",

                    icon: 'warning',

                    showCancelButton: true,

                    confirmButtonColor: '#3085d6',

                    cancelButtonColor: '#d33',

                    confirmButtonText: 'Si'

                })

                .then((opt)=>{

                    if (opt.isConfirmed) {

                        fetch(`evaluar/${id}`,

                        {

                            method: 'POST',

                                headers: {

                                    'Content-Type': 'application/json',

                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')

                                },

                                body:JSON.stringify(datos)

                        }).

                        then((data) => {

                            Swal.fire({

                            icon: 'success',

                            title: 'Listo!!',

                            })

                            location.reload()

                        }

                        ).catch()

                    }

                })

            },



            resta(id){

                var datos= {

                    id: id,

                    opcion: 0

                }

                Swal.fire({

                    title: 'Está seguro?',

                    text: "Quieres restar 1 punto a  éste psicólogo?",

                    icon: 'warning',

                    showCancelButton: true,

                    confirmButtonColor: '#3085d6',

                    cancelButtonColor: '#d33',

                    confirmButtonText: 'Si'

                })

                .then((opt)=>{

                    if (opt.isConfirmed) {

                        fetch(`evaluar/${id}`,

                        {

                            method: 'POST',

                                headers: {

                                    'Content-Type': 'application/json',

                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')

                                },

                                body:JSON.stringify(datos)

                        }).

                        then((data) => {

                            Swal.fire({

                            icon: 'success',

                            title: 'Listo!',

                            })

                            location.reload()

                        }

                        ).catch()

                    }

                })

            }

        }

    }

</script>





<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @endsection

@stop

