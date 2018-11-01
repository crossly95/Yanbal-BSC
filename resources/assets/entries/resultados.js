import "./bootstrap";
import Vue from "vue";
import { Pagination, Modal } from "uiv";
import Validate from "../plugins/Validate";
import UserForm from "../components/admin/UserForm";
import Paginator from "../classes/paginator";
import VeeValidate, { Validator } from "vee-validate";
import Search from "../mixins/Search";

Vue.use(Validate);
new Vue({
  el: "#app",
  mixins: [Search],
  components: { Modal, Pagination, UserForm },
  data() {
    return {
      resultados: [],
      indicadores: [],
      paginator: new Paginator(),
      idUser: window.usuarioId,
      search: "",
      modal: false,
      deleteModal: false
    };
  },
  created() {
    axios
      .get(`/api/pruebas/` + this.idUser)
      .then(res => (this.resultados = res.data));
  },
  methods: {},

  watch: {
    search(query) {
      this.paginator.data = this.searchBy(
        this.resultados,
        query,
        "name",
        "email",
        "role"
      );
    }
  }
});
