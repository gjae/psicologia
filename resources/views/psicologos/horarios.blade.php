@extends('adminlte::page')



@section('content')



@section('css')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">



<link rel="stylesheet" href="https://cdn.datatables.net/1.13.2/css/dataTables.bootstrap4.min.css">

@endsection



<script>

    function horarios(){

        return {

            //horario:'',

            horarios_fin:[],
            horario:{
                inicio:'',
                fin:'',
                diasDeAtencion:[]
            },
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
            buttonDisabled:false,
            registrarDiasDeAtencion(){
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

                fetch(`registrar_dias_atencion/${this.horario.diasDeAtencion}`)

			    .then((data) => {

                    Swal.fire({

                        icon: 'success',
                        title: 'Listo!',
                        html: '<h4>Podrás actualizar ésta información sólo los días Lunes de cada semana</h4>'
                        })
                        location.reload()
                    })
                .catch((data)=> console.log('Error'))

                }

            });
            },
            registrarHorario(){

                this.horario.inicio = this.hora_inicio.hora+':00'+' '+this.hora_inicio.meridiem;
                

                console.log(this.hora_inicio.hora)
                
                if(this.hora_inicio.hora==12){
                        this.horario.fin = '1:00 PM';
                    }

                if(this.hora_inicio.hora>12 || this.hora_inicio.hora<12){
                    
                    if(parseInt(this.hora_inicio.hora)+1==12){
                        this.horario.fin = parseInt(this.hora_inicio.hora)+1+':00 PM';
                    }else{
                        
                    
                    this.horario.fin = parseInt(this.hora_inicio.hora)+1+':00 '+this.hora_inicio.meridiem;
                    }

                    
                }
                /*else if(this.hora_inicio.hora<12){
                    this.horario.fin = parseInt(this.hora_inicio.hora)+1+':00 '+this.hora_inicio.meridiem;
                }*/
                
            /*this.horario.fin = this.hora_fin.hora+':'+this.hora_fin.min+' '+this.hora_fin.meridiem;*/

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
                <form @submit.prevent="registrarHorario">
                    <div>
                        @csrf
                        <h4>Hoy es {{$today->isoFormat('dddd, MMMM Do YYYY')}}</h4>
                        <h3>En que horario prestarás servicio?</h3>
                    
                        <small>Horarios de atención entre 10 de la mañana y 10 de la noche</small>
                        <div class="row">
                            <div class="col-sm-6">
                                <label for="inicio">Inicio</label>

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
                                <!--select name="hora_min_inicio" class="form-control" id="" x-model="hora_inicio.min">
                                    <option value="mins_de_inicio">- Min -</option>
                                    <option value="00">00</option>
                                    <option value="10">10</option>
                                    <option value="20">20</option>
                                    <option value="30">30</option>
                                    <option value="40">40</option>
                                    <option value="50">50</option>
                                </select-->
                                <select name="hora_meridiem_inicio" class="form-control" id="" x-model="hora_inicio.meridiem" >
                                    <option value="meridiem_de_inicio">- Meridiem -</option>
                                    <option value="AM">AM</option>
                                    <option value="PM">PM</option>
                                </select>
                            </div>

                            <!--div class="col-sm-6">
                                <label for="fin">Fin</label>

                                <select name="hora_fin" class="form-control" id="" x-model="hora_fin.hora" value="10">
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
                                <select name="hora_min_fin" class="form-control" id="" x-model="hora_fin.min">
                                    <option value="mins_de_inicio">- Min -</option>
                                    <option value="00">00</option>
                                    <option value="10">10</option>
                                    <option value="20">20</option>
                                    <option value="30">30</option>
                                    <option value="40">40</option>
                                    <option value="50">50</option>
                                </select>
                                <select name="hora_meridiem_fin" class="form-control" id="" x-model="hora_fin.meridiem" >
                                    <option value="meridiem_de_inicio">- Meridiem -</option>
                                    <option value="AM">AM</option>
                                    <option value="PM">PM</option>
                                </select>
                            </div-->
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
                    </div>
                </form>

                <div class="row">

                    <form @submit.prevent="registrarDiasDeAtencion">
                            <div class="container">
                                
                                <h4>Días de atención pautados para ésta semana desde el {{$date}}: {{Auth::user()->IsPsychologist->dias_atencion}}</h4>

                                <h4>Podrás volver a actualizar ésta información el día {{$proxima_actualizacion}}</h4>

                               
                            </div>

                            <div class="container">
                                 @if($today->isMonday())

                                    <div class="row">
                        
                                        <div class="col-sm-2">
                                            
                                            <label for="lunes"> Lunes </label>
                                            <input type="checkbox" x-model="horario.diasDeAtencion" value="lunes">
                                        </div>

                                    
                                        <div class="col-sm-2">
                                            
                                            <label for="martes"> Martes </label>
                                            <input type="checkbox" x-model="horario.diasDeAtencion" value="martes">
                                        </div>

                                
                                        <div class="col-sm-2">
                                            <label for="miercoles"> Miércoles </label>
                                            <input type="checkbox" x-model="horario.diasDeAtencion" value="miercoles">
                                        </div>

                                    
                                        <div class="col-sm-2">
                                            <label for="jueves"> Jueves </label>
                                            <input type="checkbox" x-model="horario.diasDeAtencion" value="jueves">
                                        </div>

                                
                                        <div class="col-sm-2">
                                            <label for="viernes"> Viernes </label>
                                            <input type="checkbox" x-model="horario.diasDeAtencion" value="viernes">
                                        </div>

                                    
                                        <div class="col-sm-2">
                                            <label for="sabado"> Sábado </label>
                                            <input type="checkbox" x-model="horario.diasDeAtencion" value="sábado">
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-12">
                                            
                                            {{-- Register button --}}

                                            <button type="submit" class="btn btn-block {{ config('adminlte.classes_auth_btn', 'btn-flat btn-primary') }}" >

                                                <span class="fas fa-user-plus"></span>

                                                Actualizar días de atención para ésta semana

                                            </button>

                                        </div>
                                    </div>
                                @endif
                            </div>

                    </form>

                    
                </div>
                <div class="bg-horarios">
                    <div class="row">
                            <div class="col-12">
                                <h3>Horario de Atención</h3>
                            </div>
                    
                    </div>
                    @foreach($horario_psicologo as $info)
                        <div class="row">
                            <div class="col-12">
                                </span>{{$info->schedule}}
                            </div>
                            <div class="col-12">
                                </span>{{$info->dias_atencion}}
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

