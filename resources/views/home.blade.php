@extends('adminlte::page')

@section('content')


<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.2/moment.min.js"></script>
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
            
            selectedTherapist: false,
            current_date:'',
            reserved_pane:false,
            link:'',

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

            especialistas:[],

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
            validarfecha(){
                const fecha= this.formData.appointment_date
                if(moment(fecha).day()===0){
                    alert("No se puede seleccionar el dia domingo. Porfavor seleccione otra fecha")
                }
            },
            get horario_de_consulta_prop(){

                const nuevoarrayhoras= this.horarios;

                for(let i= 0; i<nuevoarrayhoras.length;i++){

                    if(nuevoarrayhoras[i].id== this.horario){

                        return nuevoarrayhoras[i].schedule;

                    }

                }

                

            },
            get fecha_actual(){

                var today = new Date();
 
                // `getDate()` devuelve el día del mes (del 1 al 31)
                var day = today.getDate();
                
                // `getMonth()` devuelve el mes (de 0 a 11)
                var month = today.getMonth() + 1;

                 var year = today.getFullYear();
                
                if(month.toString().length==1){
                   month= `0${month}`
                }

                if(day.toString().length==1){
                    day = `0${day}`; 
                }
                   return `${year}-${month}-${day}`; 
            },
            get fecha_actual_mas_1(){
                var dias_a_partir_de_hoy = 1;
                return moment(this.fecha_actual).add(1, 'day').format('YYYY-MM-DD');
            },
            seleccionarespecialista(){
                
                var especialistaEnTerapia = this.tipo_terapia_id;

                fetch(`seleccionar_especialista/${especialistaEnTerapia}`).
                then(r => r.json()).
                then((data) => {
                    this.especialistas= data
                    this.dias_atencion= this.especialistas.works_at_hours
                }).catch()
            },
            reserva_gratuita(param){
                fetch(`reserva_gratuita/${param}`).
                then(r => r.json()).
                then((data) => {

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
                                
                                if(this.mis_reservaciones[0].link_meeting==undefined){
                                    this.link= 'Espera que tu psicólogo te compara el link de la reunión. Regresa más tarde para ver si ya está disponible el link';
                                }else{
                                    this.link=this.mis_reservaciones[0].link_meeting
                                }

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
                            html: '<h4>En breves momentos le enviaremos a su correo un email que contiene el link a la reunión de meet con el terapeuta que usted seleccionó</h4>'
                            })

                            this.disableButton=true

                            this.open_resumen_link= true
                            
                            location.href ='{{route("home")}}';
                        }
                    })
                    .catch((data)=> {
                        console.log('Error'),

                    

                        Swal.fire({

                        icon: 'error',

                        title: 'Oops...',

                        text: 'Algo salió mal',

                        html: '<h4>Asegurate de que completaste todo el formulario.</h4>'

                        })
                    }

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
                    
                    <th>Link de la reunión</th>

                </thead>

                <tbody>

                    <template x-for="reservacion in mis_reservaciones" :key="reservacion.id">

                        <tr>

                            <td x-text="reservacion.patient.name"></td>

                            <td x-text="reservacion.appointment_date"></td>

                            <td x-text="reservacion.schedule.schedule"></td>

                            <td >

                                <span x-text="reservacion.schedule.at_this_hour_psyc.personal_info.name"></span>
                                
                                <span x-text="reservacion.schedule.at_this_hour_psyc.personal_info.lastname"></span>
                            </td>

                            <td x-text="reservacion.cause"></td>
                            
                            <td>
                                <span x-text="link"></span>
                            </td>
                        </tr>
                        <option :value="tipo_problema.id" x-text="tipo_problema.problem"></option>
                    </template>
                </tbody>
            </table> 

            <div class="row justify-content-center">
                <div class="col-8 mt-3">
                    <h4 class="text-center">Necesitas más información? Escríbenos a nuestro whatsapp para cualquier duda, sugerencia o notificación</h4>
                
                    <a href="https://wa.link/o9fv1e">
                    <img src="{{asset('images/whatsapp.png')}}" class="d-block mx-auto" alt="Escríbenos a nuestro whatsapp"  x-show="message" width="120"></a>
                </div>
            </div>
        </div>
    </div>
</div>



    <div class="row justify-content-center" x-show="primera_vez">

        <div class="col-12 col-md-10 col-lg-8">

            <div class="card pb-4">

                <div class="card-header text-uppercase bg-primary"><h2>Diagnóstico</h2>
                </div>

                <div class="card-body">

                    <ul class="nav nav-tabs" data-tabs="tabs">

                        <li data-toggle="tab" :class="{'active': activeTab === 'tab1'">

                            <a class="bg-secondary my-3" href="#red" id="tipo_terapia_pane_link"   >Tipo de Terapia</a>

                        </li>

                        <li data-toggle="tab" :class="{'active': activeTab==='tab2'}">

                            <a class="bg-success my-3" href="#orange"                            

                                >Problema a tratar</a>

                        </li>

                        <li data-toggle="tab" :class="{'active': activeTab === 'tab3'}">

                            <a class="bg-info my-3" href="#yellow">Preguntas</a>

                        </li>

                        <!--li data-toggle="tab"  :class="{'active': activeTab === 'tab4'}">

                            <a href="#green" >Reserva</a>
                        </li-->

                    </ul>

                    <div> <!-- div arriba de red -->
                        <div id="red" class="tab-pane" x-show="activeTab === 'tab1'"  x-ref="tab1">


                            <div class="input-group row">
                                <div class="col-12">
                                    <h3 class="bg-secondary text-center mt-5 py-3 text-capitalize">Seleccione el Tipo de Terapia que desea.</h3>
                                </div>
                                <div class="col-12">
                                    <select name="therapy_type" class="form-control"  x-model="tipo_terapia_id" >
                                        <option class="text-bold evitar-click" value="#"><b>Seleccione una opción </b></option> 
                                        <!-- agregado para arreglar -->
                                        @foreach($terapias as $terapia) 
                                            <option value="{{$terapia->id}}">{{$terapia->therapy_type}}</option>
                                        @endforeach
                                    </select>

                                </div> <!--  cierre del col 12 -->
                            </div> <!-- cierre del row -->
                            <div class="display-boton-container">
                            
                                <button x-on:click="problema(),seleccionarespecialista(),open_problem_link=true,activeTab= 'tab2'" class="btn btn-danger" @click="$nextTick(() => $refs.tab2.focus())"> Siguiente >> </button>
                            
                            </div>
                        </div> <!--  div red -->
                   


                        <div id="orange" x-show="activeTab=== 'tab2'" x-ref="tab2" class="tab-pane">
                            <div class="row">
                                <div class="col-12">
                                    <h3 class="bg-success text-center mt-5 py-3 text-capitalize">¿Qué Problema Desea Tratar?</h3>
                                </div>

                                <div class="col-12">
                                    
                                    <select name="tipo_problema" id="" class="form-control @error('tipo_problema') is-invalid @enderror" x-model="tipo_problema_id" >
                                        <!-- aqui iria 736 linea -->

                                        <template x-for="tipo_problema in problemas_bag" :key="tipo_problema.id">

                                            <option :value="tipo_problema.id" x-text="tipo_problema.problem"></option>
                                        </template>
                                    </select>

                                </div> <!-- cierre del col-12 -->
                            </div> <!-- cierre del row -->
                                <div class="display-boton-container">
                                    <button class="btn btn-danger mr-5"  @click="$nextTick(() => $refs.tab1.focus()), activeTab= 'tab1'"> << Atrás
                                    </button>
                                    <button  x-on:click="activeTab= 'tab3'"  @click="$nextTick(() => $refs.tab3.focus())" class="btn btn-danger"> Siguiente >> </button>
                                </div>
                                
                        </div> <!--  div orange -->
                    </div><!-- cierre del div que no vemos funcion -->

                    <div id="yellow" class="tab-pane" x-show="activeTab=== 'tab3'" x-ref="tab3" class="tab-pane">
                            <div class="row">
                                <div class="col-12">
                                    <h3 class="bg-info text-center mt-5 py-3 text-capitalize">¿Qué Buscas con esta Sesión?</h3>
                                </div>
                                <div class="col-12">
                                    <select name="motivo_consulta" class="form-control" id="motivo_consulta" x-model="motivo_consulta" >
                                      
                                        <option class="text-bold d-none"> <b>Seleccione una opción</b></option>    

                                        <option value="consejo">Consejo</option>

                                        <option value="proceso psicológico">Proceso psicológico</option>

                                        <option value="cuestionamientos">Resolver cuestionamientos</option>

                                        <option value="gratuita">Ayuda gratuita</option>

                                    </select>

                                </div> <!-- cierre de col -12 -->
                            </div> <!-- cierre de row -->
                           
                
                            <div class="display-boton-container">
                                <button @click="sugerencia()" class="btn btn-danger"> Siguiente >></button>
                            </div>
                          
                    </div> <!-- div yellow -->



                    <div id="green" class="tab-pane" x-show="activeTab=== 'tab4'" x-ref="tab4" x-transition>

                            <div class="container">

                                <center>

                                    <h2 class="h1 text-capitalize" @click="$dispatch('mi_evento', heroes)">Reserva tu terapia</h1>

                                    <h4> Te recomendamos nuestros tres mejores terapeutas en el tipo de terapia que necesitas </h5>

                                </center>

                            </div>

                        

                        <form @submit.prevent="ReservaForm">

                            @csrf

                            <hr>

                                <div class="row p-2 justify-content-center">

                                    <div class="col-12 p-2">
                                        <h3 class="bg-info p-3">Paso 1. Selecciona a tu terapeuta</h4>

                                        @if(count($psicologos)==0)
                                            <div>
                                                <h5> Todavía no hay terapeutas registrados en el sistema. Espera que alguien se registre </h5>
                                            </div>
                                        @endif

                                    </div>
                                    <div class="container">
                                        <div class="row">
                                            <template x-for="especialista in especialistas" :key="especialista.id">
                                                <div class="col-12" x-on:click="psicologos(especialista.id),message= true">
                                                        <div class="efecto-foto">
                                                            <a class="d-block my-3 text-center" href="#" @click="formData.especialista=`${especialista.personal_info.name} ${especialista.personal_info.lastname}`,selectedTherapist= true">
                                                                <img :src="`${especialista.photo.substring(1)}`" class="mx-auto d-block my-4" alt="" height="200" width="200" >
                                                                <h2 class="text-center text-capitalize"><span x-text="especialista.personal_info.name"></span>  <span x-text="especialista.personal_info.lastname"></span></h2>
                                                            

                                                                <h3 class="text-center text-capitalize">Especialista en <span x-text="especialista.therapy.therapy_type"></span></h3>
                                                            </a>

                                                        </div>
                                                       
                                                        <h4 class="text-center text-capitalize"><span x-text="especialista.bio"></span></h4>
                                                        <h4 class="text-center font-weight-bold">Días y horarios de atención: </h4>
                                                    

                                                    <template x-for="schedule in especialista.works_at_hours">
                                                        <p>
                                                            <span x-text="schedule.dia"></span>: <span x-text="schedule.schedule"></span>
                                                        </p>
                                                    </template>
                                                </div>
                                            </template>
                                        </div>
                                    </div>
                                </div>


                                <hr>

                                
                                
                                <h3 class="bg-info p-3 my-3">Paso 2. Que día y en que horario desea tener su consulta?</h3>
                                <div class="row p10" x-show="selectedTherapist">

                                <div class="container col-lg-6">

                                    <label x-show="message">Fecha de consulta</label>

                                    <input type="date" class="form-control" x-model="formData.appointment_date" :min="fecha_actual" :max="fecha_actual_mas_1" :change="validarfecha()">

                                </div>

                                <div class="col-lg-6">

                                    <label x-show="message">Horarios disponibles</label>
                                    <select name="horario" class="form-control" id="horario" x-model="horario" @change="resume_pane= true">

                                        <option value="#"><b>Seleccione una opcion</b></option>

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

                                        <h4>Especialista: <span x-text="formData.especialista"></span> </h4>

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

                    </div> <!--  div green -->

                

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

                    </div> <!--  dib whtsapp -->

                </div>

            </div>

        </div>

    </div>



    <template id="my-template">

        <swal-title>

        Si después de la sesión de prueba desea comenzar con su terapia, éste sería el presupuesto.

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



@elseif(auth()->user()->hasRole('administrador') )

<div class="row">

    <div class="card col-lg-12">

        <div class="card-header">

            <h2>Estadísticas generales</h2>

        </div>

        <div class="card-body">

            <div>

        <div class="small-box bg-gradient-primary">

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

        <div class="small-box bg-gradient-primary">

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

        <div class="small-box bg-gradient-primary">

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

    <div class="col-lg-6">

        <div class="small-box bg-gradient-primary">

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

    <div class="col-lg-6">

        

        <div class="small-box bg-gradient-info">

            <div class="inner" style="padding:10px;">

                <span class="info-box-text">Puntuación</span>
                <h1 class="info-box-number text-dark">{{Auth::user()->Ispsychologist->ranking}}</h1>
            </div>

            <div class="icon" style="padding:10px;">

                <div class="info-box-content">

                    

            </div>

                <i class="fas fa-star"></i>

            </div>

        </div>

    </div>

</div>


@endif

<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@endsection

