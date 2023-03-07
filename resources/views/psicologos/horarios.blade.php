@extends('adminlte::page')

@section('content')

@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">

<link rel="stylesheet" href="https://cdn.datatables.net/1.13.2/css/dataTables.bootstrap4.min.css">
@endsection

<script>
    function horarios(){
        return {
            horario:'',
            buttonDisabled:false,
            registrarHorario(){
            Swal.fire({
            title: 'Está seguro??',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si'
            })
            .then((opt)=> {
                if (opt.isConfirmed) {
                fetch('{{route("registrar_horarios_post")}}', 
                {
			        method: 'POST',
			        headers: {
				        'Content-Type': 'application/json',
				        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
			        },
			        body: JSON.stringify(this.horario)
			    }).then(r => r.json())
			    .then((data) => {
                    if(data==1){
                        Swal.fire({
                        icon: 'success',
                        title: 'Listo!',
                        })
                        this.buttonDisabled= true;
                    }
                    if(data==0){
                        Swal.fire({
                        icon: 'error',
                        title: 'Algo salió mal',
                        text: 'Asegurate de haber colocado un horario'
                        })
                    }
                        
                })
                .catch((data)=> console.log('Error'))
                }
            });
            }
        }
    }
</script>
<body>

<div class="row" x-data="horarios()">
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h2>Registrar horarios</h2>
            </div>
            <div class="card-body">
               

                <form @submit.prevent="registrarHorario">
                    @csrf
                    <h3>En que horario prestarás servicio?</h3>
                    <div class="row">
                        <div class="col-lg-6">
                            <input type="time" class="form-control" x-model="horario" >
                        </div>
                        <div class="col-lg-6">
                            {{-- Register button --}}
                            <button type="submit" class="btn btn-block {{ config('adminlte.classes_auth_btn', 'btn-flat btn-primary') }}" :disabled="buttonDisabled">
                                <span class="fas fa-user-plus"></span>
                                Agregar horario
                            </button>
                        </div>
                    </div>
                
                    
                </form>
            </div>
        </div>
    </div>
</div>

<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>
@endsection
