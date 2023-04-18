@extends('adminlte::page')



@section('content')



@section('css')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">



<link rel="stylesheet" href="https://cdn.datatables.net/1.13.2/css/dataTables.bootstrap4.min.css">

@endsection



<script>

    function horarios(){

        return {


            horarios_fin:[],
            dias_atencion_db:'{{Auth::user()->IsPsychologist->dias_atencion}}',
            
            hora_inicio:{
                hora:'',
                min:'',
                meridiem:'',
            },
            hora_fin:{
                hora:'',
                min:'',
                meridiem:''
            },
            horario:{
                inicio:'',
                fin:'',
                diasDeAtencion:[
                    
                    horariosPorDia= {
                        Lunes: {
                            dia:'Lunes',
                            inicio: '',
                            meridiem: '',
                            hora: ''
                        },
                        Martes: {
                            dia:'Martes',
                            inicio: '',
                            meridiem: '',
                            hora: ''
                        },
                        Miércoles: {
                            dia:'Miércoles',
                            inicio: '',
                            meridiem: '',
                            hora: ''
                        },
                        Jueves: {
                            dia:'Jueves',
                            inicio: '',
                            meridiem: '',
                            hora: ''
                        },
                        Viernes: {
                            dia:'Viernes',
                            inicio: '',
                            meridiem: '',
                            hora: ''
                        },
                        Sábado: {
                            dia:'Sábado',
                            inicio: '',
                            meridiem: '',
                            hora: ''
                        },
                    }
                ]
            },
            buttonDisabled:false,
            eliminarhorarios(id){
                Swal.fire({

                    title: 'Está seguro??',

                    icon: 'warning',

                    showCancelButton: true,

                    confirmButtonColor: '#3085d6',

                    cancelButtonColor: '#d33',

                    confirmButtonText: 'Si'

                    })

            .then((opt)=> {
                if (opt.isConfirmed) {

                fetch(`eliminar_horarios/${id}`,

                        {
                            method: 'DELETE',
                                headers: {
                                    'Content-Type': 'application/json',

                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')

                                },

                                body:id

                        })

			    .then(r => r.json())
                .then((data) => {

                        if(data==1){

                            Swal.fire({

                            icon: 'success',

                            title: 'Listo!',

                            })

                            this.buttonDisabled= true;
                            location.reload()
                        }

                        if(data==0){

                            Swal.fire({

                            icon: 'error',

                            title: 'Algo salió mal',

                            text: 'No se puede eliminar porque ya hay una reservación en ese horario'

                            })

                        }

                    })
                .catch((data)=> console.log('Error'))

                }

            });

            },
            registrarHorario(){
            Swal.fire({

                title: 'Está seguro??',

                icon: 'warning',

                showCancelButton: true,

                confirmButtonColor: '#3085d6',

                cancelButtonColor: '#d33',

                confirmButtonText: 'Si'

            })

            .then((opt)=> {

                if (opt.isConfirmed) {
                    console.log(this.horario.fin)

                fetch('{{route("registrar_horarios_post")}}', 

                {

			        method: 'POST',

			        headers: {

				        'Content-Type': 'application/json',

				        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')

			        },

                    body: JSON.stringify(this.horario)

			    }).then(r => r.json())

			    .then((data) => {

                    if(data==1){

                        Swal.fire({

                        icon: 'success',

                        title: 'Listo!',

                        })

                        this.buttonDisabled= true;
                        location.reload()
                    }

                    if(data==0){

                        Swal.fire({

                        icon: 'error',

                        title: 'Algo salió mal',

                        text: 'Asegurate de haber colocado un horario'

                        })

                    }

                        

                })

                .catch((data)=> console.log('Error'))

                }

            });

            }

        }

    }

</script>

<body>

<div class="row" x-data="horarios()">

    <div class="container">

        <div class="card">

            <div class="card-header">

                <h2>Registrar horarios</h2>

            </div>

            <div class="card-body">

                <div class="container">
                    <h4 class="my-4">Seleccione todas las horas en las que desea prestar atención cada día</h4>
                    <form @submit.prevent="registrarHorario">
                        

                        <div>
                            <div class="row justify-content-center align-items-center m-0 p-0 eliminar-margen-indeseado text-center">
                                <div class="col-10 col-lg-2">
                                    <label for="lunes"> Lunes </label>
                                </div>
                                <div class="col-10 col-lg-4">
                                    <select name="hora_inicio" class="form-control" id="" x-model="horariosPorDia.Lunes.inicio">
                                        <option value="hora_de_inicio">- Hora -</option>
                                        <option value="10">10</option>
                                        <option value="11">11</option>
                                        <option value="12">12</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                        <option value="6">6</option>
                                        <option value="7">7</option>
                                        <option value="8">8</option>
                                        <option value="9">9</option>
                                    </select>
                                </div>

                                <div class="col-10 col-lg-4">
                                    <select name="hora_meridiem_inicio" class="form-control" id="" x-model="horariosPorDia.Lunes.meridiem">
                                        <option value="meridiem_de_inicio">- AM - PM -</option>
                                        <option value="AM">AM</option>
                                        <option value="PM">PM</option>
                                    </select>
                                </div>
                            </div>

                        
                            <div class="row justify-content-center align-items-center m-0 p-0 eliminar-margen-indeseado text-center">
                                
                                <div class="col-10 col-lg-2">
                                    <label for="martes"> Martes </label>
                                </div>
                                                               
                                <div class="col-10 col-lg-4">
                                    <select name="hora_inicio" class="form-control" id="" x-model="horariosPorDia.Martes.inicio">
                                        <option value="hora_de_inicio">- Hora -</option>
                                        <option value="10">10</option>
                                        <option value="11">11</option>
                                        <option value="12">12</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                        <option value="6">6</option>
                                        <option value="7">7</option>
                                        <option value="8">8</option>
                                        <option value="9">9</option>
                                    </select>
                                </div>

                                <div class="col-10 col-lg-4">
                                    <select name="hora_meridiem_inicio" class="form-control" id="" x-model="horariosPorDia.Martes.meridiem">
                                        <option value="meridiem_de_inicio">- AM - PM -</option>
                                        <option value="AM">AM</option>
                                        <option value="PM">PM</option>
                                    </select>
                                </div>

                            </div>

                    
                            <div class="row justify-content-center align-items-center m-0 p-0 eliminar-margen-indeseado text-center">
                                <div class="col-10 col-lg-2">
                                    <label for="miercoles"> Miércoles </label>
                                </div>
                                
                                
                                <div class="col-10 col-lg-4">

                                    <select name="hora_inicio" class="form-control" x-model="horariosPorDia.Miércoles.inicio" id=""  >
                                        <option value="hora_de_inicio">- Hora -</option>
                                        <option value="10">10</option>
                                        <option value="11">11</option>
                                        <option value="12">12</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                        <option value="6">6</option>
                                        <option value="7">7</option>
                                        <option value="8">8</option>
                                        <option value="9">9</option>
                                    </select>
                                </div>

                                <div class="col-10 col-lg-4">
                                    <select name="hora_meridiem_inicio" class="form-control" x-model="horariosPorDia.Miércoles.meridiem" id="" >
                                        <option value="meridiem_de_inicio">- AM - PM -</option>
                                        <option value="AM">AM</option>
                                        <option value="PM">PM</option>
                                    </select>
                                </div>
                            </div>

                        
                            <div class="row justify-content-center align-items-center m-0 p-0 eliminar-margen-indeseado text-center">
                                <div class="col-10 col-lg-2">
                                    <label for="jueves"> Jueves </label>
                                </div>                                                         
                                <div class="col-10 col-lg-4">
                                    <select name="hora_inicio" class="form-control" x-model="horariosPorDia.Jueves.inicio" id="" >
                                        <option value="hora_de_inicio">- Hora -</option>
                                        <option value="10">10</option>
                                        <option value="11">11</option>
                                        <option value="12">12</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                        <option value="6">6</option>
                                        <option value="7">7</option>
                                        <option value="8">8</option>
                                        <option value="9">9</option>
                                    </select>
                                </div>

                                <div class="col-10 col-lg-4">
                                    <select name="hora_meridiem_inicio" class="form-control" x-model="horariosPorDia.Jueves.meridiem" id="" >
                                        <option value="meridiem_de_inicio">- AM - PM -</option>
                                        <option value="AM">AM</option>
                                        <option value="PM">PM</option>
                                    </select>
                                </div>
                            </div>

                    
                            <div class="row justify-content-center align-items-center m-0 p-0 eliminar-margen-indeseado text-center">
                                <div class="col-10 col-lg-2">
                                    <label for="viernes"> Viernes </label>
                                </div>                                                            
                                <div class="col-10 col-lg-4">
                                    <select name="hora_inicio" class="form-control" x-model="horariosPorDia.Viernes.inicio" id="" >
                                        <option value="hora_de_inicio">- Hora -</option>
                                        <option value="10">10</option>
                                        <option value="11">11</option>
                                        <option value="12">12</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                        <option value="6">6</option>
                                        <option value="7">7</option>
                                        <option value="8">8</option>
                                        <option value="9">9</option>
                                    </select>
                                </div>

                                <div class="col-10 col-lg-4">
                                    <select name="hora_meridiem_inicio" class="form-control" x-model="horariosPorDia.Viernes.meridiem" id="" >
                                        <option value="meridiem_de_inicio">- AM - PM -</option>
                                        <option value="AM">AM</option>
                                        <option value="PM">PM</option>
                                    </select>
                                </div>
                            </div>

                        
                            <div class="row justify-content-center align-items-center m-0 p-0 eliminar-margen-indeseado text-center">
                                <div class="col-10 col-lg-2">
                                    <label for="sabado"> Sábado </label>
                                </div>                                                         
                                <div class="col-10 col-lg-4">

                                    <select name="hora_inicio" class="form-control" x-model="horariosPorDia.Sábado.inicio" id="" >
                                        <option value="hora_de_inicio">- Hora -</option>
                                        <option value="10">10</option>
                                        <option value="11">11</option>
                                        <option value="12">12</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                        <option value="6">6</option>
                                        <option value="7">7</option>
                                        <option value="8">8</option>
                                        <option value="9">9</option>
                                    </select>
                                </div>

                                <div class="col-10 col-lg-4">
                                    <select name="hora_meridiem_inicio" class="form-control" x-model="horariosPorDia.Sábado.meridiem" id="">
                                        <option value="meridiem_de_inicio">- AM - PM -</option>
                                        <option value="AM">AM</option>
                                        <option value="PM">PM</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row justify-content-center">
                            <div class="col-12 col-lg-10">
                                
                                {{-- Register button --}}

                                <button type="submit" class="btn btn-block {{ config('adminlte.classes_auth_btn', 'btn-flat btn-primary') }}" >
                                    <h5 class="texto-boton-editado py-2">
                                        <span class="fas fa-calendar"></span>

                                        Actualizar días y horarios de atención
                                    </h5>
                                    

                                </button>

                            </div>
                        </div>
                    </form>
                </div>
                
                <div class="bg-horarios">
                    <div class="row">
                            <div class="col">
                                <h3>HORARIO DE ATENCIÓN</h3>
                            </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            @foreach($horario_psicologo as $info)
                                <div class="row justify-content-center mt-3">
                                    <div class="col-5 col-md-3">
                                        </span>{{$info->dia}}
                                    </div>
                                    <div class="col-5 col-md-3">
                                        </span>{{$info->schedule}}
                                    </div>
                                    
                                    <div class="col-5 col-md-3">
                                        <button class="btn btn-danger mb-3" x-on:click="eliminarhorarios({{$info->id}})"> ELIMINAR</button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>

    </div>

</div>

<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</body>

@endsection

