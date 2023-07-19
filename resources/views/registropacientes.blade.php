@extends('adminlte::page')



@section('content')
@can('registrar_pacientes')


@section('css')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">



<link rel="stylesheet" href="https://cdn.datatables.net/1.13.2/css/dataTables.bootstrap4.min.css">

@endsection



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

    <div class="card">
                <div class="card-header">
                    <h1 class="text-uppercase">Registro de pacientes</h1>
                </div>
                <div class="card-body ">

                    

                        <form class="formulario-ayuda" action="{{ route('registrar_pacientes_post') }}" method="post" >

                            @csrf



                            {{-- Name field --}}

                            <div class="input-group mb-3">
                                <input title="Introduce tu nombre" type="text" required name="name" class="form-control @error('name') is-invalid @enderror"

                                    value="{{ old('name') }}" placeholder="{{ __('adminlte::adminlte.full_name') }}" autofocus>



                                <div class="input-group-append">

                                    <div class="input-group-text">

                                        <span class="fas fa-user-circle {{ config('adminlte.classes_auth_icon', '') }}"></span>

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

                                <input title="Apellido" title="Introduce tu apellido" type="text" required name="lastname" class="form-control @error('lastname') is-invalid @enderror"

                                    value="{{ old('lastname') }}" placeholder="{{ __('adminlte::adminlte.lastname') }}" autofocus>



                                <div class="input-group-append">

                                    <div class="input-group-text">

                                        <span class="fas fa-user-circle {{ config('adminlte.classes_auth_icon', '') }}"></span>

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

                                <input title="Email" type="email" name="email" class="form-control @error('email') is-invalid @enderror"

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

                                <input title="Teléfono" type="text" required name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone') }}" placeholder="Teléfono">



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

                                <select title="Género" name="gender" id="gender" class="form-control @error('gender') is-invalid @enderror" value="{{ old('gender') }}">

                                <option disabled selected class="text-bold">--Indica tu Sexo--</option>


                                    <option value="H">Hombre</option>

                                    <option value="M">Mujer</option>

                                </select>



                                <div class="input-group-append">

                                    <div class="input-group-text">

                                        <span class="fas fa-venus-mars {{ config('adminlte.classes_auth_icon', '') }}"></span>

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

                                <input title="edad" type="text" required name="age" class="form-control @error('age') is-invalid @enderror" value="{{ old('age') }}" placeholder="Edad" >



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


                            {{-- Register button --}}

                            <button type="submit" class="btn btn-block {{ config('adminlte.classes_auth_btn', 'btn-flat btn-primary') }}" @click="activetab= uno" >

                                <span class="fas fa-user-plus"></span>

                                {{ __('adminlte::adminlte.register') }}

                            </button>

                        </form>

                </div>

            </div>
@endcan
@endsection

