@extends('adminlte::page')

@section('content')

<html>
        <div class="container-fluid card psico-profile">
            <div class="container">
                <div class="row  m-5">
                    <div class="col">

                        <img class="d-block img-responsive mx-auto img-circle" src="{{ asset($info_psicologo->photo) }}" alt=""  width="300" height="300">
                        
                        
                        <h1 class="text-center py-3"><!-- {{$info_psicologo->id}} -  -->{{$info_psicologo->personalInfo->name}} {{$info_psicologo->personalInfo->lastname}}</h1>
                        
                        <p class="text-center">{{$info_psicologo->bio}}</p>
                    </div>
                </div>
            </div>
            <hr>

            <div class="container"> <!-- Datos personales-->
                <div class="row m-5">
                    <div class="col-12">

                        <h2 class="text-center">Datos personales</h1>
                    
                            <h3 class="text-center"><b>Correo:</b> {{$info_psicologo->personalInfo->email}}</h3> 

                            <h3 class="text-center"><b>Teléfono personal:</b>{{$info_psicologo->personal_phone}}</h3>


                            <h3 class="text-center"><b>Teléfono de empresa:</b> {{$info_psicologo->bussiness_phone}}</h3>
                            
                            <h3 class="text-center"><b>Especialista en :
                            <ul>
                                @foreach($info_psicologo->therapiesOffered as $tipo_therapy)
                                    <li><p>{{$tipo_therapy->therapy->therapy_type}}</p></li>
                                @endforeach    
                            </ul> 
                        
                            <h3><b>
                            Puntuación:</b> {{$info_psicologo->ranking}}
                            </h3>
                        
                    </div>
                </div>
            </div>

            <hr>
            <div class="container"> <!-- Días y horarios de atención-->
                
                <div class="row m-5">
                        <div class="col">
                            <h2 class="text-center">Días y horarios de atención</h1>

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

                        <h2 class="text-center"> Reservaciones</h1>
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