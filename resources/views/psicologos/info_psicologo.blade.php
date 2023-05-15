@extends('adminlte::page')

@section('content')

<html>
        <div class="container-fluid card">
            <div class="container">
                <div class="row  m-5">
                    <div class="col">

                        <img src="{{ asset($info_psicologo->photo) }}" alt="" class="img img-circle" width="300" height="300">
                        
                        
                        <h1 style="font-size:50px;">{{$info_psicologo->id}} - {{$info_psicologo->personalInfo->name}} {{$info_psicologo->personalInfo->lastname}}</h1>
                        
                        <i><h4>{{$info_psicologo->bio}}</h4></i>
                    </div>
                </div>
            </div>
            <hr>

            <div class="container"> <!-- Datos personales-->
                <div class="row m-5">
                    <div class="col">

                        <h1 style="font-size:50px;">Datos personales</h1>
                    
                            <h3><b>Correo:</b> {{$info_psicologo->personalInfo->email}}</h3> 

                            <h3><b>Teléfono personal:</b>{{$info_psicologo->personal_phone}}</h3>


                            <h3><b>Teléfono de empresa:</b> {{$info_psicologo->bussiness_phone}}</h3>
                            
                            <h3><b>Especialista en 
                            <ul>
                                @foreach($info_psicologo->therapiesOffered as $tipo_therapy)
                                    <li><p>{{$tipo_therapy->therapy->therapy_type}}</p></li>
                                @endforeach    
                            </ul> 
                        
                            <h3><b>
                            Puntuación: {{$info_psicologo->ranking}}
                            </b></h3>
                        
                    </div>
                </div>
            </div>

            <hr>
            <div class="container"> <!-- Días y horarios de atención-->
                
                <div class="row m-5">
                        <div class="col">
                            <h1 style="font-size:50px;">Días y horarios de atención</h1>

                            @foreach($info_psicologo->worksAtHours as $dia_hora)
                                <h3><b>{{$dia_hora->dia}} - {{$dia_hora->schedule}}
                                    </b></h3>
                            @endforeach
                        </div>

                </div>
            </div>

            <div class="container">  <!-- Reservaciones-->
                <div class="row  m-5">
                    <div class="col">

                        <h1 style="font-size:50px;"> Reservaciones</h1>
                            @foreach($reservations as $reserva)
                                <h3><b>{{$reserva->schedule->dia}} {{$reserva->appointment_date}} <span>
                                    en el horario de {{$reserva->schedule->schedule}}</b></h3>
                                </span>
                            @endforeach
                    </div>
                </div>
            </div>
        </div>
</html>
@stop