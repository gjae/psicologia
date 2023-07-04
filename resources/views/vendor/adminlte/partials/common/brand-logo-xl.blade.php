@inject('layoutHelper', 'JeroenNoten\LaravelAdminLte\Helpers\LayoutHelper')

@php( $dashboard_url = View::getSection('dashboard_url') ?? config('adminlte.dashboard_url', 'home') )

@if (config('adminlte.use_route_url', false))
    @php( $dashboard_url = $dashboard_url ? route($dashboard_url) : '' )
@else
    @php( $dashboard_url = $dashboard_url ? url($dashboard_url) : '' )
@endif

<a href="{{ $dashboard_url }}"
    @if($layoutHelper->isLayoutTopnavEnabled())
        class="navbar-brand logo-switch {{ config('adminlte.classes_brand') }}"
    @else
        class="brand-link logo-switch {{ config('adminlte.classes_brand') }}"
    @endif>

    {{-- Small brand logo --}}
    <img src="{{ asset(config('adminlte.logo_img', 'vendor/adminlte/dist/img/AdminLTELogo.png')) }}"
         alt="{{ config('adminlte.logo_img_alt', 'AdminLTE') }}"
        
         style="opacity:.8" height="85">
    {{-- Brand text --}}
    <br>
    <img src="{{ asset(config('adminlte.logo_img2', 'vendor/adminlte/dist/img/cognitiva.png')) }}"
         alt="{{ config('adminlte.logo_img_alt', 'AdminLTE') }}"
          height="60"
         class="logo-cognitiva">
<!-- AQUI ESTA EL LOGO DE COGNITIVA EN EL SIDEBAR DE ADMINLTE  esto es en brand-logo-xl-->

</a>
