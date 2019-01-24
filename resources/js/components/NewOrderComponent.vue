<template>
  <v-container bg grid-list-md text-xs-center>
    <v-layout row wrap>
      <v-flex xs12 sm12 md12>
        <v-card>
          <v-card-title class="headline font-weight-regular border-gray">NUEVO PEDIDO</v-card-title>
          <v-card-text>
            <v-form>
              <v-layout wrap>
                <v-flex xs12 sm6 md3>
                  <v-autocomplete
                    v-model="clientId"
                    :items="clients"
                    :label="`Cliente`"
                    persistent-hint
                    item-text="text"
                    item-value="id"
                  ></v-autocomplete>
                </v-flex>
                <v-flex xs12 sm6 md3>
                  <v-autocomplete
                    v-model="sellerId"
                    :items="sellers"
                    :label="`Vendedor`"
                    persistent-hint
                    item-text="text"
                    item-value="id"
                  ></v-autocomplete>
                </v-flex>
                <v-flex xs12 sm6 md3>
                  <v-text-field v-model="condition" label="Condiciones de pago" required></v-text-field>
                </v-flex>
                <v-flex xs12 sm6 md3>
                  <v-text-field v-model="observation" label="Observaciones" required></v-text-field>
                </v-flex>
              </v-layout>
            </v-form>
            <v-toolbar flat color="white">
              <v-spacer></v-spacer>
              <v-dialog v-model="dialog" max-width="800px">
                <v-btn slot="activator" color="primary" dark class="mb-2">AGREGAR</v-btn>
                <v-card>
                  <v-card-title>
                    <span class="headline">Seleccionar Producto</span>
                    <v-spacer></v-spacer>
                    <v-text-field
                      v-model="search"
                      append-icon="search"
                      label="Buscar"
                      single-line
                      hide-details
                    ></v-text-field>
                  </v-card-title>
                  <v-card-text>
                    <v-layout wrap>
                      <v-flex xs12 sm12 md12>
                        <v-data-table
                          v-model="selected"
                          :headers="headers_products"
                          :items="products"
                          :search="search"
                          item-key="idproducto"
                          select-all
                          class="elevation-1"
                        >
                          <template slot="items" slot-scope="props">
                            <td>
                              <v-checkbox v-model="props.selected" primary hide-details></v-checkbox>
                            </td>
                            <td class="text-xs-center">{{ props.item.codigo }}</td>
                            <td class="text-xs-center">{{ props.item.descripcion }}</td>
                            <td class="text-xs-center">{{ props.item.medida }}</td>

                            <td class="text-xs-center">
                              <v-select :items=" props.item.prices" v-model="props.item.precio"></v-select>
                            </td>
                          </template>
                        </v-data-table>
                      </v-flex>
                    </v-layout>
                  </v-card-text>
                  <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="blue darken-1" flat @click="close">Cerrar</v-btn>
                  </v-card-actions>
                </v-card>
              </v-dialog>
            </v-toolbar>

            <v-data-table :headers="headers_orders" :items="selected" class="elevation-1">
              <template slot="items" slot-scope="props">
                <td class="text-xs-center">{{ props.item.codigo }}</td>
                <td class="text-xs-center">{{ props.item.descripcion }}</td>
                <td class="text-xs-center">{{ props.item.precio1 }}</td>
                <td class="text-xs-center">{{ props.item.cantidad }}</td>
                <td class="text-xs-center">{{ props.item.precio * props.item.cantidad }}</td>
                <td class="justify-center layout px-0">
                  <v-icon small @click="deleteItem(props.item)">delete</v-icon>
                </td>
              </template>
              <template slot="no-data">
                <v-alert
                  :value="true"
                  color="info"
                  icon="warning"
                  style="margin: 1.5em 0"
                >Aún no se han agregado productos :(</v-alert>
              </template>
            </v-data-table>
          </v-card-text>
          <v-btn color="success darken-1" dark @click="onSubmitOrder">Guardar Pedido</v-btn>

          <v-snackbar
            v-model="snackbar"
            :multi-line="true"
            :right="true"
            :timeout="timeout"
            :top="true"
            :color="color"
          >
            {{ text }}
            <v-btn dark flat @click="snackbar = false">Close</v-btn>
          </v-snackbar>
        </v-card>
      </v-flex>
    </v-layout>
  </v-container>
</template>

<script>
export default {
  data: () => ({
    clients: [],
    sellers: [],
    products: [],
    selected: [],
    dialog: false,
    model: null,
    search: "",
    headers_orders: [
      {
        text: "Código",
        sortable: false,
        align: "left",
        value: "codigo"
      },
      { text: "Producto", sortable: false, value: "descripcion" },
      { text: "Precio Unitario", sortable: false, value: "precio" },
      { text: "Cantidad", sortable: false, value: "cantidad" },
      { text: "Precio Total", sortable: false, value: "precio_total" },
      { text: "Accion", sortable: false, value: "accion" }
    ],
    headers_products: [
      { text: "Código", sortable: true, align: "left", value: "codigo" },
      { text: "Producto", sortable: true, value: "descripcion" },
      { text: "Medida", sortable: true, value: "medida" },
      { text: "Precio", sortable: true, value: "precio" }
    ],
    editedIndex: -1,
    editedItem: {
      name: "",
      calories: 0,
      fat: 0,
      carbs: 0,
      protein: 0
    },
    defaultItem: {
      name: "",
      calories: 0,
      fat: 0,
      carbs: 0,
      protein: 0
    },
    clientId: "",
    sellerId: "",
    observation: "",
    condition: "",
    total: 0,
    snackbar: false,
    y: "top",
    x: null,
    mode: "",
    color: "error",
    timeout: 3000,
    text: "Ocurrio un eror :("
  }),
  mounted() {
    axios.get("/api/clients").then(({ data }) => {
      this.clients = data;
    });
    axios.get("/api/sellers").then(({ data }) => {
      this.sellers = data;
    });
    axios.get("/api/products").then(({ data }) => {
      this.products = data;
    });
  },
  computed: {
    formTitle() {
      return this.editedIndex === -1 ? "New Item" : "Edit Item";
    }
  },
  watch: {
    dialog(val) {
      val || this.close();
    }
  },

  created() {
    this.initialize();
  },

  methods: {
    initialize() {},

    close() {
      this.dialog = false;
      this.selected = this.selected.map(item => ({ ...item, cantidad: 1 }));
      setTimeout(() => {
        this.editedItem = Object.assign({}, this.defaultItem);
        this.editedIndex = -1;
      }, 300);
    },

    save() {
      console.log(this.orders[this.editedIndex]);
      if (this.editedIndex > -1) {
        Object.assign(this.orders[this.editedIndex], this.editedItem);
      } else {
        this.orders.push(this.editedItem);
      }
      this.close();
    },

    deleteItem(item) {
      const index = this.selected.indexOf(item);
      confirm("Esta seguro de querer borrar este item?") &&
        this.selected.splice(index, 1);
    },

    onSubmitOrder() {
      const data = {
        clientId: this.clientId,
        sellerId: this.sellerId,
        condition: this.condition,
        observation: this.observation,
        products: this.selected,
        total: 20
      };
      console.log(data);

      axios
        .post("/api/proforma/create", data)
        .then(({ data }) => {
          notify.showCool(data.message);
          this.reset();
        })
        .catch(response => {
          notify.error("Ocurrio un error");
        });
    },
    reset() {
      this.clientId = "";
      this.sellerId = "";
      this.condition = "";
      this.observation = "";
      this.selected = [];
    }
  }
};
</script>

<style>
.border-gray {
  border-bottom: 1px solid #949494;
}
</style>
