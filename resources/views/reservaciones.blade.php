@extends('adminlte::page')



@section('content')

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.datatables.net/1.13.2/js/jquery.dataTables.min.js"></script>

    <script src="https://cdn.datatables.net/1.13.2/js/dataTables.bootstrap.min.js"></script>




@endsection
@section('css')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">



<link rel="stylesheet" href="https://cdn.datatables.net/1.13.2/css/dataTables.bootstrap4.min.css">

@endsection

<style>

    .form-inline{

        display:block ! important;

    }

</style>

<script>
    function reservas(){
        return {
            mostrarBoton: true,
            
            link_meet:'',
            
            links:{},
            isValidLink(link) {
                const linkRegex = /^https:\/\/meet.google.com\/[a-z0-9_-]+$/;
                return linkRegex.test(link);
            },
            linkText() {
                if (this.isValidLink(this.link_meet)) {
                    return link;
                } else {
                    alert('El link de google meet ingresado no es válido. Porfavor introduzca un link válido')
                }
            },
            eliminarreserva(reserva){
                Swal.fire({

                    title: 'Está seguro de eliminar ésta reserva',
                    icon: 'warning',
                    cancelButtonText: "No",

                    confirmButtonColor: '#3085d6',
                    showCancelButton: true,
                    confirmButtonText: 'Si',


                    }).then((opt)=>{
                    if (opt.isConfirmed){
                            fetch(`reservas/${reserva}`,

                        {
                            method: 'DELETE',
                                headers: {

                                    'Content-Type': 'application/json',

                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                                    

                                },

                                body:reserva

                        }).then((data) => {

                            Swal.fire({

                            icon: 'success',

                            title: 'Listo!!',
                            
                            text: 'La reserva se ha eliminado',
                            })
                            
                            location.reload()

                        }).catch()


                    }
                    })
            },
            confirmarAsistencia(citaPasada,idCita) {
                if(citaPasada== false){
                    Swal.fire({
                        icon:'warning',
                        title: 'No puedes confirmar la asistencia',
                        text: 'La fecha y hora de la cita no ha llegado'
                        })
                    }else{
                        Swal.fire({
                    title: 'Confirmar asistencia',
                    text: '¿El paciente asistió a la cita?',
                    showCancelButton: true,
                    confirmButtonText: 'Sí',
                    cancelButtonText: 'No',
                    reverseButtons: true
                    }).then((result) => {
                    if (result.isConfirmed) {
                        fetch(`confirmar_asistencia/1/${idCita}`).
                        then(
                            Swal.fire({
                            title: 'Listo',
                            icon: 'success'
                            })
                        ).catch()
                        this.ocultos= false
                        this.message= false
                        location.reload()
                    } else if (result.dismiss === Swal.DismissReason.cancel) {
                        fetch(`confirmar_asistencia/0/${idCita}`).
                        then(
                            location.reload()
                        ).catch()
                    }
                    });
                }
            },
        }
    }
</script>
<div class="row">
    <div class="col-lg-12">
        <center>
            @if(session()->has('cita_agendada'))
                <div class="alert alert-success">
                    {{ session()->get('cita_agendada') }}
                </div>
            @endif
        </center>
    </div>
</div>

<div class="card">

    <div class="card-header">

        <h1>Reservas</h1>

    </div>

    

    <div class="card-body" x-data="reservas()">
        <div class="table-responsive">

        
            <table id="example" class="table table-striped">

                <thead class="thead-dark">
                    <tr>
                        <th>Paciente</th>

                        <th>Email</th>
                        <th>Teléfono</th>

                        <th>Fecha de consulta</th>

                        <th>Hora de consulta</th>

                        <th>Terapeuta</th> 
                        <th>Terapia</th>
                        <th>Problema a tratar</th>
                        <!--th>Motivo de consulta</th-->
                        <th>
                             Apoderado
                        </th>
                        @if(Auth::user()->hasRole('administrador'))
                        <th>Link de la reunión</th>
                        @endif 
                        
                        <th> Confirmar asistencia</th>
                        
                        
                        @if(Auth::user()->hasRole('administrador') || Auth::user()->hasRole('psicologo'))
                        
                        
                        <th></th>
                        @endif
                    </tr>
                </thead>

                @foreach($reservations as $reservation)
                    @if($reservation->status==0)
                        <tr x-data="{
                        citaPasada: @json($reservation->appointment_date <= now()),
                        ocultos: true,
                        message: true,
                        mostrarLinkMeeting: true,
                        }" style="background-color:#f952526e;">
                    @elseif($reservation->status==1)
                        <tr style="background-color:#a6ff8b8f;">
                    @endif
                

                    <td>{{$reservation->patient->name}}</td>

                    <td>{{$reservation->patient->email}}</td>
                    <td>{{$reservation->patient->phone}}</td>

                    <td>{{$reservation->appointment_date}}</td>

                    <td>{{$reservation->schedule->schedule}}</td>

                    <td class="text-capitalize">{{$reservation->schedule->AtThisHourPsyc->personalInfo->name}} {{$reservation->schedule->AtThisHourPsyc->personalInfo->lastname}}</td>
                    
                    <td>{{$reservation->tipo_terapia}}</td>
                    <td>{{$reservation->tipo_problema}}</td>
                    @if($reservation->tipo_terapia == "Terapia de menores")
                        <td>
                            @if($reservation->apoderado == 1)
                                <p>SÍ</p>
                            @else
                                <p>NO</p>
                            @endif
                        </td>
                    @else
                        <td></td>
                    @endif
							@method("post")
							
							{{csrf_field()}}

                    @if(Auth::user()->hasRole('administrador'))
                        <td>
                            <a href="{{$reservation->link_meeting}}">{{$reservation->link_meeting}}</a>
                            <!--  El controlador que renderiza esta vista debe recibir el link de la reunion y enviarlo a esta vista-->
                        </td>
                    @endif
                    <td> 
                        @if($reservation->status==1)
                            <h5 >El paciente ya asistió a su cita</h5>
                        @else 

                        

                        <button type="button" class="btn btn-info" @click="confirmarAsistencia(citaPasada,'{{$reservation->id}}')" >Confirmar asistencia</button>    
                        @endif
                        
                        
                    </td>
                    
                    <td><button class="btn btn-danger" x-on:click="eliminarreserva({{$reservation->id}})">
                       Eliminar</button></td>
                    
                       
                </tr>
                
                @endforeach
            </table>

            <small>
                <p>*  El registro aparecerá marcado en rojo mientras no ha llegado la fecha de consulta. Una vez llegado el día de la consulta, podrá actualizar el status de la reserva para controlar los pacientes que asistieron a consulta y los que no.</p>
                <p>
                    Las reservaciones concretadas aparecerán marcadas en color verde
                </p>
            </small>
        </div>
    </div>

</div>

@section('js')
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