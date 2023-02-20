@extends('adminlte::master')
<style>
    body{
        
        /*background-size: cover;*/
    }

    .left{
        height:auto;
        background-image: url("../public/images/terapista.jpg");background-position: center;
        background-repeat: no-repeat;
    }
</style>
@php( $dashboard_url = View::getSection('dashboard_url') ?? config('adminlte.dashboard_url', 'home') )

@if (config('adminlte.use_route_url', false))
    @php( $dashboard_url = $dashboard_url ? route($dashboard_url) : '' )
@else
    @php( $dashboard_url = $dashboard_url ? url($dashboard_url) : '' )
@endif

@section('adminlte_css')
    @stack('css')
    @yield('css')
@stop

@section('classes_body'){{ ($auth_type ?? 'login') . '-page' }}@stop

@section('body')
    <div class="container-fluid" >
<div class="row">
    <div class="col-lg-12">
        <center>
            @if(session()->has('success'))
                <div class="alert alert-success">
                    {{ session()->get('success') }}
                </div>
            @endif
        </center>
    </div>
</div>


        {{-- Logo --}}
        <div class="row">
            <div class="col-lg-12" style="background-color:#fff;">
                <center>
                <a href="{{ $dashboard_url }}">
                <img src="{{ asset('images/psicologo-monterrico.png') }}">
                </a>
                </center>
            </div>
            
        </div>
        <div class="row flex">
            <div class="col-md-6">
                 <img class="im-lat" src="{{ asset('images/terapista.jpg') }}">
            </div>
            <div class="col-md-6 m" align="right">
                <div class="{{ $auth_type ?? 'login' }}-box p-4">

                    {{-- Card Box --}}
                    <div class="card {{ config('adminlte.classes_auth_card', 'card-outline card-primary') }}">

                        {{-- Card Header --}}
                        @hasSection('auth_header')
                            <div class="card-header {{ config('adminlte.classes_auth_header', '') }}">
                                <h3 class="card-title float-none text-center">
                                    @yield('auth_header')
                                </h3>
                            </div>
                        @endif

                        {{-- Card Body --}}
                        <div class="card-body {{ $auth_type ?? 'login' }}-card-body {{ config('adminlte.classes_auth_body', '') }}">
                            @yield('auth_body')
                        </div>

                        {{-- Card Footer --}}
                        @hasSection('auth_footer')
                            <div class="card-footer {{ config('adminlte.classes_auth_footer', '') }}">
                                @yield('auth_footer')
                            </div>
                        @endif

                    </div>

                </div>
            </div>
        </div>
    </div>
    
@stop

@section('adminlte_js')
    @stack('js')
    @yield('js')
@stop
