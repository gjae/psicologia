@extends('adminlte::page')
@can('actualizarinfo')
@section('css')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">


<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<link rel="stylesheet" href="https://cdn.datatables.net/1.13.2/css/dataTables.bootstrap4.min.css">

@endsection

<script>

    function actualizar(){
        const baseUrl = "{{ url('/') }}";
        return {
            tipos_terapias:[],
            availableTherapies:[],
            availableProblems:[],
            items: [],
            problemas_tratados_actualmente:[],
            nuevos_tipos_de_terapia:[], 
            nuevos_tipos_de_problema:[],
            lista_problema(){
                fetch('{{route("terapias")}}')
                    .then(r => r.json())
                    .then(
                        (data) => {
                            this.tipos_terapias = data
                            
                        }
                    )
            },
            toggleTipoTerapia(terapia) {
                terapia.selected = !terapia.selected;

                if (terapia.selected) {
                // Habilitar los checkboxes de los tipos de problema relacionados
                terapia.treat_problem.forEach((tipo_problema) => {
                    tipo_problema.disabled = false;
                });
                } else {
                // Deshabilitar los checkboxes de los tipos de problema relacionados
                terapia.treat_problem.forEach((tipo_problema) => {
                    tipo_problema.disabled = true;
                });
                }
            },
            tipos_de_terapia(user_id){
                fetch(`${baseUrl}/tipos_terapia_current_user/${user_id}`).
                then(r => r.json())
                .then((data)=> {
                    //this.problemas_tratados_actualmente= data.currentTherapies[0].problems_treated
                    this.items= data.currentTherapies
                    this.availableTherapies= data.availableTherapies
                    console.log(this.items)
                    this.availableProblems= data.availableProblems
                }).catch()
            },
            deletetherapies(id){
                fetch(`${baseUrl}/delete_therapies/${id}`).then(
                    
                ).catch()
            },
            deleteproblems(id, idproblema){
                fetch(`${baseUrl}/delete_problems/${id}/${idproblema}`).then(
                    (resp)=>{
                        alert("se hizo");
                    }
                    
                    ).catch()
            },
            
            eliminarElemento(id) {
                this.listaElementos = this.listaElementos.filter(elemento => elemento.id !== id);
            },
            formData:{
                nombre:'',
                apellido:'',
                email:'',
                personal_phone:'',
                bussiness_phone:'',
                bio:'',
                password:''

            }
        }
    }
</script>


@section('content')


@if(Session::has('success'))
    <div class="alert alert-success">
        {{ Session::get('success') }}
    </div>
@endif

<h1>Mi cuenta</h1>
<div x-data="actualizar" >
    <form method="post" action="{{url('update_info', ['psicologo' => Auth::user()->id])}}" enctype="multipart/form-data" >
        @csrf
        @method('POST')
        <div class="card">
            <div class="card-header">
                <h2>Información personal</h2>
            </div>
            <div class="card-body">
                <div class="input-group">
                    <div class="col-md-4 mb-3">
                        <label for="">Nombre</label>
                    </div>
                    
                    <div class="col-md-7 mb-3">
                        <input title="nombre" type="text" required name="nombre" class="form-control @error('nombre') is-invalid @enderror" value="{{$psicologo->personalInfo->name}}">

                        @error('nombre')

                            <span class="invalid-feedback" role="alert">

                                <strong>{{ $message }}</strong>

                            </span>

                        @enderror
                    </div>
                </div>

                <div class="input-group">
                    <div class="col-md-4 mb-3">
                        
                        <label for="">Apellido</label>
                    </div>
                    
                    <div class="col-md-7 mb-3">
                        <input title="apellido" type="text" required name="apellido" class="form-control @error('apellido') is-invalid @enderror" value="{{$psicologo->personalInfo->lastname}}">

                        @error('apellido')

                            <span class="invalid-feedback" role="alert">

                                <strong>{{ $message }}</strong>

                            </span>

                        @enderror
                    </div>
                </div>

                <div class="input-group">
                    <div class="col-md-4 mb-3">
                        
                        <label for="">Género</label>
                    </div>
                    
                    <div class="col-md-7 mb-3">
                        <select title="Género" name="gender" id="gender" class="form-control @error('gender') is-invalid @enderror" value="{{ old('gender') }}" required>

                                <option disabled selected class="text-bold">--Indica tu Sexo--</option>


                                    <option value="H">Hombre</option>

                                    <option value="M">Mujer</option>

                                </select>

                        @error('gender')

                            <span class="invalid-feedback" role="alert">

                                <strong>{{ $message }}</strong>

                            </span>

                        @enderror
                    </div>
                </div>

                <div class="input-group">
                    <div class="col-md-4 mb-3">
                        
                        <label for="">Email</label>
                    </div>
                    
                    <div class="col-md-7 mb-3">
                        <input  title="email" type="text" required name="email" class="form-control @error('email') is-invalid @enderror" value="{{$psicologo->personalInfo->email}}">

                        @error('email')

                            <span class="invalid-feedback" role="alert">

                                <strong>{{ $message }}</strong>

                            </span>

                        @enderror
                    </div>
                </div>

                <div class="input-group">
                    <div class="col-md-4 mb-3">
                        
                        <label for="">Teléfono personal</label>
                    </div>
                    
                    <div class="col-md-7 mb-3">
                        <input title="personal_phone" type="text" required name="personal_phone" class="form-control @error('personal_phone') is-invalid @enderror" value="{{$psicologo->personal_phone}}">

                        @error('personal_phone')

                            <span class="invalid-feedback" role="alert">

                                <strong>{{ $message }}</strong>

                            </span>

                        @enderror
                    </div>
                </div>

                <div class="input-group">
                    <div class="col-md-4 mb-3">
                        
                        <label for="">Teléfono de oficina</label>
                    </div>
                    
                    <div class="col-md-7 mb-3">
                        <input  title="bussiness_phone" type="text" required name="bussiness_phone" class="form-control @error('bussinesss_phone') is-invalid @enderror" value="{{$psicologo->bussiness_phone}}">

                        @error('bussinesss_phone')

                            <span class="invalid-feedback" role="alert">

                                <strong>{{ $message }}</strong>

                            </span>

                        @enderror
                    </div>
                </div>

                <div class="input-group">
                    <div class="col-md-4 mb-3">
                        
                        <label for="">BIO</label>
                    </div>
                    
                    <div class="col-md-7 mb-3">
                        <input  title="bio" type="text" required name="bio" maxlength="200" class="form-control @error('bio') is-invalid @enderror" value="{{$psicologo->bio}}">

                        @error('bio')

                            <span class="invalid-feedback" role="alert">

                                <strong>{{ $message }}</strong>

                            </span>

                        @enderror
                    </div>
                </div>
            </div>
        </div>
            
        <div class="card">
            <div class="card-header">
                <h2>Consulta</h2>
            </div>
            <div class="card-body">
                <div>
                        <h4>Días y horarios de atención</h4>
                    
                    
                        @foreach($psicologo->worksAtHours as $index=> $schedule)
                        <div>
                                <h4>{{$schedule->dia}}</h4>
                                <input type="hidden" name="horarios[{{$index}}][dia_schedule]" value="{{$schedule->id}}">
                                <select name="horarios[{{$index}}][dia]" id="" class="form-control">
                                    <option value="seleccione"> -dia- </option>
                                    <option value="Lunes">Lunes</option>
                                    <option value="Martes">Martes</option>
                                    <option value="Miércoles">Miércoles</option>
                                    <option value="Jueves">Jueves</option>
                                    <option value="Viernes">Viernes</option>
                                    <option value="Sábado">Sábado</option>
                                </select>
                                <h4>{{$schedule->schedule}}</h4>
                                <select name="horarios[{{$index}}][inicio]" id="" class="form-control">
                                    <option value="hora_de_inicio">- Hora -</option>
                                    <option value="10">10</option>
                                    <option value="11">11</option>
                                    <option value="12">12</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                    <option value="6">6</option>
                                    <option value="7">7</option>
                                    <option value="8">8</option>
                                    <option value="9">9</option>
                                </select>

                                <select name="horarios[{{$index}}][meridiem]" class="form-control" id="">
                                    <option value="meridiem_de_inicio">- AM - PM -</option>
                                    <option value="AM">AM</option>
                                    <option value="PM">PM</option>
                                </select>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="card p-4">
            <div class="card-header">
                <h2>Tipos de terapia y tipos de problema</h2>
            </div>
            <div class="row"><!-- Cambiar foto de perfil-->
                <div class="col-md-7 mb-3 body-card " x-init="lista_problema,tipos_de_terapia({{Auth::user()->isPsychologist->id}})">
                    <h4>Eliminar tipos de terapia ofrecidos actualmente</h4>
                    <template x-for="item in items" :key="item.id">
                        <div class="card p-3">
                            <div>
                                <h2 x-text="item.therapy.therapy_type"></h2>

                                <template x-for="iteracion_array_problemas in item.problems_treated" :key="iteracion_array_problemas.id">
                                    <div>
                                        <template x-for="nombre_problema in iteracion_array_problemas.problems" :key="nombre_problema.id">
                                            <div>
                                                <span x-text="nombre_problema.problem"></span>
                                                <button @click="deleteproblems(iteracion_array_problemas.id,nombre_problema.id)" class="btn btn-danger"> <i class="fa fa-solid fa-trash"></i> Eliminar</button>
                                            </div>
                                        </template>
                                    </div>
                                </template>
                            </div>
                            <button @click="items = items.filter(i => i.id !== item.id), deletetherapies(item.id)" class="btn btn-danger"> <i class="fa fa-solid fa-trash"></i> Eliminar</button>
                        </div>
                    </template>
                </div>
            </div>

            
            <template x-for="terapia in availableTherapies" :key="terapia.id">
                <div class="checkboxesterapia">
                    <h2 x-text="terapia.therapy_type"></h2> 
                    <input type="checkbox" :value="terapia.id" name="nuevos_tipos_de_terapia[]"  @click="toggleTipoTerapia(terapia)">
                    
                    

                    <template x-for="problema_tratado in availableProblems" :key="problema_tratado.id">
                        <div x-show="problema_tratado.id_therapy == terapia.id">
                            <input type="checkbox" class="form-control" :value="problema_tratado.id" name="nuevos_tipos_de_problema[]" x-bind:disabled="!terapia.selected">
                            <h5 x-text="problema_tratado.problem"></h5>
                        </div>
                    </template>
                </div>
            </template>
        </div>
            
        <div class="card">
            <div class="card-header">
                <h2>Configuraciones</h2>
            </div>
            <div class="card-body">
                <div class="input-group"><!-- Campo contraseña-->
                    <div class="col-md-4 mb-3">
                        
                        <label for="">Cambiar contraseña</label>
                    </div>
                    
                    <div class="col-md-7 mb-3">
                        <input type="hidden" name="contrasena_original" value="{{ $psicologo->personalInfo->password}}">
                        <input title="password" type="password" name="password" value="{{ $psicologo->personalInfo->password}}" class="form-control @error('password') is-invalid @enderror">

                        @error('password')

                            <span class="invalid-feedback" role="alert">

                                <strong>{{ $message }}</strong>

                            </span>

                        @enderror
                    </div>
                </div>

                <div class="input-group"><!-- Cambiar foto de perfil-->
                    <div class="col-md-4 mb-3">
                        <label for="">Cambiar foto de perfil</label>
                    </div>
                    
                    <div class="col-md-7 mb-3">
                        <img src="{{ asset($psicologo->photo) }}" class="img-circle" alt="" height="52" width="52">
                        <input type="hidden" value="{{ asset($psicologo->photo) }}" name="old_pic">
                        <input title="Carga una foto" type="file" name="photo" class="form-control @error('photo') is-invalid @enderror" value="{{ asset($psicologo->photo) }}">

                        @error('photo')

                            <span class="invalid-feedback" role="alert">

                                <strong>{{ $message }}</strong>

                            </span>

                        @enderror
                    </div>
                </div>
            </div>
        </div>

        
        <button type="submit" class="btn btn-block {{ config('adminlte.classes_auth_btn', 'btn-flat btn-primary') }}">

            <i class="fa fa-refresh" aria-hidden="true"></i>

            Actualizar información

        </button>
        
    </form>
</div>

@endcan
@endsection