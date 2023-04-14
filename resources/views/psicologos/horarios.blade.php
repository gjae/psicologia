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
                    <h5>Seleccione todas las horas en las que desea prestar atención cada día</h5>
                    <form @submit.prevent="registrarHorario">
                        

                        <div>
                            <div class="row m-3">
                                <div class="col-2">
                                    <label for="lunes"> Lunes </label>
                                </div>
                                <div class="col-3">
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

                                <div class="col-3">
                                    <select name="hora_meridiem_inicio" class="form-control" id="" x-model="horariosPorDia.Lunes.meridiem">
                                        <option value="meridiem_de_inicio">- AM - PM -</option>
                                        <option value="AM">AM</option>
                                        <option value="PM">PM</option>
                                    </select>
                                </div>
                            </div>

                        
                            <div class="row m-3">
                                
                                <div class="col-2">
                                    <label for="martes"> Martes </label>
                                </div>
                                                               
                                <div class="col-3">
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

                                <div class="col-3">
                                    <select name="hora_meridiem_inicio" class="form-control" id="" x-model="horariosPorDia.Martes.meridiem">
                                        <option value="meridiem_de_inicio">- AM - PM -</option>
                                        <option value="AM">AM</option>
                                        <option value="PM">PM</option>
                                    </select>
                                </div>
                                <select name="hora_inicio" class="form-control" id="" x-model="hora_inicio.hora">
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
                                <select name="hora_meridiem_inicio" class="form-control" id="" x-model="hora_inicio.meridiem" >
                                    <option value="meridiem_de_inicio">- AM - PM -</option>
                                    <option value="AM">AM</option>
                                    <option value="PM">PM</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">

                            {{-- Register button --}}

                            <button type="submit" class="btn btn-block {{ config('adminlte.classes_auth_btn', 'btn-flat btn-primary') }}" :disabled="buttonDisabled" >

                                <span class="fas fa-user-plus"></span>

                                Agregar horario

                            </button>

                            </div>

                    
                            <div class="row m-3">
                                <div class="col-2">
                                    <label for="miercoles"> Miércoles </label>
                                </div>
                                
                                
                                <div class="col-3">

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

                                <div class="col-3">
                                    <select name="hora_meridiem_inicio" class="form-control" x-model="horariosPorDia.Miércoles.meridiem" id="" >
                                        <option value="meridiem_de_inicio">- AM - PM -</option>
                                        <option value="AM">AM</option>
                                        <option value="PM">PM</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="container">
                    <div class="row">

                        <form @submit.prevent="registrarDiasDeAtencion">
                        <div>
                            
                            <h4>Días de atención pautados para ésta semana desde el {{$date}}: {{Auth::user()->IsPsychologist->dias_atencion}}</h4>
                        </div>

                        
                            <div class="row m-3">
                                <div class="col-2">
                                    <label for="jueves"> Jueves </label>
                                </div>                                                         
                                <div class="col-3">
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

                                <div class="col-3">
                                    <select name="hora_meridiem_inicio" class="form-control" x-model="horariosPorDia.Jueves.meridiem" id="" >
                                        <option value="meridiem_de_inicio">- AM - PM -</option>
                                        <option value="AM">AM</option>
                                        <option value="PM">PM</option>
                                    </select>
                                </div>
                            </div>
                            <h4>Podrás volver a actualizar ésta información el día {{$proxima_actualizacion}}</h4>

                            
                            @if($today->isMonday())

                                <div class="row">
                    
                                    <div class="col-sm-2">
                                        
                                        <label for="lunes"> Lunes </label>
                                        <input type="checkbox" x-model="horario.diasDeAtencion" value="lunes">
                                    </div>

                    
                            <div class="row m-3">
                                <div class="col-2">
                                    <label for="viernes"> Viernes </label>
                                </div>                                                            
                                <div class="col-3">
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
                                
                                    <div class="col-sm-2">
                                        
                                        <label for="martes"> Martes </label>
                                        <input type="checkbox" x-model="horario.diasDeAtencion" value="martes">
                                    </div>

                                <div class="col-3">
                                    <select name="hora_meridiem_inicio" class="form-control" x-model="horariosPorDia.Viernes.meridiem" id="" >
                                        <option value="meridiem_de_inicio">- AM - PM -</option>
                                        <option value="AM">AM</option>
                                        <option value="PM">PM</option>
                                    </select>
                                </div>
                            </div>
                            
                                    <div class="col-sm-2">
                                        <label for="miercoles"> Miércoles </label>
                                        <input type="checkbox" x-model="horario.diasDeAtencion" value="miercoles">
                                    </div>

                        
                            <div class="row m-3">
                                <div class="col-2">
                                    <label for="sabado"> Sábado </label>
                                </div>                                                         
                                <div class="col-3">

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
                                
                                    <div class="col-sm-2">
                                        <label for="jueves"> Jueves </label>
                                        <input type="checkbox" x-model="horario.diasDeAtencion" value="jueves">
                                    </div>

                            
                                    <div class="col-sm-2">
                                        <label for="viernes"> Viernes </label>
                                        <input type="checkbox" x-model="horario.diasDeAtencion" value="viernes">
                                    </div>

                                <div class="col-3">
                                    <select name="hora_meridiem_inicio" class="form-control" x-model="horariosPorDia.Sábado.meridiem" id="">
                                        <option value="meridiem_de_inicio">- AM - PM -</option>
                                        <option value="AM">AM</option>
                                        <option value="PM">PM</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                                
                                    <div class="col-sm-2">
                                        <label for="sabado"> Sábado </label>
                                        <input type="checkbox" x-model="horario.diasDeAtencion" value="sábado">
                                    </div>
                                </div>

                        <div class="row">
                            <div class="col-12">
                                
                                {{-- Register button --}}
                                <div class="row">
                                    <div class="col-12">
                                        
                                        {{-- Register button --}}

                                <button type="submit" class="btn btn-block {{ config('adminlte.classes_auth_btn', 'btn-flat btn-primary') }}" >
                                        <button type="submit" class="btn btn-block {{ config('adminlte.classes_auth_btn', 'btn-flat btn-primary') }}" >

                                    <span class="fas fa-calendar"></span>
                                            <span class="fas fa-user-plus"></span>

                                    Actualizar días y horarios de atención
                                            Actualizar días de atención para ésta semana

                                </button>
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
                                </div>
                            @endif
                        </div>
                        </form>
                    </div>

                </div>
               <div class="bg-horarios">
                    <div class="container">
                            <div class="row">
                                <div class="col-12">
                                    <h3>Horario de Atención</h3>
                                </div>
                            </div>
                    </div>
                    @foreach($horario_psicologo as $info)
                        <div class="row">
                            <div class="col-sm-5">
                                {{$info->schedule}}
                            </div>
                            <div class="col-sm-5">
                                {{$info->dias_atencion}}
                            </div>
                        </div>
                    @endforeach

               </div>
               
              
              
            </div>
        </div>

    </div>

</div>

<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</body>

@endsection

