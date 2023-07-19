<!DOCTYPE html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">



<head>

    {{-- Base Meta Tags --}}

    <meta charset="utf-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">
<script type="text/javascript">window.localStorage.setItem('logueado', true);</script>


    <script type="text/javascript">


    window.addEventListener('storage', storageChange, false);
    function storageChange (event) {
        console.log(event);
        if(event.key === 'logueado' && event.newValue ==='false'){
            window.location.href="/login";
        }
        /*
        if(localStorage.logeado=="false"){
            window.location.replace("/login"); 
        }else
            window.location.reload(true); */
      }

</script>

    

    

   <!--  <link rel="shortcut icon" type="image/png" href="{{ asset('/images/logo.png') }}">

    <link rel="shortcut icon" sizes="192x192" href="{{ asset('/images/logo.png') }}"> -->

    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

       <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
      
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.2/moment.min.js"></script>

<link rel="stylesheet" href="https://cdn.datatables.net/1.13.2/css/dataTables.bootstrap4.min.css">

<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script src="{{asset('assets/js/reservadecita.js')}}" ></script>
    {{-- Custom Meta Tags --}}

    @yield('meta_tags')



    {{-- Title --}}

    <title>

        @yield('title_prefix', config('adminlte.title_prefix', ''))

        @yield('title', config('adminlte.title', 'AdminLTE 3'))

        @yield('title_postfix', config('adminlte.title_postfix', ''))

    </title>

    <style>

        /* .nav-sidebar li a p,i{

            color:##e9efff;

            font-size:1.6em;

        } 

        .navbar {

            margin-bottom:0px;

        }

 */

       

    </style>



    {{-- Custom stylesheets (pre AdminLTE) --}}

    @yield('adminlte_css_pre')



    {{-- Base Stylesheets --}}

    @if(!config('adminlte.enabled_laravel_mix'))

        <link rel="stylesheet" href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}">

        <link rel="stylesheet" href="{{ asset('vendor/overlayScrollbars/css/OverlayScrollbars.min.css') }}">

        <link rel="stylesheet" href="{{ asset('vendor/adminlte/dist/css/adminlte.min.css') }}">



        @if(config('adminlte.google_fonts.allowed', true))

            <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

        @endif

    @else

        <link rel="stylesheet" href="{{ mix(config('adminlte.laravel_mix_css_path', 'css/app.css')) }}">

    @endif



    {{-- Extra Configured Plugins Stylesheets --}}

    @include('adminlte::plugins', ['type' => 'css'])



    {{-- Livewire Styles --}}

    @if(config('adminlte.livewire'))

        @if(app()->version() >= 7)

            @livewireStyles

        @else

            <livewire:styles />

        @endif

    @endif



    {{-- Custom Stylesheets (post AdminLTE) --}}

    @yield('adminlte_css')



    {{-- Favicon --}}

    @if(config('adminlte.use_ico_only'))

        <link rel="shortcut icon" href="{{ asset('vendor/favicons/favicon.ico') }}" />

    @elseif(config('adminlte.use_full_favicon'))

        <link rel="shortcut icon" href="{{ asset('vendor/favicons/favicon.ico') }}" />

        <link rel="apple-touch-icon" sizes="57x57" href="{{ asset('vendor/favicons/apple-icon-57x57.png') }}">

        <link rel="apple-touch-icon" sizes="60x60" href="{{ asset('vendor/favicons/apple-icon-60x60.png') }}">

        <link rel="apple-touch-icon" sizes="72x72" href="{{ asset('vendor/favicons/apple-icon-72x72.png') }}">

        <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('vendor/favicons/apple-icon-76x76.png') }}">

        <link rel="apple-touch-icon" sizes="114x114" href="{{ asset('vendor/favicons/apple-icon-114x114.png') }}">

        <link rel="apple-touch-icon" sizes="120x120" href="{{ asset('vendor/favicons/apple-icon-120x120.png') }}">

        <link rel="apple-touch-icon" sizes="144x144" href="{{ asset('vendor/favicons/apple-icon-144x144.png') }}">

        <link rel="apple-touch-icon" sizes="152x152" href="{{ asset('vendor/favicons/apple-icon-152x152.png') }}">

        <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('vendor/favicons/apple-icon-180x180.png') }}">

        <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('vendor/favicons/favicon-16x16.png') }}">

        <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('vendor/favicons/favicon-32x32.png') }}">

        <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('vendor/favicons/favicon-96x96.png') }}">

        <link rel="icon" type="image/png" sizes="192x192"  href="{{ asset('vendor/favicons/android-icon-192x192.png') }}">

        <link rel="manifest" crossorigin="use-credentials" href="{{ asset('vendor/favicons/manifest.json') }}">

        <meta name="msapplication-TileColor" content="#ffffff">

        <meta name="msapplication-TileImage" content="{{ asset('vendor/favicon/ms-icon-144x144.png') }}">

    @endif

    

    <!-- estilo pablo  -->

    <link rel="stylesheet" href="{{ asset('vendor/pablo/style.css') }}">

</head>



<body class="@yield('classes_body')" @yield('body_data')>



    {{-- Body Content --}}

    @yield('body')



    {{-- Base Scripts --}}

    @if(!config('adminlte.enabled_laravel_mix'))

        <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>

        <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

        <script src="{{ asset('vendor/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>

        <script src="{{ asset('vendor/adminlte/dist/js/adminlte.min.js') }}"></script>

    @else

        <script src="{{ mix(config('adminlte.laravel_mix_js_path', 'js/app.js')) }}"></script>

    @endif



    {{-- Extra Configured Plugins Scripts --}}

    @include('adminlte::plugins', ['type' => 'js'])



    {{-- Livewire Script --}}

    @if(config('adminlte.livewire'))

        @if(app()->version() >= 7)

            @livewireScripts

        @else

            <livewire:scripts />

        @endif

    @endif



    {{-- Custom Scripts --}}

    @yield('adminlte_js')





</body>



</html>

