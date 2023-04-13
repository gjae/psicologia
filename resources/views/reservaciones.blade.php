@extends('adminlte::page')



@section('content')

@section('js')

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
            link_meet:'',
            links:{},
            actualizareserva(id, link){
                
                fetch(`link_meet/${id}`,{

                        method: 'POST',

                        headers: {

                            'Content-Type': 'application/json',

                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')

                        },
                        body: JSON.stringify({ link: this.links[id]})
                    }).
                then(r => r.json()).
                then((data) => {
                    Swal.fire({
                        title: 'Listo',
                        icon: 'success'

                })
                    location.reload()
                }).catch()
            }
            /*actualizareserva(id){
                fetch(`link_meet/${id}`,{

                        method: 'POST',

                        headers: {

                            'Content-Type': 'application/json',

                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')

                        },
                        body: JSON.stringify(this.link_meet)
                    }).
                then(r => r.json()).
                then((data) => {
                    Swal.fire({

                        title: 'Listo',
                        icon: 'success'

                })
                    location.reload()
                }).catch()
            }*/
        }
    }
</script>


<div class="card">

    <div class="card-header">

        <h1>Reservas</h1>

    </div>

    <div class="card-body" x-data="reservas()" x-init="inicializar()">
            <table id="example" class="table table-responsive-lg table-striped">

                <thead class="thead-dark">
                    <tr>
                        
                        <th>Paciente</th>

                        <th>Email</th>
                        <th>Teléfono</th>

                        <th>Fecha de consulta</th>

                        <th>Hora de consulta</th>

                        <th>Psicólogo</th>

                        <th>Motivo de consulta</th>
                        @if(Auth::user()->hasRole('psicologo'))
                        <th>Link de la reunión</th>
                        <th></th>
                        @endif
                    </tr>
                </thead>

                @foreach($reservations as $reservation)

                <tr>

                    <td>{{$reservation->patient->name}}</td>

                    <td>{{$reservation->patient->email}}</td>
                    <td>{{$reservation->patient->phone}}</td>

                    <td>{{$reservation->appointment_date}}</td>

                    <td>{{$reservation->schedule->schedule}}</td>

                    <td class="text-capitalize">{{$reservation->schedule->AtThisHourPsyc->personalInfo->name}} {{$reservation->schedule->AtThisHourPsyc->personalInfo->lastname}}</td>
                    <td>{{$reservation->cause}}</td>

                    @if(Auth::user()->hasRole('psicologo'))
                    <form method="post" action="{{route('link_meet',['reservation'=>$reservation->id])}}" role="form" >
							@method("post")
							
							{{csrf_field()}}
                        <td>
                            <input type="hidden" value="{{$reservation->id}}" name="id">
                            @if($reservation->link_meeting)
                                <input type="text" name="link-meet" placeholder="Link de la reunión" title="Porfavor comparte el link del meeting" class="form-control" value="{{$reservation->link_meeting}}" disabled> 
                            @else

                                <input type="text" name="link_meeting" placeholder="Link de la reunión" title="Porfavor comparte el link del meeting" class="form-control" >
                            @endif    
                        </td>
                        <td> 
                        <button type="submit" class="btn btn-success" >Actualizar</button>    
                        <!--button type="submit" class="btn btn-success" x-on:click="
                        actualizareserva({{$reservation->id}}, links[{{$reservation->id}}])">Actualizar</button--></td>
                    </form>
                    
                    @endif
                </tr>
                @endforeach
            </table>
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