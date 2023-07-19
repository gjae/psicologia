@extends('adminlte::page')

@section('content')


@can('registrar_reservacion_paciente_psicologo')

<div class="container" x-data="reservacita">

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
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h1 class="text-uppercase">Reservar cita paciente-psicólogo</h1>
                </div>
                
                <div class="card-body">
                    <form action="" method="post" @submit.prevent="ReservaForm">
                        <div class="row">
                            <div class="col-3 d-flex align-items-center">
                                <h3>Paciente</h3>
                            </div>
                            <div class="col">
                                <select name="paciente" class="form-control" x-model="formData.id_user" @click="setPacienteName($event)">
                                    
                                    <option class="text-bold evitar-click" value="#"><b>Seleccione una opción </b></option>
                                    @foreach($pacientes as $paciente)
                                        <option value="{{$paciente->id}}" data-paciente="{{$paciente->name}} {{$paciente->lastname}}">{{$paciente->name}} {{$paciente->lastname}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-3 align-items-center">
                                <h3>Tipo de terapia</h3>

                                <select name="terapia" class="form-control" x-model="tipo_terapia_id" x-on:change="tipo_problema($event)">
                                    
                                    <option class="text-bold evitar-click" value="#"><b>Seleccione una opción </b></option>
                                    @foreach($terapias as $terapia)
                                        <option value="{{$terapia->id}}" data-name="{{$terapia->therapy_type}}">{{$terapia->therapy_type}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col">
                                <h3>
                                    Tipo de problema
                                </h3>

                                <select name="tipo_problema_id" id="" class="form-control @error('tipo_problema') is-invalid @enderror" x-model="tipo_problema_id" x-model="motivo_consulta" @change="seleccionarespecialista($event)">
                                        
                                    <option class="text-bold evitar-click" value="#"><b>Seleccione una opción </b></option> 
                                    <template x-for="tipo_problema in problemas_bag" :key="tipo_problema.id">
                                        <option :value="tipo_problema.id" x-text="tipo_problema.problem" :data-name="tipo_problema.problem"></option>
                                    </template>
                                </select>
                            </div>
                        </div>

                        <div class="row" >
                            <div class="col d-flex justify-content-center">
                                <h3>Lista de psicólogos especialistas en <span x-text="tipo_de_terapia_name"></span> especializados en <span x-text="tipo_de_problema_name"></span></h3>
                            </div>
                        </div>
                        
                        <div class="row table-responsive" x-bind:class="{ 'd-none': !especialistas }">
                                
                                    <template x-for="especialista in especialistas" :key="especialista.id" >
                                        <div class="col-lg-4 col-md-6 col-sm-12 p-5 efecto-foto">
                                            <div x-on:click="psicologos(especialista.id)">
                                                    <div class="efecto-foto">
                                                        <a class="d-block my-3 text-center" href="#" @click="formData.especialista=`${especialista.personal_info.name} ${especialista.personal_info.lastname}`,selectedTherapist= true">
                                                            <img :src="`${especialista.photo.substring(1)}`" class="mx-auto d-block my-4" alt="" height="200" width="200" >
                                                            <h2 class="text-center text-capitalize"><span x-text="especialista.personal_info.name"></span>  <span x-text="especialista.personal_info.lastname"></span></h2>
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
                                        
                                        </div>
                                    </template>
                                
                                <h4 x-text="mensaje"></h4>
                        </div>

                        <div class="row">
                            <div class="col p10" x-show="selectedTherapist">

                                <div class="container col-lg-6">
                                    <label>Fecha de consulta</label>
                                    <input type="date" class="form-control" x-model="formData.appointment_date" :min="fecha_actual" :max="fecha_actual_mas_1" :change="validarfecha()">
                                </div>

                                <div class="col-lg-6">
                                    <label >Horarios disponibles</label>
                                    <select name="horario" class="form-control" id="horario" x-model="horario" @change="disableButton=false, resume_pane= true">
                                        <option value="#"><b>Seleccione una opcion</b></option>
                                        <template x-if="horarios.length === 0">

                                            <option value="#">Este psicólogo no ha registrado ningún horario de atención</option>

                                        </template>

                                        <template x-for="horario in horarios" :key="horario.id">

                                            <option :value="horario.id" x-text="horario.schedule" @click="horario_consulta: horario.schedule"></option>

                                        </template>

                                    </select>
                                </div>

                                <div class="col-lg-6" x-show="menores">
                                    <label for="apoderado">Soy el apoderado</label>
                                    <input name="apoderado" x-model="formData.apoderado" type="checkbox">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12" >
                                <div id="resume_pane"  x-show="resume_pane">
                                    <h1>Resumen</h1>

                                    <div class="card">
                                        <div class="card-body">

                                            <h4>Paciente: <span x-text="paciente_name"></span></h4>

                                            <h4>
                                            Fecha de consulta: <span x-text="formData.appointment_date"></span></h4>

                                            <h4>Horario de consulta: <span x-text="horario_de_consulta_prop"></span></h4>

                                            <h4>Especialista: <span x-text="formData.especialista"></span> </h4>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- Register button --}}

                        <div class="row">
                            <div class="col-12">
                                <button type="submit" class="btn btn-block {{ config('adminlte.classes_auth_btn', 'btn-flat btn-primary') }}" @click="ReservaForm()" :disabled="disableButton" >
                                    <span class="fas fa-bookmark"></span>
                                    Reservar
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endcan

@endsection

