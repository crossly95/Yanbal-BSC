<template>
    <dropdown v-model="dropdown">
        <button class="btn btn-xs pull-right" @click="dropdown=true">
            REPORTES
            <span class="caret"></span>
        </button>
        <template slot="dropdown">
            <li>
                <post-form id="modelacion" :action="`/pdf/proyecto/${proyectoId}/modelacion`" label="modelacion"/> 
            </li>
            <li>
                <post-form id="plataforma" :action="`/pdf/proyecto/${proyectoId}/plataforma`" label="plataforma"/> 
            </li>
            <li>
                <post-form id="codificacion" :action="`/pdf/proyecto/${proyectoId}/codificacion`" label="codificacion"/> 
            </li>
            <li>
                <post-form id="basedatos" :action="`/pdf/proyecto/${proyectoId}/basedatos`" label="basedatos"/> 
            </li>
            <li>
                <post-form id="total" :action="`/pdf/proyecto/${proyectoId}/total`" label="global"/> 
            </li>
        </template>
    </dropdown>
</template>
<script>
import PostForm from '../utils/post-form'
import { Dropdown } from "uiv";
export default {
    props: ['proyectoId'],
    components: { PostForm, Dropdown },
    data() {
        return { dropdown: false }
    }
}
</script>
