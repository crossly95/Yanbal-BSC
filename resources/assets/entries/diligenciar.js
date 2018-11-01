import "./bootstrap";
import Vue from "vue";
import axios from "axios";
import TextInput from "../components/inputs/text-input";
import Modal from "../components/utils/modal";
import SelectInput from "../components/inputs/select-input";
import TextareaInput from "../components/inputs/textarea-input";
import { Popover } from "uiv";

Vue.component("my-input", {
  template: '<input v-attr="name: name" v-model="value" type="text">',
  data() {
    return {
      value: ""
    };
  },
  props: ["name"]
});

new Vue({
  el: "#app",
  components: {
    Modal,
    TextInput,
    TextareaInput,
    SelectInput,
    Popover
  },
  data() {
    return {
      preguntas: [],
      pruebas: [],
      contenido: [],
      indicadorId: window.indicadorId,
      usuarioId: window.usuarioId,
      formErrors: {},
      formErrorsUpdate: {},
      selected: {}
    };
  },
  created() {
    this.fetch();
  },
  methods: {
    schema() {
      return {
        PK_id: "",
        recomendacion: "",
        umbral: "",
        FK_IndicadorId: ""
      };
    },
    llenar() {
      return {
        pruebas: this.pruebas,
        userId: this.usuarioId
      };
    },

    store() {
      this.contenido = this.llenar();
      axios
        .post("/api/pruebas", this.contenido)
        .then(response => {
          this.fetch();
          this.formErrors = {};
          this.pruebas = [];
          toastr.success("Respuestas enviadas correctamente");
        })
        .catch(error => (this.formErrors = error.response.data.errors));
    },
    destroy(plan) {
      axios.delete("/api/planes/" + plan.PK_id).then(() => {
        this.planes = this.planes.filter(value => value != plan);
        toastr.info("Plan eliminado correctamente");
      });
    },
    questions(id) {
      axios
        .get(`/api/preguntas/` + id)
        .then(res => (this.preguntas = res.data));
    },
    fetch() {
      this.questions(this.indicadorId);
    }
  }
});
