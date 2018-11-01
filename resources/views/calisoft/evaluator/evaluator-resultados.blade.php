@extends('layouts.dash') @section('content')
<div class="col-md-12">
    @component('components.portlet', ['icon' => 'fa fa-users', 'title' => 'Resultados', 'pdf' => route('pdf.resultados', compact('usuario'))])


    <div id="app">
        <!-- Table -->
        <div class="table-responsive">
            <table class="table table-hover table-bordered table-condensed">
                <thead>
                    <th class="text-center">Indicador</th>
                    <th class="text-center" bgcolor="#a80303">Malo</th>
                    <th class="text-center" bgcolor="#969601">Regular</th>
                    <th class="text-center" bgcolor="#01960b">Excelente</th>
                    <th class="text-center" bgcolor="#0a5daa">Meta</th>
                    <th class="text-center">Resultado</th>
                    <th class="text-center">% indicador</th>
                    <th class="text-center">Plan Estratégico</th>
                </thead>
                <tbody>
                    <tr v-for="res in resultados" class="text-center">
                        <td v-text="res.nombreIndicador"></td>
                        <td v-text="res.malo" bgcolor="#a80303"></td>
                        <td v-text="res.regular" bgcolor="#969601"></td>
                        <td v-text="res.excelente" bgcolor="#01960b"></td>
                        <td v-text="res.metaIndicador" bgcolor="#0a5daa"></td>
                        <td v-text="res.respuestaUsuario" :bgcolor="res.color"></td>
                        <td v-text="(res.respuestaUsuario/res.metaIndicador)*100 + '%'"></td>
                        <td v-text="res.plan"></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <!-- End Table -->
    </div>
    @include('partials.modal-help-usuario') @endcomponent
</div>
@endsection @push('styles')
<link rel="stylesheet" href="/assets/global/plugins/bootstrap-toastr/toastr.min.css">
<link rel="stylesheet" href="/assets/global/plugins/bootstrap-select/css/bootstrap-select.min.css"> @endpush @push('functions')
<script src="{{ asset('assets/global/plugins/jquery-validation/js/jquery.validate.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/global/plugins/jquery-validation/js/additional-methods.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/global/plugins/jquery-validation/js/localization/messages_es.js') }}" type="text/javascript"></script>

<script src="{{ asset('assets/global/plugins/bootstrap-maxlength/bootstrap-maxlength.min.js') }}" type="text/javascript"></script>

<script src="/assets/global/plugins/bootstrap-select/js/bootstrap-select.min.js"></script>
<script src="/assets/global/plugins/bootstrap-toastr/toastr.min.js"></script>

<script>window.usuarioId = {{ $usuario->PK_id }};</script>
<script src="/js/resultados.js"></script>


@endpush