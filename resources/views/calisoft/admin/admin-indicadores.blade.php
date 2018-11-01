@extends('layouts.dash') @section('content')
<div class="col-md-12">
    @component('components.portlet', ['icon' => 'fa fa-users', 'title' => 'Indicadores', 'pdf' => route('pdf.usuarios')])


    <div id="app">
        <div class="portlet-body form">
            <form @submit.prevent="store()" id="indicador-create" class="form-horizontal">
                <div class="form-group">
                    <label class="col-md-3 control-label">Nombre del indicador
                    </label>
                    <div class="col-md-9">
                        <input type="text" placeholder="Nombre del indicador a crear" class="form-control" name="nombreIndicador" v-model="nuevoIndicador.nombre"> 
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">Respuestas pósitivas</label>
                    <div class="col-md-9">
                        <div class="md-radio-inline">
                            <div class="md-radio">
                                <input type="radio" id="menor" name="radio1" class="md-radiobtn" value="menor" v-model="nuevoIndicador.limite">
                                <label for="menor">
                                    <span></span>
                                    <span class="check"></span>
                                    <span class="box"></span> Menor que la meta 
                                </label>
                            </div>
                            <div class="md-radio has-warning">
                                <input type="radio" id="mayor" name="radio1" class="md-radiobtn" value="mayor"  v-model="nuevoIndicador.limite">
                                <label for="mayor">
                                    <span></span>
                                    <span class="check"></span>
                                    <span class="box"></span> Mayor que la meta 
                                </label>
                            </div>
                        </div> 
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">Meta indicador</label>
                    <div class="col-md-9">
                        <input type="text" placeholder="150" class="form-control" name="metaIndicador" v-model="nuevoIndicador.meta"> 
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">Tipo indicador</label>
                    <div class="col-md-9">
                        <div class="md-radio-inline">
                            <div class="md-radio">
                                <input type="radio" id="cuantitativo" name="radio2" class="md-radiobtn" value="cuantitativo" v-model="nuevoIndicador.tipo">
                                <label for="cuantitativo">
                                    <span></span>
                                    <span class="check"></span>
                                    <span class="box"></span> Cuantitativo 
                                </label>
                            </div>
                            <div class="md-radio has-warning">
                                <input type="radio" id="cualitativo" name="radio2" class="md-radiobtn" value="cualitativo"  v-model="nuevoIndicador.tipo">
                                <label for="cualitativo">
                                    <span></span>
                                    <span class="check"></span>
                                    <span class="box"></span> Cualitativo 
                                </label>
                            </div>
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

            <div class="table-responsive">
            <table class="table table-hover table-bordered table-condensed">
                <thead>
                    <th class="text-center">Nombre</th>
                    <th class="text-center">Tipo</th>
                    <th class="text-center">Meta</th>
                    <th class="text-center">Resultado +</th>
                    <th class="text-center">Operación</th>
                </thead>
                <tbody>
                    <tr v-for="indi in indicadores" class="text-center">
                        <td v-text="indi.nombreIndicador"></td>
                        <td v-text="indi.tipo"></td>
                        <td v-text="indi.metaIndicador"></td>
                        <td v-text="'El resultado debe ser '+indi.limite+' a la meta'" ></td>
                        <td>
                            <button class="agregar-preguntas btn btn-success" title="Agregar preguntas" @click.prevent="openPreguntasModal(indi)">
                                <span class="glyphicon glyphicon-plus"></span>
                            </button>

                            <button class="eliminar-indicador btn btn-danger" title="Eliminar Indicador" @click.prevent="destroy(indi)">
                                <span class="glyphicon glyphicon-trash"></span>
                            </button>
                            <a class="agregar-preguntas btn btn-list" title="Plan de mejoramiento" :href="`/indicadores/${indi.PK_id}/planes`">
                                <span class="glyphicon glyphicon-plus"></span>
                            </a>
                            
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <modal id="modal-preguntas" :title="'Preguntas para el indicador: '+fillIndicador.nombreIndicador"> 
        <form @submit.prevent="storeQuestion(fillIndicador)" id="pregunta-create" class="form-horizontal">
            <div class="form-group">
                <label class="col-md-3 control-label">Pregunta</label>
                <div class="col-md-9">
                    <textarea class="form-control" rows="3" placeholder="Digitar pregunta para el indicador" v-model="nuevaPregunta.pregunta" ></textarea>
                </div>
            </div>
            <div class="form-group">
                <label  v-if="fillIndicador.tipo == 'cualitativo'" class="col-md-3 control-label">Respuesta</label>
                <div class="col-md-9">
                    <div class="mt-repeater" v-if="fillIndicador.tipo == 'cualitativo'">
                        <div  v-for="(val, index) in valores">
                            <div  class="row">
                                <div class="col-md-7">
                                    <label class="control-label">Nombre</label>
                                    <input type="text" placeholder="Bueno, Malo, Regular, más de 10, etc." class="form-control" v-model="val.respuesta"> 
                                </div>
                                <div class="col-md-3"> 
                                    <label class="control-label">Valor</label> 
                                    <input type="text" placeholder="3" class="form-control" v-model="val.valor">  
                                </div> 
                                <div class="col-md-1">
                                    <label class="control-label">&nbsp;</label>
                                    <a href="#" v-on:click.prevent="removeItem(index)" class="btn btn-danger">
                                        <i class="fa fa-close"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <a @click="AddField" data-repeater-create="" class="btn btn-info mt-repeater-add">
                            <i class="fa fa-plus"></i>Agregar otra respuesta
                        </a>
                        <br>
                        <br> 
                    </div>

                    <div class="mt-repeater" v-else>
                        <div>
                            <div  class="row">
                                <div v-if="fillIndicador.tipo == 'cualitativo'" class="col-md-12">
                                    <label class="control-label">Valor</label>
                                    <input type="text" placeholder="3" class="form-control" > 
                                </div>
                            </div>
                        </div>
                        <br>
                        <br> 
                    </div>


                    <button  type="submit" class="btn green-jungle">
                        <i class="glyphicon glyphicon-plus"></i>Crear pregunta
                    </button>
        
                <button type="button" class="btn red" data-dismiss="modal">
                        <i class="fa fa-ban"></i>Cancelar
                    </button>
                </div>
            </div>
            <div class="modal-footer">               
                <!-- Table -->
                <div class="table-responsive">
                    <table class="table table-hover table-bordered table-condensed">
                        <thead>
                            <th class="text-center">Pregunta</th>
                            <th class="text-center">Respuestas</th>
                            <th class="text-center">Acciones</th>
                        </thead>
                        <tbody>
                                <tr v-for="pre in preguntas" class="text-center">
                                <td v-text="pre.pregunta"></td>
                                <td v-text="pre.respuesta"></td>
                                <td>
                                    <button class="editar-modal btn btn-danger" title="Eliminar pregunta" @click.prevent="destroyPre(pre)">
                                        <span class="glyphicon glyphicon-trash"></span>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <!-- End Table -->
            </div>
        </form>
    </modal>
        
    
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
<script src="/js/indicadores.js"></script>



           
@endpush