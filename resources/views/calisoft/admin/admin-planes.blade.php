@extends('layouts.dash') @section('content')
<div class="col-md-12">
    @component('components.portlet', ['icon' => 'fa fa-users', 'title' => 'Planes', 'pdf' => route('pdf.usuarios')])


    <div id="app">
        <div class="portlet-body form">
            <form @submit.prevent="store()" id="indicador-create" class="form-horizontal">
                <div class="form-group">
                    <label class="col-md-3 control-label">Umbral
                    </label>
                    <div class="col-md-9">
                        <input type="text" placeholder="Umbral del plan a crear" class="form-control" name="umbral" v-model="nuevoPlan.umbral"> 
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">Recomendación</label>
                    <div class="col-md-9">
                        <input type="text" placeholder="Recomendación del plan a crear" class="form-control" name="recomendacion" v-model="nuevoPlan.recomendacion"> 
                    </div>
                </div>
                <div class="form-group">
                    <label for="estado" class="control-label col-xs-4"></label>
                        <div class="col-xs-4 col-sm-5">
                            <select-input v-model="nuevoPlan.estado" name="estado" icon="fa fa-list" label="Estado" 
			                     selected="malo" 
			                    required>
                                <option value="malo">Malo</option>
                                <option value="regular">Regular</option>
                                <option value="excelente">Excelente</option>
                           </select-input>
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

            <div class="table-responsive">
            <table class="table table-hover table-bordered table-condensed">
                <thead>
                    <th class="text-center">Recomendación</th>
                    <th class="text-center">Umbral</th>
                    <th class="text-center">Estados</th>
                    <th class="text-center">Acciones</th>
                </thead>
                <tbody>
                    <tr v-for="plan in planes" class="text-center">
                        <td v-text="plan.recomendacion"></td>
                        <td v-text="plan.umbral"></td>
                        <td v-text="plan.estado"></td>
                        <td>
                            <button class="eliminar-indicador btn btn-danger" title="Eliminar Indicador" @click.prevent="destroy(plan)">
                                <span class="glyphicon glyphicon-trash"></span>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    

    
    @include('partials.modal-help-usuario') @endcomponent
   

</div>
@endsection @push('styles')



<script src="/assets/global/plugins/bootstrap-toastr/toastr.min.js"></script>


@endpush


@push('functions')



<script src="/assets/global/plugins/jquery-repeater/jquery.repeater.js"></script>
<script src="/assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/vue/1.0.14/vue.js"></script>
<script src="/assets/pages/scripts/form-repeater.min.js"></script>
<script src="/assets/pages/scripts/components-date-time-pickers.min.js" ></script>
<script>window.indicadorId = {{ $indicador->PK_id }};</script>
<script src="/js/planes.js"></script>



           
@endpush