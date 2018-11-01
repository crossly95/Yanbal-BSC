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
      indicadores: [],
      preguntas: [],
      fillIndicador: {},
      nuevoIndicador: this.schema(),
      nuevaPregunta: this.schema2(),
      formErrors: {},
      formErrorsUpdate: {},
      modalState: false,
      selected: {},
      valores: [{ respuesta: "", valor: "" }]
    };
  },
  created() {
    this.fetch();
  },
  methods: {
    AddField: function() {
      this.valores.push({ respuesta: "", valor: "" });
    },
    removeItem(index) {
      this.valores.splice(index, 1);
    },
    schema() {
      return {
        nombre: "",
        meta: "",
        tipo: ""
      };
    },
    schema2() {
      return {
        pregunta: "",
        respuesta: []
      };
    },

    store() {
      axios
        .post("/api/indicadores", this.nuevoIndicador)
        .then(response => {
          this.fetch();
          this.formErrors = {};
          this.nuevoIndicador = {};
          toastr.success("Indicador Creado Correctamente");
        })
        .catch(error => (this.formErrors = error.response.data.errors));
    },
    storeQuestion() {
      this.nuevaPregunta.respuesta = this.valores;
      axios
        .post("/api/preguntas", this.nuevaPregunta)
        .then(response => {
          this.fetch();
          this.openPreguntasModal(this.fillIndicador);
          this.formErrors = {};
          this.nuevaPregunta = this.schema2();
          this.valores = [{ respuesta: "", valor: "" }];

          toastr.success("Pregunta Creada Correctamente");
        })
        .catch(error => (this.formErrors = error.response.data.errors));
    },
    destroy(indi) {
      axios.delete("/api/indicadores/" + indi.PK_id).then(() => {
        this.indicadores = this.indicadores.filter(value => value != indi);
        toastr.info("Indicador eliminado correctamente");
      });
    },
    destroyPre(pre) {
      axios.delete("/api/preguntas/" + pre.PK_id).then(() => {
        this.preguntas = this.preguntas.filter(value => value != pre);
        toastr.info("Indicador eliminado correctamente");
      });
    },
    openPreguntasModal(indi) {
      this.fillIndicador = indi;
      this.nuevaPregunta.FK_IndicadorId = indi.PK_id;

      this.questions(indi.PK_id);

      $("#modal-preguntas").modal("show");
    },
    questions(id) {
      axios
        .get(`/api/preguntas/` + id)
        .then(res => (this.preguntas = res.data));
    },
    fetch() {
      axios.get(`/api/indicadores`).then(res => (this.indicadores = res.data));
    }
  }
});
