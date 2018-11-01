@extends('layouts.dash')

@section('content')
    <div class="col-md-12">
        @component('components.portlet', [
                'icon' => 'fa fa-database', 
                'title' => 'Evaluacion de Base de Datos', 
                'pdf' => route('pdf.basedatos', compact('proyecto'))
        ])

        <div id="app" class="row">
        <button type="button"  class="btn green-jungle center-block">
                                    <i class="fa fa-arrow-circle-right"></i>
                                    Ver Resultados Calificados
                                </button><br>
            <div class="col-md-1"></div>
            <div class="col-md-10">
                <tabla-componente :read="true"></tabla-componente>  
            </div>
            <div class="col-md-1"></div>                           
        </div>

        @endcomponent
    </div>
@endsection
@push('functions')
    <script>window.archivoId = "{{ $proyecto->sql->PK_id }}"</script>
    <script src="/assets/global/plugins/jquery.media.js"></script>
    <script src="/js/base-datos.js"></script>
@endpush