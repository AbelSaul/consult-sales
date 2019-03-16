<template>
  <div>
    <v-toolbar flat color="white">
      <v-spacer></v-spacer>
      <v-dialog v-model="dialog" max-width="800px">
        <v-btn
          slot="activator"
          color="primary"
          dark
          class="mb-2"
          @click="initialProducts"
        >AGREGAR PRODUCTOS</v-btn>
        <v-card>
          <v-card-title>
            <span class="headline">Seleccionar</span>
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
                  :loading="loading"
                  :search="search"
                  item-key="idproducto"
                  class="elevation-1 table-modal"
                >
                  <!-- <template slot="no-data">
                    <v-alert
                      :value="products.length === 0"
                      color="error"
                      icon="warning"
                      v-if="!loading"
                    >No hay productos </v-alert>
                  </template>-->
                  <template slot="items" slot-scope="props">
                    <td>
                      <v-checkbox v-model="props.selected" @change="modifySelected" hide-details></v-checkbox>
                    </td>
                    <td
                      class="text-right product-td"
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
                  </template>
                </v-data-table>
                <!-- <div class="text-xs-center pt-2">
                  <v-pagination
                    v-model="pagination.current"
                    :length="pagination.total"
                    @input="onPageChange"
                  ></v-pagination>
                </div>-->
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
  </div>
</template>

<script>
import { mapGetters, mapState, mapMutations, mapActions } from "vuex";

export default {
  data() {
    return {
      baseUrl: "",
      loading: true,
      pagination: {
        rowsPerPage: 5,
        current: 1,
        total: 0
      },
      headers_products: [
        { text: "#", sortable: false, value: "" },
        { text: "Producto", sortable: false, value: "descripcion" },
        { text: "Medida", sortable: false, value: "medida" },
        { text: "Precio", sortable: false, value: "precio" }
      ],
      dialog: false,
      search: "",
      products: [],
      selected: []
    };
  },
  mounted() {
    // axios.get("/api/products").then(({ data }) => {
    //   this.products = data;
    //   this.loading = false;
    // });
    // this.getSearchProduct();
    this.baseUrl = document.head.querySelector(
      'meta[name="api-base-url"]'
    ).content;
  },
  computed: {
    ...mapGetters(["countSelected"])
  },
  methods: {
    ...mapMutations(["MODIFY_SELECTED"]),
    close() {
      this.search = "";
      this.dialog = false;
    },
    modifySelected: function() {
      this.MODIFY_SELECTED(this.selected);
    },

    initialProducts: function() {
      if (this.countSelected === 0) {
        // this.getSearchProduct();
        this.products = [];
        this.selected = [];
        this.loading = true;

        axios.get("/api/products").then(({ data }) => {
          this.products = data;
          this.loading = false;
        });
      }
    },
    onSearch() {
      this.pagination.current = 1;
      this.getSearchProduct();
    },
    getSearchProduct() {
      const params = {
        search: this.search,
        page: this.pagination.current
      };
      axios
        .get(`/api/search-products`, { params })
        .then(({ data }) => {
          console.log(data);
          this.products = data.data;
          this.pagination.current = data.current_page;
          this.pagination.total = data.last_page;
          this.loading = false;
        })
        .catch(error => {
          notify.error(error.response.data.message);
          this.loading = false;
        });
      console.log(this.search);
    },
    onPageChange() {
      this.getSearchProduct();
    }
  }
};
</script>
<style>
.container-picker {
  display: flex;
  align-items: center;
  justify-content: center;
}
#datepicker-trigger {
  padding: 7px;
  border: 1px solid #ddd;
  min-width: 300px;
}
</style>

