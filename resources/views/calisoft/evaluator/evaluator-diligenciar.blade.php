@extends('layouts.dash') @section('content')
<div class="col-md-12">
    @component('components.portlet', ['icon' => 'fa fa-users', 'title' => 'Llenar indicador', 'pdf' => route('pdf.usuarios')])


    <div id="app">
        
        <form @submit.prevent="store()" id="indicador-create" class="form-horizontal">
            <div v-for="pregunta  in preguntas" :key="pregunta.PK_id">
                <div class="form-group">
                    <label class="col-md-3 control-label" v-text="'Pregunta:'+ pregunta.pregunta">
                    </label>
                    <label class="col-md-9 control-label" v-text="'valores:'+ pregunta.respuesta">
                    </label>
                    <div class="col-md-12">
                        <input type="text"  class="form-control" name="respuesta" v-model="pruebas[pregunta.PK_id]"> 
                    </div>
                </div>
            </div>
            
            <div class="form-actions">
                    <div class="row">
                        <div class="col-md-offset-3 col-md-9">
                            <button type="submit" class="btn btn-circle green">Crear</button>
                        </div>
                    </div>
            </div>
        </form>
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
<script>window.indicadorId = {{ $indicador->PK_id }};</script>
<script>window.usuarioId = {{ $usuario->PK_id }};</script>
<script src="/js/diligenciar.js"></script>


@endpush