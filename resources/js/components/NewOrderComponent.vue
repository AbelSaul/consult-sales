<template>
  <v-container bg fill-height grid-list-md text-xs-center>
    <v-layout row wrap>
      <v-flex xs12>
        <v-card>
          <v-card-title class="headline font-weight-regular blue-grey white--text">NUEVO PEDIDO</v-card-title>
          <v-card-text>
            <v-form v-model="valid">
              <v-container>
                <v-layout>
                  <v-flex xs12 md4>
                    <v-autocomplete
                      v-model="model"
                      :items="states"
                      :label="`Cliente`"
                      persistent-hint
                    ></v-autocomplete>
                  </v-flex>

                  <v-flex xs12 md4>
                    <v-autocomplete
                      v-model="model"
                      :items="states"
                      :label="`Vendedor`"
                      persistent-hint
                    ></v-autocomplete>
                  </v-flex>

                  <v-flex xs12 md4>
                    <v-text-field
                      v-model="paymentConditions"
                      :rules="nameRules"
                      label="Condiciones de pago"
                      required
                    ></v-text-field>
                  </v-flex>

                  <v-flex xs12 md4>
                    <v-text-field
                      v-model="observations"
                      :rules="nameRules"
                      label="Observaciones"
                      required
                    ></v-text-field>
                  </v-flex>
                </v-layout>
              </v-container>
            </v-form>

            <v-toolbar flat color="white">
              <v-dialog v-model="dialog" max-width="500px">
                <v-btn slot="activator" color="primary" dark class="mb-2">AGREGAR PRODUCTO</v-btn>

                <v-card>
                  <v-card-title>
                    <span class="headline">{{ formTitle }}</span>
                  </v-card-title>

                  <v-card-text>
                    <v-container grid-list-md>
                      <v-layout wrap>
                        <v-flex xs12 sm6 md4>
                          <v-text-field v-model="editedItem.name" label="Código"></v-text-field>
                        </v-flex>
                        <v-flex xs12 sm6 md4>
                          <v-text-field v-model="editedItem.calories" label="Producto"></v-text-field>
                        </v-flex>
                        <v-flex xs12 sm6 md4>
                          <v-text-field v-model="editedItem.fat" label="Precio Unitario"></v-text-field>
                        </v-flex>
                        <v-flex xs12 sm6 md4>
                          <v-text-field v-model="editedItem.carbs" label="Cantidad"></v-text-field>
                        </v-flex>
                        <v-flex xs12 sm6 md4>
                          <v-text-field v-model="editedItem.protein" label="Precio Total"></v-text-field>
                        </v-flex>
                      </v-layout>
                    </v-container>
                  </v-card-text>
                  <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="blue darken-1" flat @click="close">Cancelar</v-btn>
                    <v-btn color="blue darken-1" flat @click="save">Guardar</v-btn>
                  </v-card-actions>
                </v-card>
              </v-dialog>
            </v-toolbar>

            <v-data-table :headers="headers" :items="orders" class="elevation-1">
              <template slot="items" slot-scope="props">
                <td>{{ props.item.code }}</td>
                <td class="text-xs-right">{{ props.item.product }}</td>
                <td class="text-xs-right">{{ props.item.unit_price }}</td>
                <td class="text-xs-right">{{ props.item.amount }}</td>
                <td class="text-xs-right">{{ props.item.total_price }}</td>
              </template>
              <template slot="no-data">
                <v-text>No existe ordenes</v-text>
              </template>
            </v-data-table>
          </v-card-text>
          <v-btn color="success">Guardar Pedido</v-btn>
        </v-card>
      </v-flex>
    </v-layout>
  </v-container>
</template>



<script>
export default {
  data: () => ({
    dialog: false,
    model: null,
    states: ["Alabama", "Alaska", "American Samoa", "Arizona"],
    headers: [
      {
        text: "Código",
        sortable: false,
        align: "left",
        value: "code"
      },
      { text: "Producto", sortable: false, value: "product" },
      { text: "Precio Unitario", sortable: false, value: "unit_price" },
      { text: "Cantidad", sortable: false, value: "amount" },
      { text: "Precio Total", sortable: false, value: "total_price" }
    ],
    orders: [],
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
    }
  }),

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
    initialize() {
      this.orders = [
        {
          code: "Frozen Yogurt",
          product: 159,
          unit_price: 6.0,
          amount: 24,
          total_price: 4.0
        }
      ];
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
        Object.assign(this.orders[this.editedIndex], this.editedItem);
      } else {
        this.orders.push(this.editedItem);
      }
      this.close();
    }
  }
};
</script>
