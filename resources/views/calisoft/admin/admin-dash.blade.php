@component('components.nav-link', [
    'icon' => 'fa fa-users',
    'title' => 'Usuarios',
    'link' => route('usuarios')
])
@endcomponent

@component('components.nav-link', [
    'icon' => 'fa fa-area-chart',
    'link' => route('indicadores'),
    'title' => 'Indicadores'
])
@endcomponent




