@extends('adminlte::master')

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

                    @if(session()->has('ended_session'))
                        <div class="alert alert-info">
                            {{ session()->get('ended_session') }}
                        </div>
                    @endif
                </center>
            </div>
        </div>

        <div>

            <div class="col d-flex justify-content-center">
                {{-- Logo --}}
                <div class="custom-container custom-bg col-md-8">
                    <div class="row">
                        <div class="col-lg-12">
                            <center>

                            <img src="{{ asset(config('adminlte.logo_img', 'vendor/adminlte/dist/img/AdminLTELogo.png')) }}"
                            alt="{{ config('adminlte.logo_img_alt', 'AdminLTE') }}"
                            
                            height="150" class="img-responsive">
                            </center>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <center>
                            <a href="{{ $dashboard_url }}">

                                <img src="{{ asset(config('adminlte.logo_img2', 'vendor/adminlte/dist/img/cognitiva.png')) }}"
                                alt="{{ config('adminlte.logo_img_alt', 'AdminLTE') }}"
                                height="107" class="logo-cognitiva img-responsive">
                            </a>
                            </center>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-3"></div>
                        <div class="col-lg-6">
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
                        <div class="col-lg-3"></div>
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
