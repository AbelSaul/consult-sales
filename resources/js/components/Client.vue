
<template>
  <div>
    <v-toolbar flat color="white">
      <v-layout wrap>
        <v-flex xs12 sm6 md4>
          <v-toolbar-title>Clientes</v-toolbar-title>
          <v-divider class="mx-2" inset vertical></v-divider>
          <v-spacer></v-spacer>
        </v-flex>
        <v-flex xs12 sm6 md4>
          <v-text-field
            v-model="search"
            append-icon="search"
            label="Búscar cliente"
            single-line
            hide-details
          ></v-text-field>
        </v-flex>
      </v-layout>

      <v-dialog v-model="dialog" max-width="800px">
        <!-- <template v-slot:activator="{ on }">
          <v-btn color="primary" dark class="mb-2"  v-on="on">Nuevo Cliente</v-btn>
        </template>-->
        <v-btn slot="activator" color="primary" dark class="mb-2">
          <v-icon>add</v-icon>CLIENTE
        </v-btn>
        <v-card>
          <v-card-title>
            <span class="headline">{{ formTitle }}</span>
          </v-card-title>
          <v-card-text>
            <v-container grid-list-md>
              <v-flex xs12 sm6 md4 offset-md4>
                <v-text-field
                  v-model="editedItem.numero_documento"
                  :mask="mask_documento"
                  label="Número de Documento"
                  placeholder="Buscar.."
                  :loading="isLoadingNumDocument"
                  outline
                  @change="getFindPeople"
                  :rules="numDocumentoRules"
                ></v-text-field>
              </v-flex>
              <v-layout wrap>
                <v-flex xs12 sm6 md4>
                  <v-text-field v-model="editedItem.primer_nombre" label="Nombre/Razón Social"></v-text-field>
                </v-flex>
                <v-flex xs12 sm6 md4>
                  <v-text-field
                    v-model="editedItem.segundo_nombre"
                    label="Apellidos/Nombre Comercial"
                  ></v-text-field>
                </v-flex>
                <v-flex xs12 sm6 md4>
                  <v-text-field v-model="editedItem.distrito" label="Distrito"></v-text-field>
                </v-flex>
                <v-flex xs12 sm6 md4>
                  <v-text-field
                    v-model="editedItem.telefono"
                    :mask="mask_telefono"
                    label="Teléfono"
                  ></v-text-field>
                </v-flex>
                <v-flex xs12 sm6 md4>
                  <v-text-field v-model="editedItem.celular" :mask="mask_celular" label="Celular"></v-text-field>
                </v-flex>

                <v-flex xs12 sm6 md4>
                  <v-text-field v-model="editedItem.correo" label="Correo"></v-text-field>
                </v-flex>
              </v-layout>
            </v-container>
          </v-card-text>

          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn color="error darken-1" flat @click="close">Cancelar</v-btn>
            <v-btn color="success darken-1" flat @click="save">Guardar</v-btn>
          </v-card-actions>
          <loader v-if="isLoading"></loader>
        </v-card>
      </v-dialog>
    </v-toolbar>
    <v-data-table :headers="headers" :items="clients" class="elevation-1" :search="search">
      <template slot="items" slot-scope="props">
        <td class="text-xs-center">{{ props.index + 1}}</td>
        <td class="text-xs-center">{{ props.item.numero_documento }}</td>
        <td class="text-xs-center">{{ props.item.primer_nombre }}</td>
        <td class="text-xs-center">{{ props.item.segundo_nombre }}</td>
        <td class="text-xs-center">{{ props.item.distrito }}</td>
        <td class="text-xs-center">{{ props.item.telefono }}</td>
        <td class="text-xs-center">{{ props.item.celular }}</td>
        <td class="text-xs-center">{{ props.item.correo }}</td>
        <!-- <td class="justify-center layout px-0">
          <v-icon small class="mr-2" @click="editItem(props.item)">edit</v-icon>
          <v-icon small @click="deleteItem(props.item)">delete</v-icon>
        </td>-->
      </template>
    </v-data-table>
  </div>
</template>

<script>
export default {
  props: ["clients"],
  data() {
    return {
      isLoading: false,
      isLoadingNumDocument: false,
      dialog: false,
      mask_documento: "###########",
      mask_telefono: "##########",
      mask_celular: "###-###-###",
      search: "",
      searchPeople: null,
      headers: [
        { text: "N°", value: "n" },
        { text: "Número Documento", value: "numero_documento" },
        { text: "Nombres/Razon Social", value: "primer_nombre" },
        { text: "Apellidos/Nombre Comercial", value: "segundo_nombre" },
        { text: "Distrito", value: "distrito" },
        { text: "Teléfono", value: "telefono" },
        { text: "Celular", value: "celular" },
        { text: "Correo", value: "correo" }
        // { text: "Acciones", value: "action", sortable: false }
      ],
      numDocumentoRules: [
        v => v.length == 8 || v.length == 11 || "Ingrese 8 o 11 números"
      ],
      editedIndex: -1,
      editedItem: {
        numero_documento: "",
        primer_nombre: "",
        segundo_nombre: "",
        telefono: "",
        celular: "",
        correo: "",
        distrito: ""
      },
      defaultItem: {
        numero_documento: "",
        primer_nombre: "",
        segundo_nombre: "",
        telefono: "",
        celular: "",
        correo: "",
        distrito: ""
      }
    };
  },
  mounted() {
    // axios.get("/api/clients").then(({ data }) => {
    //   this.clientes = data;
    //   console.log(this.clientes);
    // });
  },
  computed: {
    formTitle() {
      return this.editedIndex === -1 ? "Nuevo Cliente" : "Editar CLiente";
    }
  },

  watch: {
    dialog(val) {
      val || this.close();
    }
  },

  methods: {
    // initialize() {
    //   axios.get("/api/clients-list").then(({ data }) => {
    //     this.clients = data;
    //     console.log(this.clients);
    //   });
    // },
    editItem(item) {
      this.editedIndex = this.clients.indexOf(item);
      this.editedItem = Object.assign({}, item);
      this.dialog = true;
    },

    deleteItem(item) {
      const index = this.clients.indexOf(item);
      confirm("Are you sure you want to delete this item?") &&
        this.clients.splice(index, 1);
    },

    close() {
      this.dialog = false;
      setTimeout(() => {
        this.editedItem = Object.assign({}, this.defaultItem);
        this.editedIndex = -1;
      }, 300);
    },

    save() {
      if (this.editedIndex > -1) {
        Object.assign(this.clients[this.editedIndex], this.editedItem);
      } else {
        const data = {
          numero_documento: this.editedItem.numero_documento,
          primer_nombre: this.editedItem.primer_nombre,
          segundo_nombre: this.editedItem.segundo_nombre,
          distrito: this.editedItem.distrito,
          telefono: this.editedItem.telefono,
          celular: this.editedItem.celular,
          correo: this.editedItem.correo
        };

        if (!this.editedItem.numero_documento) {
          notify.error("Ingrese número de documento");
          return;
        }

        if (!this.editedItem.primer_nombre) {
          notify.error("Ingrese Nombre/Razón social ");
          return;
        }

        if (!this.editedItem.segundo_nombre) {
          notify.error("Ingrese Apellidos/Nombre comercial");
          return;
        }

        if (!this.editedItem.distrito) {
          notify.error("Ingrese distrito");
          return;
        }

        this.isLoading = true;

        axios
          .post("/api/client/create", data)
          .then(({ data }) => {
            notify.showCool(data.message);
            this.reset();
            this.close();
            // this.initialize();

            this.isLoading = false;
          })
          .catch(error => {
            notify.error(error.response.data.message);
            this.isLoading = false;
          });
      }
    },

    getFindPeople() {
      const params = {
        numero_documento: this.editedItem["numero_documento"]
      };
      this.isLoadingNumDocument = true;
      axios
        .get(`/api/find_people`, { params })
        .then(({ data }) => {
          this.editedItem = data;
          this.isLoadingNumDocument = false;
        })
        .catch(error => {
          notify.error(error.response.data.message);
          this.isLoadingNumDocument = false;
          this.reset();
        });
    },
    reset() {
      // (this.editedItem[numero_documento] = ""),
      (this.editedItem["primer_nombre"] = ""),
        (this.editedItem["segundo_nombre"] = ""),
        (this.editedItem["telefono"] = ""),
        (this.editedItem["celular"] = ""),
        (this.editedItem["correo"] = ""),
        (this.editedItem["distrito"] = "");
    }
  }
};
</script>
