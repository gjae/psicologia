@extends('adminlte::auth.auth-page', ['auth_type' => 'register'])
<style>
    .nav li{
        padding:10px;
    }
    .register-page{
        
        background-image: url("../public/images/terapista.jpg");
        background-repeat: no-repeat;
            background-size: cover;
        background-position: center ;
        justify-content: flex-start !important;
    }
</style>
<script>
    function registro(){
        return {
            activetab:'',
            tipo_terapias:[],
            terapias(){
                
                fetch('{{route("terapias")}}')
                    .then(r => r.json())
                    .then(
                        (data) => {
                            this.tipo_terapias = data
                            console.log(this.tipo_terapias)
                        }
                    )
            }
        }
    }
</script>
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



<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <center>
                @if(session()->has('error'))
                    <div class="alert alert-danger">
                        {{ session()->get('error') }}
                    </div>
                @endif
            </center>
        </div>
    </div>
    @section('auth_body')
    <ul class="nav nav-tabs" data-tabs="tabs">
        <li ><a href="#pacientes" data-toggle="tab">Registro de Pacientes</a></li>
        <li ><a href="#psicologo" data-toggle="tab">Registro de Psicólogos</a></li>
    </ul>
    
    <div class="tab-content" x-data="registro()" x-init="terapias()">
        <div id="pacientes" class="tab-pane active" >
            <div class="card">
                <div class="card-body ">
                    <h4>Registro de pacientes</h4>
                        <form action="{{ $register_url }}" method="post" >
                            @csrf

                            {{-- Name field --}}
                            <div class="input-group mb-3">
                                <input type="text" required name="name" class="form-control @error('name') is-invalid @enderror"
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
                                <input type="text" required name="lastname" class="form-control @error('lastname') is-invalid @enderror"
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
                                <input type="text" required name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone') }}" placeholder="{{ __('adminlte::adminlte.phone') }}">

                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-phone {{ config('adminlte.classes_auth_icon', '') }}"></span>
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
                                <select name="gender" id="gender" class="form-control @error('gender') is-invalid @enderror" value="{{ old('gender') }}">
                                    <option value="H">H</option>
                                    <option value="M">M</option>
                                </select>

                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-genderless {{ config('adminlte.classes_auth_icon', '') }}"></span>
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
                                <input type="text" required name="age" class="form-control @error('age') is-invalid @enderror" value="{{ old('age') }}" placeholder="{{ __('adminlte::adminlte.age') }}" >

                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-user {{ config('adminlte.classes_auth_icon', '') }}"></span>
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
                            <button type="submit" class="btn btn-block {{ config('adminlte.classes_auth_btn', 'btn-flat btn-primary') }}" @click="activetab= uno" >
                                <span class="fas fa-user-plus"></span>
                                {{ __('adminlte::adminlte.register') }}
                            </button>

                        </form>
                </div>
            </div>
        </div>

        <div id="psicologo" class="tab-pane " x-bind:class="{'active': activetab== 'dos'}">
            <form action="{{ $registerpsycho_url }}" method="post" enctype="multipart/form-data" >
                @csrf
                <div class="card">
                    <div class="card-body">
                        <h4>Registro de psicólogos</h4>
                        
                                {{-- Name field --}}
                                <div class="input-group mb-3">
                                    <input  required type="text"  name="name" class="form-control @error('name') is-invalid @enderror"
                                        value="{{ old('name') }}" placeholder="{{ __('adminlte::adminlte.full_name') }}" autofocus accept="image/*">

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
                                    <input  required type="text"  name="lastname" class="form-control @error('lastname') is-invalid @enderror"
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

                                {{-- Age field --}}
                                <div class="input-group mb-3">
                                    <input  required type="text"  name="age" class="form-control @error('age') is-invalid @enderror"
                                        value="{{ old('age') }}" placeholder="Edad" autofocus>

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
                                    <input  required type="email"  name="email" class="form-control @error('email') is-invalid @enderror"
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

                                {{-- Therapy --}}
                                <div class="input-group mb-3">



                                    <select name="therapy_id" id="" class="form-control @error('therapy_id') is-invalid @enderror" value="{{ old('therapy_id') }}">
                                        <template x-for="terapia in tipo_terapias" :key="terapia.id">
                                            <option :value="terapia.id" x-text="terapia.therapy_type"></option>
                                        </template>
                                    </select>

                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <span class="fas fa-book {{ config('adminlte.classes_auth_icon', '') }}"></span>
                                        </div>
                                    </div>

                                    @error('therapy')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                {{-- Personal phone field --}}
                                <div class="input-group mb-3">
                                    <input  required type="text"  name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone') }}" placeholder="Teléfono personal">

                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <span class="fas fa-phone {{ config('adminlte.classes_auth_icon', '') }}"></span>
                                        </div>
                                    </div>

                                    @error('personal_phone')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                {{-- Bussiness phone field --}}
                                <div class="input-group mb-3">
                                    <input  required type="text"  name="bussiness_phone" class="form-control @error('bussiness_phone') is-invalid @enderror" value="{{ old('bussiness_phone') }}" placeholder="Teléfono de empresa">

                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <span class="fas fa-phone {{ config('adminlte.classes_auth_icon', '') }}"></span>
                                        </div>
                                    </div>

                                    @error('bussiness_phone')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                {{-- Gender field --}}
                                <div class="input-group mb-3">
                                    <select  name="gender" id="gender" class="form-control @error('gender') is-invalid @enderror" value="{{ old('gender') }}">
                                        <option value="H">H</option>
                                        <option value="M">M</option>
                                    </select>

                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <span class="fas fa-genderless {{ config('adminlte.classes_auth_icon', '') }}"></span>
                                        </div>
                                    </div>

                                    @error('gender')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                {{-- Specialty field --}}
                                <div class="input-group mb-3">
                                    <input  required type="text"  name="specialty" class="form-control @error('specialty') is-invalid @enderror" value="{{ old('specialty') }}" placeholder="Especialidad" >

                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <span class="fas fa-lock {{ config('adminlte.classes_auth_icon', '') }}"></span>
                                        </div>
                                    </div>

                                    @error('specialty')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                {{-- Photo field--}}
                                <div class="input-group mb-3">
                                    <label for="photo">Cargue una foto</label>
                                    <input  required type="file"  name="photo" class="form-control @error('photo') is-invalid @enderror" value="{{ old('photo') }}">

                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <span class="fas fa-image {{ config('adminlte.classes_auth_icon', '') }}"></span>
                                        </div>
                                    </div>

                                    @error('photo')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                {{-- Password field --}}
                                <div class="input-group mb-3">
                                    <input  required type="password"  name="password" class="form-control @error('password') is-invalid @enderror"
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
                                    <input  required type="password"  name="password_confirmation"
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
                                <button type="submit" class="btn btn-block {{ config('adminlte.classes_auth_btn', 'btn-flat btn-primary') }}" @click="activetab= dos">
                                    <span class="fas fa-user-plus"></span>
                                    {{ __('adminlte::adminlte.register') }}
                                </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@stop

@section('auth_footer')
    <p class="my-0">
        <a href="{{ $login_url }}">
            {{ __('adminlte::adminlte.i_already_have_a_membership') }}
        </a>
    </p>
@stop
