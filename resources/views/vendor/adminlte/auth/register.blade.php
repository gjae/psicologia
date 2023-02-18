@extends('adminlte::auth.auth-page', ['auth_type' => 'register'])
<style>
    .nav li{
        padding:10px;
    }
</style>
@php( $login_url = View::getSection('login_url') ?? config('adminlte.login_url', 'login') )
@php( $register_url = View::getSection('register_url') ?? config('adminlte.register_url', 'register') )

@php( $registerpsycho_url = View::getSection('registerpsycho_url') ?? config('adminlte.registerpsycho_url', 'registerpsychologist') )

@if (config('adminlte.use_route_url', false))
    @php( $login_url = $login_url ? route($login_url) : '' )
    @php( $register_url = $register_url ? route($register_url) : '' )
@else
    @php( $login_url = $login_url ? url($login_url) : '' )
    @php( $register_url = $register_url ? url($register_url) : '' )
@endif

@section('auth_header', __('adminlte::adminlte.register_message'))

@section('auth_body')


<ul class="nav nav-tabs" data-tabs="tabs">
	<li class="active"><a href="#pacientes" data-toggle="tab">Registro de Pacientes</a></li>
	<li><a href="#psicologo" data-toggle="tab">Registro de Psicólogos</a></li>
</ul>
<div class="tab-content">
<div id="pacientes" class="tab-pane active">
    <div class="card">
        <div class="card-body ">
            <h4>Registro de pacientes</h4>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="psicologos" role="tabpanel" aria-labelledby="home-tab">

                    <form action="{{ $register_url }}" method="post">
                        @csrf

                        {{-- Name field --}}
                        <div class="input-group mb-3">
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                value="{{ old('name') }}" placeholder="{{ __('adminlte::adminlte.full_name') }}" autofocus>

                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-user {{ config('adminlte.classes_auth_icon', '') }}"></span>
                                </div>
                            </div>

                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        {{-- lastName field --}}
                        <div class="input-group mb-3">
                            <input type="text" name="lastname" class="form-control @error('lastname') is-invalid @enderror"
                                value="{{ old('lastname') }}" placeholder="{{ __('adminlte::adminlte.lastname') }}" autofocus>

                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-user {{ config('adminlte.classes_auth_icon', '') }}"></span>
                                </div>
                            </div>

                            @error('lastname')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        {{-- Email field --}}

                        <div class="input-group mb-3">
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                value="{{ old('email') }}" placeholder="{{ __('adminlte::adminlte.email') }}">

                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-envelope {{ config('adminlte.classes_auth_icon', '') }}"></span>
                                </div>
                            </div>

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        {{-- Phone field --}}
                        <div class="input-group mb-3">
                            <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone') }}" placeholder="{{ __('adminlte::adminlte.phone') }}">

                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-lock {{ config('adminlte.classes_auth_icon', '') }}"></span>
                                </div>
                            </div>

                            @error('phone')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        {{-- Gender field --}}
                        <div class="input-group mb-3">
                            <input type="text" name="gender" class="form-control @error('gender') is-invalid @enderror" value="{{ old('gender') }}" placeholder="{{ __('adminlte::adminlte.gender') }}">

                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-lock {{ config('adminlte.classes_auth_icon', '') }}"></span>
                                </div>
                            </div>

                            @error('gender')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        {{-- Age field --}}
                        <div class="input-group mb-3">
                            <input type="text" name="age" class="form-control @error('age') is-invalid @enderror" value="{{ old('age') }}" placeholder="{{ __('adminlte::adminlte.age') }}" >

                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-lock {{ config('adminlte.classes_auth_icon', '') }}"></span>
                                </div>
                            </div>

                            @error('age')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        {{-- Password field --}}
                        <div class="input-group mb-3">
                            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                                placeholder="{{ __('adminlte::adminlte.password') }}">

                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-lock {{ config('adminlte.classes_auth_icon', '') }}"></span>
                                </div>
                            </div>

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        {{-- Confirm password field --}}
                        <div class="input-group mb-3">
                            <input type="password" name="password_confirmation"
                                class="form-control @error('password_confirmation') is-invalid @enderror"
                                placeholder="{{ __('adminlte::adminlte.retype_password') }}">

                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-lock {{ config('adminlte.classes_auth_icon', '') }}"></span>
                                </div>
                            </div>

                            @error('password_confirmation')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        {{-- Register button --}}
                        <button type="submit" class="btn btn-block {{ config('adminlte.classes_auth_btn', 'btn-flat btn-primary') }}">
                            <span class="fas fa-user-plus"></span>
                            {{ __('adminlte::adminlte.register') }}
                        </button>

                    </form>
                    </div>
                </div>
        </div>
    </div>
</div>
<div id="psicologo" class="tab-pane">

    <form action="{{ $registerpsycho_url }}" method="post">
        @csrf

    
    <div class="card-body ">
            <h4>Registro de psicólogos</h4>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="psicologos" role="tabpanel" aria-labelledby="home-tab">

                    <form action="{{ $registerpsycho_url }}" method="post">
                        @csrf

                        {{-- Name field --}}
                        <div class="input-group mb-3">
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                value="{{ old('name') }}" placeholder="{{ __('adminlte::adminlte.full_name') }}" autofocus>

                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-user {{ config('adminlte.classes_auth_icon', '') }}"></span>
                                </div>
                            </div>

                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        {{-- lastName field --}}
                        <div class="input-group mb-3">
                            <input type="text" name="lastname" class="form-control @error('lastname') is-invalid @enderror"
                                value="{{ old('lastname') }}" placeholder="{{ __('adminlte::adminlte.lastname') }}" autofocus>

                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-user {{ config('adminlte.classes_auth_icon', '') }}"></span>
                                </div>
                            </div>

                            @error('lastname')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        {{-- Email field --}}

                        <div class="input-group mb-3">
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                value="{{ old('email') }}" placeholder="{{ __('adminlte::adminlte.email') }}">

                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-envelope {{ config('adminlte.classes_auth_icon', '') }}"></span>
                                </div>
                            </div>

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        {{-- Phone field --}}
                        <div class="input-group mb-3">
                            <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone') }}" placeholder="{{ __('adminlte::adminlte.phone') }}">

                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-lock {{ config('adminlte.classes_auth_icon', '') }}"></span>
                                </div>
                            </div>

                            @error('phone')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        {{-- Gender field --}}
                        <div class="input-group mb-3">
                            <input type="text" name="gender" class="form-control @error('gender') is-invalid @enderror" value="{{ old('gender') }}" placeholder="{{ __('adminlte::adminlte.gender') }}">

                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-lock {{ config('adminlte.classes_auth_icon', '') }}"></span>
                                </div>
                            </div>

                            @error('gender')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        {{-- Age field --}}
                        <div class="input-group mb-3">
                            <input type="text" name="age" class="form-control @error('age') is-invalid @enderror" value="{{ old('age') }}" placeholder="{{ __('adminlte::adminlte.age') }}" >

                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-lock {{ config('adminlte.classes_auth_icon', '') }}"></span>
                                </div>
                            </div>

                            @error('age')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        {{-- Password field --}}
                        <div class="input-group mb-3">
                            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                                placeholder="{{ __('adminlte::adminlte.password') }}">

                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-lock {{ config('adminlte.classes_auth_icon', '') }}"></span>
                                </div>
                            </div>

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        {{-- Confirm password field --}}
                        <div class="input-group mb-3">
                            <input type="password" name="password_confirmation"
                                class="form-control @error('password_confirmation') is-invalid @enderror"
                                placeholder="{{ __('adminlte::adminlte.retype_password') }}">

                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-lock {{ config('adminlte.classes_auth_icon', '') }}"></span>
                                </div>
                            </div>

                            @error('password_confirmation')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        {{-- Register button --}}
                        <button type="submit" class="btn btn-block {{ config('adminlte.classes_auth_btn', 'btn-flat btn-primary') }}">
                            <span class="fas fa-user-plus"></span>
                            {{ __('adminlte::adminlte.register') }}
                        </button>

                    </form>
                    </div>
                </div>
    </div>
    </form>
</div>



@stop

@section('auth_footer')
    <p class="my-0">
        <a href="{{ $login_url }}">
            {{ __('adminlte::adminlte.i_already_have_a_membership') }}
        </a>
    </p>
@stop
