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
                    disabled
                  ></v-autocomplete>
                </v-flex>

                <v-flex xs12 sm6 md3>
                  <v-text-field v-model="attention" label="Atención" required></v-text-field>
                </v-flex>
                <v-flex xs12 sm6 md3>
                  <v-text-field v-model="phone" label="Telefono" required></v-text-field>
                </v-flex>
                <v-flex xs12 sm6 md3>
                  <v-text-field v-model="email" label="Correo" required></v-text-field>
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
            <list-products></list-products>
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
                <td class="text-xs-rigth">
                  <template v-if="props.item.fraccion == 1">{{ props.item.medida }}</template>
                  <template v-else>
                    <v-select
                      v-model="props.item.num_um"
                      :items="[
                        { id:1, text: props.item.medida },
                        { id: 2, text: props.item.medida_fra }
                      ]"
                      item-value="id"
                      item-text="text"
                    ></v-select>
                  </template>
                </td>
                <td class="text-xs-center super-price">
                  <template
                    v-if="props.item.num_um == 2"
                  >{{ Number(props.item.precio_fra).toFixed(2) }}</template>
                  <template v-else>
                    <SelectEdit :items="props.item.prices" v-model="props.item.precio"></SelectEdit>
                  </template>
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
          <v-btn
            color="success darken-1"
            dark
            @click="onSubmitOrder"
            style="margin: 1.2em 0;"
          >Guardar Pedido</v-btn>
          <loader v-if="isLoadingProforma"></loader>
        </v-card>
      </v-flex>
    </v-layout>
  </v-container>
</template>

<script>
import { mapState, mapMutations, mapActions } from "vuex";

export default {
  data: function() {
    return {
          date: new Date().toISOString().substr(0, 10),
      menu: false,
      modal: false,
      menu2: false,
      isLoadingProforma: false,
      isLoadingClient: false,
      clients: [],
      searchClient: null,
      isLoadingSeller: false,
      sellers: [],
      searchSeller: null,
      conditions: ["Contado ", "Crédito"],
      dialog: false,
      search: "",
      sellerDefault: {},
      headers_orders: [
        { text: "Producto", sortable: false, value: "descripcion" },
        { text: "Medida", sortable: false, value: "num_un" },
        { text: "Precio Unitario", sortable: false, value: "precio" },
        { text: "Cantidad", sortable: false, value: "cantidad" },
        { text: "Importe", sortable: false, value: "precio_total" },
        { text: "Acción", sortable: false, value: "accion" }
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
    axios.get("/api/seller_user").then(({ data }) => {
      this.sellerDefault = data;
      this.sellers = [data];
      this.sellerId = data;
    });
  },
  computed: {
    ...mapState(["selected"]),
    sumaTotal() {
      this.total = 0;
      this.selected.forEach(product => {
        if (product.num_um == 2) {
          product.precio = product.precio_fra;
        }
        this.total = this.total + product.precio * product.cantidad;
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
    ...mapActions(["removeAll", "removeProduct"]),
    removeAllSelected() {
      this.removeAll().then(() => {});
    },
    onChangeClient(client) {
      if (client) {
        this.phone = client.telefono;
        this.email = client.correo;
        this.attention = client.contacto;
      }
    },

    close() {
      this.search = "";
      this.dialog = false;
    },
    deleteItem(item) {
      const index = this.selected.indexOf(item);
      confirm("Esta seguro de querer borrar este item?") &&
        this.removeProduct(index);
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

      if (!this.clientId) {
        notify.error("Elija un cliente");
        return;
      }

      if (!this.condition) {
        notify.error("Elija una condicion de pago");
        return;
      }

      if (!this.sellerId) {
        notify.error("Elija un vendedor");
        return;
      }

      if (this.selected.length === 0) {
        notify.error("Agregue al menos un producto");
        return;
      }

      this.isLoadingProforma = true;

      axios
        .post("/api/proforma/create", data)
        .then(({ data }) => {
          notify.showCool(data.message);
          this.reset();
          this.isLoadingProforma = false;
        })
        .catch(error => {
          // notify.error(error.response.data.message);
          notify.error("Ocurrio un error");
          this.isLoadingProforma = false;
        });
    },

    reset() {
      this.clientId = "";
      this.condition = "";
      this.observation = "";
      this.phone = "";
      this.attention = "";
      this.email = "";
      this.removeAllSelected();
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

  table .v-input {
    font-size: 13px !important;
  }
}

.theme--light.v-table tbody tr[active] {
  background: rgba(97, 180, 247, 0.15);
}

.theme--light.v-table tbody tr[active]:hover {
  background: rgba(97, 180, 247, 0.3);
}

.P0 {
  color: #00e676;
}

.P1 {
  color: #ff5722;
}

.P2 {
  color: #ff9800;
}

.P3 {
  color: #9c27b0;
}

.P4 {
  color: #ffc107;
}

.super-price {
  font-size: 16px !important;
  text-align: left !important;
}
</style>
