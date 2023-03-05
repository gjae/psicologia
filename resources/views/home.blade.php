@extends('adminlte::page')
@section('content')

<style>
    .icon{
        font-size:60px;
    }
    .nav li{
        padding:10px;
    }
    .hidden{
        display:none;
    }
    .hover-img:hover{
        opacity: 0.5;
    }
    .callout {
        border-color:red;
    }
    a{
        color:#3c3c3c;
        text-decoration:none;
    }
    .active a{
        color:#000 !important;
    }
    .active{
        border-radius:5px 5px 0px 0px;
        font-weight: bold;
        
    }

    @media screen and (max-width: 600px) {
       table {
           width:100%;
       }
       th,tr:nth-of-type(2n) {
           background-color: inherit;
       }
       th,tr td:first-child {
           background: #f0f0f0;
           font-weight:bold;
           font-size:1.3em;
       }
       tbody td {
           display: block;
           text-align:center;
       }
       tbody td:before {
           content: attr(data-th);
           display: block;
           text-align:center;
       }
       
       thead th {
           display: block;
           text-align:center;
       }
       thead th:before {
           content: attr(data-th);
           display: block;
           text-align:center;
       }
}

</style>
<script>
    function cita(){
        return {
            reserved_pane:false,
            message:false,
            activeTab: 'tab1',
            open_problem_link:false,
            open_consejos_link:false,
            open_reservas_link:false,
            open_resumen_link:false,
            mis_reservaciones: [],

            hay_psicologos:false,
            resumen:false,
            disableButton:false,
            id_especialista:'',
            problemas_bag:[],
            problem:false,
            primera_vez:true,
            tipo_terapia_pane:true,
            tipo_problema_pane:false,

            tipo_problema_id:'',
            horario: '',           //Id de horario

            tipo_terapia_id:'',
            consejos_pane:false,
            resume_pane:false,
            motivo_consulta:'',
            reservas_pane:false,
            whatsapp:false,
            whatsapp_helpgroup:false,
            schedule:'',
            horarios: [],
            nuevoarrayhoras:[],
            formData:{
                id_user:'{{auth()->user()->id}}',
                appointment_date:'',
                schedule:'',
                cause: '',
                especialista:'',
            },
            message:'',
            get horario_de_consulta_prop(){
                const nuevoarrayhoras= this.horarios;
                for(let i= 0; i<nuevoarrayhoras.length;i++){
                    if(nuevoarrayhoras[i].id== this.horario){
                        return nuevoarrayhoras[i].schedule;
                    }
                }
                
            },
            reserva_gratuita(param){
                fetch(`reserva_gratuita/${param}`).
                then(r => r.json()).
                then((data) => {
					console.log(data)
                        if(data==0){
                                this.reserved_pane=false,
                                this.primera_vez=true,
                                this.message=false
                            }
                        if(data==1){

                            this.reserved_pane=true,
                            this.primera_vez=false,
                            this.message=true,
                            fetch(`mis_reservaciones/{{auth()->user()->id}}`).
                            then(r => r.json()).
                            then((data) => {
                                this.mis_reservaciones= data;
                                console.log(this.mis_reservaciones)
                            }).catch()
                        }
                    }
                    ).catch()
                
            },
            ReservaForm(){
                this.formData.schedule= this.horario
                this.formData.cause= this.motivo_consulta
                Swal.fire({
                    template: '#my-template',
                cancelButtonText: "No",
                showCancelButton: true,
            })
            .then((opt)=> {
                if (opt.isConfirmed) {
                fetch('{{route("reservas.store")}}', 
                {
			        method: 'POST',
			        headers: {
				        'Content-Type': 'application/json',
				        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
			        },
			        body: JSON.stringify(this.formData)
			    }).then(r => r.json())
			    .then((data) => {
                    console.log(data)
                    if(data==1){
                        Swal.fire({
                        title: 'El horario ya está reservado ',
                        text: "Ya existe una reserva con ese especialista a la hora que usted seleccionó. Porfavor seleccione un horario diferente o una fecha diferente.",
                        icon: 'warning',
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'Ok'
                        }).then((result) => {
                        if (result.isConfirmed) {
                            location.reload()
                        }
                        })
                    }
                    if(data==0){
                        Swal.fire({
                        icon: 'success',
                        title: 'Listo! La reserva de su sesión gratuita ha sido creada con éxito',
                        })
                        
                        this.disableButton=true
                        this.open_resumen_link= true
                    }
                })
                .catch((data)=> console.log('Error'),
                
                    Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Algo salió mal',
                    footer: 'Asegurate de que completaste todo el formulario.'
                    })
                )
                }
            });
            },
            psicologos(param){
                fetch(`horarios_psicologos/${param}`)
                .then(r => r.json())
                .then((data) => {
					this.horarios= data
				})
                .catch()
            },
            problema(){
                this.tipo_terapia_pane= false
                this.consejos_pane= false
                this.tipo_reservas_pane= false
                this.tipo_problema_pane=true
                this.whatsapp=false
                this.whatsapp_helpgroup=false
                fetch(`consulta_problemas/${this.tipo_terapia_id}`,
                {
                    method: 'POST',
						headers: {
							'Content-Type': 'application/json',
							'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
						},
						body: JSON.stringify(this.tipo_terapia_id)
                }).then(r => r.json()).then(
                    (data) => {
                        this.problemas_bag= data
                    }
                ).catch()
            },
            consejos(){
                this.tipo_terapia_pane= false
                this.consejos_pane= true
                this.tipo_reservas_pane= false
                this.tipo_problema_pane=false
                
                this.whatsapp=false
                this.whatsapp_helpgroup=false
            },
            sugerencia(){
                this.tipo_terapia_pane= false
                this.consejos_pane= false
                this.tipo_problema_pane=false
                this.whatsapp=false
                this.whatsapp_helpgroup=false

                switch(this.motivo_consulta){
                    case 'proceso psicológico':
                        
                            this.tipo_terapia_pane= false
                            this.reservas_pane= true
                            this.tipo_problema_pane=false
                            this.activeTab= 'tab4'
                this.whatsapp=false
                this.whatsapp_helpgroup=false
                        break;
                    case 'consejo': 
                    case 'cuestionamientos':
                        
                            this.tipo_terapia_pane= false,
                            this.reservas_pane= false,                            
                            this.tipo_problema_pane=false
                            this.whatsapp=true
                        break;
                    case 'gratuita':
                        
                            this.tipo_terapia_pane= false,
                            this.reservas_pane= false,                            
                            this.tipo_problema_pane=false
                            this.whatsapp=false
                            this.whatsapp_helpgroup=true
                }
            }
        }
    }
</script>

@if(auth()->user()->hasRole('paciente'))

  
<div class="container" x-data="cita()" x-init="reserva_gratuita({{auth()->user()->id}})">


<div class="text-body bg-body p-3  rounded-3" x-show="reserved_pane">
   
<center>
    <div class="callout"><h1 x-show="message" class="text-danger"> <i class="fa fa-exclamation-circle" aria-hidden="true"></i>  Usted ya tiene una reservación gratuita con nosotros</h1></div>
    </center>

    <div class="container card p-10" x-show="message">
        <div class="card-header">
            <h2 >Mis reservaciones</h2>
        </div>
        <div class="card-body container-fluid">

            <table class="table table-striped table-responsive-lg">
                <thead class="thead-dark">
                    <th>Paciente</th>
                    <th>Fecha de consulta</th>
                    <th>Hora de consulta</th>
                    <th>Especialista</th>
                    <th>Problema a tratar</th>
                </thead>
                <tbody>
                    <template x-for="reservacion in mis_reservaciones" :key="reservacion.id">
                        <tr>
                            <td x-text="reservacion.patient.name"></td>
                            <td x-text="reservacion.appointment_date"></td>
                            <td x-text="reservacion.schedule.schedule"></td>
                            <td x-text="reservacion.schedule.at_this_hour_psyc.personal_info.name"></td>
                            <td x-text="reservacion.cause"></td>
                        </tr>
                        <option :value="tipo_problema.id" x-text="tipo_problema.problem"></option>
                    </template>
                </tbody>
                
            </table> 
        </div>
    </div>
</div>

    <div class="row justify-content-center" x-show="primera_vez">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><h2>Diagnóstico</h2></div>
                    <div class="card-body">
                        <ul class="nav nav-tabs" data-tabs="tabs">
                            <li data-toggle="tab" :class="{'active': activeTab === 'tab1'}">
                                <a href="#red" id="tipo_terapia_pane_link"  x-on:click.prevent="activeTab = 'tab1'" >Tipo de terapia</a>
                            </li>
                            <li data-toggle="tab" :class="{'active': activeTab==='tab2'}">
                                <a href="#orange"                            
                                 x-on:click.prevent="activeTab= 'tab2'" >Problema a tratar</a>
                            </li>
                            <li data-toggle="tab" :class="{'active': activeTab === 'tab3'}">
                                <a href="#yellow"  x-on:click.prevent="activeTab = 'tab3'">Preguntas</a>
                            </li>
                            <li data-toggle="tab"  :class="{'active': activeTab === 'tab4'}">
                                <a href="#green" x-on:click.prevent="activeTab = 'tab4'">Reserva</a></li>
                        </ul>


                    <!--div class="tab-content"-->
                    <div>
                        <div id="red" class="tab-pane" x-show="activeTab === 'tab1'" >
                            <select name="therapy_type" class="form-control" x-on:change="problema(),open_problem_link=true,activeTab= 'tab2'" x-model="tipo_terapia_id" @click="$nextTick(() => $refs.tab2.focus())">
                            <option value="#">Seleccione una opcion</option>    
                            @foreach($terapias as $terapia) 
                                    <option value="{{$terapia->id}}">{{$terapia->therapy_type}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div id="orange" x-show="activeTab=== 'tab2'" x-ref="tab2" class="tab-pane">
                        <h1>Cuál es el problema?</h1>

                        <select name="tipo_problema" x-on:change="activeTab= 'tab3'"  @click="$nextTick(() => $refs.tab3.focus())" id="" class="form-control @error('tipo_problema') is-invalid @enderror" x-model="tipo_problema_id">
                            <option value="#">Seleccione una opcion</option>       
                            <template x-for="tipo_problema in problemas_bag" :key="tipo_problema.id">
                                <option :value="tipo_problema.id" x-text="tipo_problema.problem"></option>
                            </template>
                        </select>
                    </div>

                    <div id="yellow" class="tab-pane" x-show="activeTab=== 'tab3'" x-ref="tab3" class="tab-pane">
                        <h1>Que busca con ésta sesión?</h1>
                        <select name="motivo_consulta" class="form-control" id="motivo_consulta" x-model="motivo_consulta" @change="sugerencia()">
                            <option> Seleccione una opción</option>    
                            <option value="consejo">Consejo</option>
                            <option value="proceso psicológico">Proceso psicológico</option>
                            <option value="cuestionamientos">Resolver cuestionamientos</option>
                            <option value="gratuita">Ayuda gratuita</option>
                        </select>
                    </div>

                    <div id="green" class="tab-pane" x-show="activeTab=== 'tab4'" x-ref="tab4" x-transition>
                            <div class="container" >
                                <center>
                                    <h1 @click="$dispatch('mi_evento', heroes)">Reserva tu terapia</h1>
                                    <h5> Te recomendamos nuestros tres mejores terapeutas </h5>
                                </center>
                            </div>
                        
                        <form @submit.prevent="ReservaForm">
                            @csrf
                            <hr>
                                <div class="row p10">
                                    <div class="col-lg-12 p-10"><h4 class="text-primary">Paso 1. Selecciona a tu terapeuta</h4>
                                    @if(count($psicologos)==0)
                                    
                                        <center> 
                                            <div>
                                                    <h5> Todavía no hay terapeutas registrados en el sistema. Espera que alguien se registre </h5>
                                            </div>
                                        </center>
                                    @endif
                                </div>

                                    
                                    @foreach($psicologos as $psicologo)
                                        <div class="col-lg-4 p3">
                                            <center>
                                                <a href="#" @click="formData.especialista='{{$psicologo->personalInfo->name}} {{$psicologo->personalInfo->lastname}}'"><img src="{{ asset($psicologo->photo) }}" class="hover-img img-circle" alt="" height="52" width="52" x-on:click="psicologos({{$psicologo->id}}),message= true"></a>
                                                 <h4><i>{{$psicologo->personalInfo->name}} {{$psicologo->personalInfo->lastname}}</i></h4>
                                            </center>
                                           
                                        </div> 
                                    @endforeach
                                </div>
                            </center>
                                <hr>
                            <div class="row p10">
                                <h4 class="text-primary">Paso 2. Que día y en que horario desea tener su consulta?</h4>
                                <div class="container col-lg-6">
                                    <label x-show="message">Fecha de consulta</label>
                                    <input type="date" class="form-control" x-model="formData.appointment_date" min = "<?php echo date("Y-m-d",strtotime(date("Y-m-d")));?>">
                                </div>
                                <div class="col-lg-6">
                                    <label x-show="message">Horarios disponibles</label>
                            
                                    <select name="horario" class="form-control" id="horario" x-model="horario" @change="resume_pane= true">
                                        <option value="#">Seleccione una opcion</option>
                                        <template x-if="horarios.length === 0">
                                            <option value="#">Este psicólogo no ha registrado ningún horario de atención</option>
                                        </template>
                                        <template x-for="horario in horarios" :key="horario.id">
                                            <option :value="horario.id" x-text="horario.schedule" @click="horario_consulta: horario.schedule"></option>
                                        </template>
                                    </select>
                                </div>
                            </div>
                            
                            <hr>
                            <div id="resume_pane" x-show="resume_pane" >
                                <h1>Resumen</h1>

                                <div class="card">
                                    <div class="card-body">
                                        <h4>Paciente: {{auth()->user()->name}}</h4>
                                        <h4>
                                        Fecha de consulta: <span x-text="formData.appointment_date"></span></h4>
                                        <h4>Horario de consulta: <span x-text="horario_de_consulta_prop"></span></h4>
                                        <h4>Motivo de consulta: <span x-text="motivo_consulta"></span></h4>
                                        <h4>Especialista: <span x-text="formData.especialista"></span></h4>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            {{-- Register button --}}
                            <div class="container-fluid">
                                <button type="submit" class="btn btn-block {{ config('adminlte.classes_auth_btn', 'btn-flat btn-primary') }}" @click="ReservaForm()" :disabled="disableButton" >
                                    <span class="fas fa-bookmark"></span>
                                    Reservar
                                </button>
                            </div>
                        </form>
                    </div>
                    
                    <div class="whatsapp">
                        <blockquote class="blockquote" x-show="whatsapp">
                        <h1 class="h2" >Escríbenos a nuestro whatsapp oficial para obtener un consejo</h1> 
                        <i x-show="whatsapp"><h4> Haz click en la imagen para llevarte a whatsapp web</h4></i>
                        </blockquote>
                        <center><a href="https://wa.link/o9fv1e"><img src="{{asset('images/whatsapp.png')}}" alt="Escríbenos a nuestro whatsapp" srcset="" x-show="whatsapp" width="120"></a>


                        <blockquote class="blockquote" x-show="whatsapp_helpgroup">
                        <h1 class="h2" >Escríbenos a nuestro grupo de ayuda de Whatsapp</h1>    
                        <i x-show="whatsapp_helpgroup"><h4> Haz click en la imagen para llevarte a whatsapp web</h4></i>
                        </blockquote>
                        <a href="https://wa.link/34z7ns"><img src="{{asset('images/whatsapp.png')}}" alt="Escríbenos a nuestro whatsapp" srcset="" x-show="whatsapp_helpgroup" width="120"></a>
                        </center>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <template id="my-template">
        <swal-title>
        Si después de la sesión de prueba desea comenzar con su terapia, éste sería el presupuesto.
        </swal-title>
        <swal-html> <h4>Está de acuerdo?</h4>
            
            <p>4 x 360</p>
            <p>6 x 450</p>
            <p>8 x 650</p>
            <p>12 x 700</p>
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

@elseif(auth()->user()->hasRole('administrador') )


<div class="row">
    <div class="card col-lg-12">
        <div class="card-header">
            
            <h2>Estadísticas generales</h2>
        </div>
        <div class="card-body">
            <div>
        <div class="small-box bg-gradient-success">
            <div class="inner">
                <h3>{{$reservaciones}}</h3>
                <p>Reservaciones totales</p>
            </div>
            <div class="icon">
                <i class="fas fa-user-plus"></i>
            </div>
            <a href="{{route('reservas.index')}}" class="small-box-footer">
                Ver <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>

    <div>
        <div class="small-box bg-gradient-success">
            <div class="inner">
                <h3>{{$psicologos_cant}}</h3>
                <p>Psicólogos registrados</p>
            </div>
            <div class="icon">
                <i class="fas fa-user-plus"></i>
            </div>
            <a href="{{route('psicologos.index')}}" class="small-box-footer">
                Ver <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>

    <div>
        <div class="small-box bg-gradient-success">
            <div class="inner">
                <h3>{{$usuarios}}</h3>
                <p>Usuarios registrados</p>
            </div>
            <div class="icon">
                <i class="fas fa-user-plus"></i>
            </div>
            <a href="{{route('usuarios.index')}}" class="small-box-footer">
                Ver <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
        </div>
    </div>
    
</div>
@elseif(auth()->user()->hasRole('psicologo'))
<div class="row">
    <div class="col-lg-4">
        <div class="small-box bg-gradient-success">
            <div class="inner">
                <h3>{{$reservaciones}}</h3>
                <p>Citas pendientes</p>
            </div>
            <div class="icon">
                <i class="fas fa-user-plus"></i>
            </div>
            <a href="{{route('reservas.index')}}" class="small-box-footer">
                Ver <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
    <div class="col-lg-4 offset-3">
        
        <div class="small-box bg-gradient-info">
            <div class="inner">
                <span class="info-box-text">Puntuación</span>
            </div>
            <div class="icon">
                <div class="info-box-content" style="padding:10px;">
                    <h1 class="info-box-number text-dark">{{Auth::user()->Ispsychologist->ranking}}</h1>
            </div>
                <i class="fas fa-star"></i>
            </div>
        </div>
    </div>
</div>
    

    
@endif

<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection
