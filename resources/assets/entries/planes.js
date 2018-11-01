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
      planes: [],
      fillPlan: {},
      nuevoPlan: this.schema(),
      indicadorId: window.indicadorId,
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
        estado: "malo",
        FK_IndicadorId: ""
      };
    },

    store() {
      this.nuevoPlan.FK_IndicadorId = this.indicadorId;
      axios
        .post("/api/planes", this.nuevoPlan)
        .then(response => {
          this.fetch();
          this.formErrors = {};
          this.nuevoPlan = {};
          toastr.success("Plan Creado Correctamente");
        })
        .catch(error => (this.formErrors = error.response.data.errors));
    },
    destroy(plan) {
      axios.delete("/api/planes/" + plan.PK_id).then(() => {
        this.planes = this.planes.filter(value => value != plan);
        toastr.info("Plan eliminado correctamente");
      });
    },
    fetch() {
      axios
        .get(`/api/planes/` + this.indicadorId)
        .then(res => (this.planes = res.data));
    }
  }
});
