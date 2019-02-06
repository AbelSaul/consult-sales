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
                    :loading="isLoadingClient"
                    :search-input.sync="searchClient"
                    :label="`Cliente`"
                    hide-no-data
                    hide-selected
                    no-data-text="No hay ningun vendedor"
                    item-text="text"
                    item-value="id"
                    @change="onChangeClient"
                    return-object
                  ></v-autocomplete>
                </v-flex>
                <v-flex xs12 sm6 md3>
                  <v-autocomplete
                    v-model="sellerId"
                    :items="sellers"
                    :loading="isLoadingSeller"
                    :search-input.sync="searchSeller"
                    :label="`Vendedor`"
                    no-data-text="No hay ningun vendedor"
                    persistent-hint
                    item-text="nombre"
                    item-value="idpersonal"
                    return-object
                  ></v-autocomplete>
                </v-flex>

                <v-flex xs12 sm6 md3>
                  <v-text-field v-model="attention" label="Atención" required></v-text-field>
                </v-flex>
                <v-flex xs12 sm6 md3>
                  <v-text-field v-model="phone" label="Telefono" required></v-text-field>
                </v-flex>
                <v-flex xs12 sm6 md3>
                  <v-text-field v-model="email" label="Correo" :rules="emailRules" required></v-text-field>
                </v-flex>

                <v-flex xs12 sm6 md3>
                  <v-combobox
                    :label="`Condiciones de pago`"
                    v-model="condition"
                    :items="conditions"
                    clearable
                  ></v-combobox>
                </v-flex>
                <v-flex xs12 sm6 md6>
                  <v-text-field
                    v-model="observation"
                    label="Observacion | Fecha | Entrega | Lugar"
                    required
                  ></v-text-field>
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
                          class="elevation-1 table-modal"
                        >
                          <template slot="items" slot-scope="props">
                            <td>
                              <v-checkbox v-model="props.selected" primary hide-details></v-checkbox>
                            </td>
                            <td
                              class="text-right product-td"
                            >{{ props.item.descripcion + ' - ' + props.item.codigo }}</td>
                            <td class="text-xs-center">{{ props.item.medida }}</td>

                            <td class="text-xs-center">
                              <v-select
                                :items="props.item.prices"
                                v-model="props.item.precio"
                                item-value="price"
                              >
                                <template
                                  slot="selection"
                                  slot-scope="data"
                                >{{ Number(data.item.price).toFixed(2) }} {{ data.item.label }}</template>
                                <template
                                  slot="item"
                                  slot-scope="data"
                                >{{ Number(data.item.price).toFixed(2) }} {{ data.item.label }}</template>
                              </v-select>
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

            <v-data-table
              :headers="headers_orders"
              :items="selected"
              :hide-actions="true"
              class="elevation-1 custom-table"
            >
              <template slot="items" slot-scope="props">
                <td
                  class="text-left product-td"
                >{{ props.item.descripcion + ' - ' + props.item.codigo }}</td>
                <td class="text-xs-right">
                  <v-select
                    :items="props.item.prices"
                    v-model="props.item.precio"
                    item-value="price"
                  >
                    <template
                      slot="selection"
                      slot-scope="data"
                    >{{ Number(data.item.price).toFixed(2) }} {{ data.item.label }}</template>
                    <template
                      slot="item"
                      slot-scope="data"
                    >{{ Number(data.item.price).toFixed(2) }} {{ data.item.label }}</template>
                  </v-select>
                </td>
                <td class="text-xs-right">
                  <input type="number" min="1" v-model.number="props.item.cantidad">
                </td>
                <td
                  class="text-xs-right"
                >{{ Number(props.item.precio * props.item.cantidad ).toFixed(2)}}</td>
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
          <div class="total-flex">
            <div class="total-header elevation-1">
              <div>Total:</div>
              <div>{{Number(sumaTotal).toFixed(2)}}</div>
            </div>
          </div>
          <v-btn color="success darken-1" dark @click="onSubmitOrder">Guardar Pedido</v-btn>
        </v-card>
      </v-flex>
    </v-layout>
  </v-container>
</template>

<script>
export default {
  data: function() {
    return {
      isLoadingClient: false,
      clients: [],
      searchClient: null,
      isLoadingSeller: false,
      sellers: [],
      searchSeller: null,
      conditions: ["contado", "credito"],
      products: [],
      selected: [],
      dialog: false,
      search: "",
      sellerDefault: {},
      headers_orders: [
        // {
        //   text: "Código",
        //   sortable: false,
        //   align: "left",
        //   value: "codigo"
        // },
        { text: "Producto", sortable: false, value: "descripcion" },
        { text: "Precio Unitario", sortable: false, value: "precio" },
        { text: "Cantidad", sortable: false, value: "cantidad" },
        { text: "Importe", sortable: false, value: "precio_total" },
        { text: "Acción", sortable: false, value: "accion" }
      ],
      headers_products: [
        // { text: "Código", sortable: true, align: "left", value: "codigo" },
        { text: "Producto", sortable: true, value: "descripcion" },
        { text: "Medida", sortable: true, value: "medida" },
        { text: "Precio", sortable: true, value: "precio" }
      ],
      editedIndex: -1,
      clientId: "",
      sellerId: "",
      observation: "",
      condition: "",
      localId: "",
      attention: "",
      phone: "",
      email: "",
      text: "Ocurrio un eror :(",
      total: 0,
      emailRules: [v => /.+@.+/.test(v) || "El email debe ser válido"]
    };
  },
  mounted() {
    axios.get("/api/products").then(({ data }) => {
      this.products = data;
    });

    axios.get("/api/seller_user").then(({ data }) => {
      this.sellerDefault = data;
      this.sellers = [data];
      this.sellerId = data;
    });
  },
  computed: {
    sumaTotal() {
      this.total = 0;
      this.selected.forEach(element => {
        this.total = this.total + element.precio * element.cantidad;
      });
      return this.total;
    }
  },
  watch: {
    searchClient(val, old) {
      if (val === this.clientId.text) return;
      this.isLoadingClient = true;
      axios.get(`/api/clients?search=${val}`).then(res => {
        this.clients = res.data;
        this.isLoadingClient = false;
      });
    },
    searchSeller(val) {
      if (this.sellerDefault.nombre === val) return;
      this.isLoadingSeller = true;
      axios.get(`/api/sellers?search=${val}`).then(({ data }) => {
        this.isLoadingSeller = false;
        this.sellers = data;
      });
    },
    dialog(val) {
      val || this.close();
    }
  },

  methods: {
    onChangeClient(client) {
      if (client) {
        this.phone = client.telefono;
        this.email = client.correo;
        this.attention = client.contacto;
      }
    },

    close() {
      this.dialog = false;
    },

    deleteItem(item) {
      const index = this.selected.indexOf(item);
      confirm("Esta seguro de querer borrar este item?") &&
        this.selected.splice(index, 1);
    },

    onSubmitOrder() {
      const data = {
        clientId: this.clientId.id,
        sellerId: this.sellerId.idpersonal,
        condition: this.condition,
        observation: this.observation,
        products: this.selected,
        total: this.total,
        localId: this.localId,
        email: this.email,
        attention: this.attention,
        phone: this.phone
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
      this.phone = "";
      this.attention = "";
      this.email = "";
      this.selected = [];
    }
  }
};
</script>

<style>
.custom-table th:not(:first-child),
.table-modal th:not(:first-child) {
  text-align: right !important;
}
.custom-table th:last-child {
  text-align: center !important;
}
.border-gray {
  border-bottom: 1px solid #949494;
}

[type="number"] {
  border: 2px solid #949494;
  max-width: 60px;
  text-align: center;
  padding: 4px;
  border-radius: 4px;
  outline: none;
}

[type="number"]:focus {
  border: 2px solid #1976d2;
}

.total-flex {
  display: flex;
  justify-content: flex-end;
  margin: 0 16px;
}

.total-header {
  padding: 10px;
  display: flex;
  justify-content: space-between;
  min-width: 200px;
}

.total-header div:first-child {
  padding-right: 20px;
  text-transform: uppercase;
}

.total-header div:last-child {
  min-width: 10%;
}

.custom-table thead tr > th:nth-of-type(3),
.table-modal thead tr > th:last-child {
  width: 200px;
}

.text-right {
  text-align: right;
}

.text-left {
  text-align: left;
}

.product-td {
  min-width: 200px !important;
}

@media (max-width: 500px) {
  .v-text-field {
    padding-top: 0;
  }
  .custom-table td,
  .custom-table th,
  .table-modal td,
  .table-modal th {
    padding: 0 12px !important;
  }
}

.theme--light.v-table tbody tr[active] {
  background: rgba(97, 180, 247, 0.15);
}

.theme--light.v-table tbody tr[active]:hover {
  background: rgba(97, 180, 247, 0.3);
}
</style>
