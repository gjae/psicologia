@extends('adminlte::page')
@section('content')

<style>
    .nav li{
        padding:10px;
    }
</style>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Diagnóstico</div>

                <div class="card-body">
                        <ul class="nav nav-tabs" data-tabs="tabs">
                        <li class="active"><a href="#red" data-toggle="tab">Tipo de terapia</a></li>
                        <li><a href="#orange" data-toggle="tab">Problema a tratar</a></li>
                        <li><a href="#yellow" data-toggle="tab">Preguntas</a></li>
                        <li><a href="#green" data-toggle="tab">Reserva</a></li>
                    </ul>
                    <div class="tab-content">
                    <div id="red" class="tab-pane active">
                    <select>
                        <option value="0">Terapia de pareja</option>
                        <option value="1">Terapia personal</option>
                        <option value="2">Terapia de menores</option>
                    </select>
                    <button class="btn btn-info"> Siguiente</button>
                    </div>
                    <div id="orange" class="tab-pane">
                    <h1>Cuál es el problema?</h1>
                    Select dependiente del primero

                    </div>
                    <div id="yellow" class="tab-pane">
                    <h1>Te aconsejamos ...</h1>
                    Infomación del power point y preguntas. Test. Al enviar las respuestas redirigir a una ruta que vaya a un condicional para dar al usuario whatsapp, o redirigirlo a la reserva de la cita

                    </div>
                    <div id="green" class="tab-pane">
                    <h1>Reserva tu terapia</h1>
                    Datepicker y formulario para registrar la reserva. Solo se activa si la respuesta al test anterior fué A, B o D, creo..

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
