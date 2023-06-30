@extends('adminlte::page')

@section('content')
    <div class="row justify-content-center">
        <div class="card col-8 mt-3 p-5 whatsapp">
            <h4 class="text-center">Para continuar con el proceso de agenda escribenos a nuestro whatsapp</h4>
        
            <a href="https://wa.link/o9fv1e">
            <img src="{{asset('images/whatsapp.png')}}" class="d-block mx-auto img-fluid " alt="Escríbenos a nuestro whatsapp"  x-show="message" width="120"></a>
        </div>
    </div>
@stop

