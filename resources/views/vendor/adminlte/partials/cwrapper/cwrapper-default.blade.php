@inject('layoutHelper', 'JeroenNoten\LaravelAdminLte\Helpers\LayoutHelper')
<style>
    .nav li{
        padding:10px;
    }
    .content-wrapper{
        
        background-image: url("../public/images/terapista.jpg");
        background-repeat: no-repeat;
            background-size: cover;
        background-position: center ;
        justify-content: flex-start !important;
        padding-top: 20px;
    }
    .container-fluid{
        padding-top:20px;
    }
</style>

@if($layoutHelper->isLayoutTopnavEnabled())
    @php( $def_container_class = 'container' )
@else
    @php( $def_container_class = 'container-fluid' )
@endif

{{-- Default Content Wrapper --}}
@if(auth()->user()->hasRole('paciente'))
<body style="background-image: url('../public/images/terapista.jpg');background-repeat: no-repeat;
            background-size: cover;
        background-position: center ;
        justify-content: flex-start !important;
        height:100%;">
    
<div class="container-fluid">
@else
<div class="content-wrapper  {{ config('adminlte.classes_content_wrapper', '') }}">

@endif

    {{-- Content Header --}}
    @hasSection('content_header')
        <div class="content-header">
            <div class="{{ config('adminlte.classes_content_header') ?: $def_container_class }}">
                @yield('content_header')
            </div>
        </div>
    @endif

    {{-- Main Content --}}
    <div class="container">
        <div class="{{ config('adminlte.classes_content') ?: $def_container_class }}">
            @yield('content')

        </div>
    </div>

</div>
</body>