@extends('adminlte::master')
<style>
   /*  .login-page{
        
        background-image: url("../public/images/terapista.jpg");
        background-repeat: no-repeat;
            background-size: cover;
        background-position: center ;
        justify-content: flex-start !important;
    }
    .left{
        height:auto;
    } */
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

        <div>

            <div class="col">
                {{-- Logo --}}
                <div class="row">
                    <div class="col-lg-12">
                        <center>
                        <a href="{{ $dashboard_url }}">
                        <img src="{{ asset('images/psicologo-monterrico.png') }}">
                        </a>
                        </center>
                    </div>
                </div>
            </div>
        
            <div class="row">
                <div class="col-lg-4"></div>
                <div class="col-lg-4">
                    <!--img class="im-lat" src="{{ asset('images/terapista.jpg') }}"-->
                    {{-- Card Box --}}
                    <div class="card {{ config('adminlte.classes_auth_card', 'card-outline card-primary') }}">
                        {{-- Card Header --}}
                        @hasSection('auth_header')
                            <div class="card-header {{ config('adminlte.classes_auth_header', '') }}">
                                <h3 class="card-title float-none text-center">
                                    Inicia sesión
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
                <div class="col-lg-4"></div>
            </div>
        </div>
    </div>
    
@stop

@section('adminlte_js')
    @stack('js')
    @yield('js')
@stop
