<template>
  <div>
    <div class="container-picker">
      <div class="datepicker-trigger">
        <input
          type="text"
          id="datepicker-trigger"
          placeholder="Seleccione fechas"
          :value="formatDates(startDate, endDate)"
        >

        <AirbnbStyleDatepicker
          :trigger-element-id="'datepicker-trigger'"
          :mode="'range'"
          :fullscreen-mobile="true"
          :date-one="startDate"
          :date-two="endDate"
          :end-date="new Date()"
          mobileHeader="Seleccionar Fechas"
          @date-one-selected="val => { startDate = val }"
          @date-two-selected="val => { endDate = val }"
        />
      </div>
      <v-btn color="primary darken-1" outline @click="onSearch">Buscar</v-btn>
    </div>
    <div class="container">
      <div class="box">
        <v-data-table
          :headers="headers"
          :items="proformas"
          :loading="loading"
          :pagination.sync="pagination"
          hide-actions
          class="elevation-1"
        >
          <template slot="no-data">
            <v-alert
              :value="proformas.length === 0"
              color="error"
              icon="warning"
              v-if="!loading"
            >Ninguna proforma coincide con las fechas :(</v-alert>
          </template>
          <template slot="items" slot-scope="props">
            <td>{{ props.item.idproforma }}</td>
            <td>{{ props.item.seller ? props.item.seller.nombre : '' }}</td>
            <td>{{ props.item.client.cliente ? props.item.client.cliente : '' }}</td>
            <td>{{ props.item.fecha }}</td>
            <td>
              <button @click="showPdf(props.item)">
                <v-icon ligth>remove_red_eye</v-icon>
              </button>
              <button @click="onEdit(props.item)">
                <v-icon ligth>edit</v-icon>
              </button>
            </td>
          </template>
        </v-data-table>
        <div class="text-xs-center pt-2">
          <v-pagination
            v-model="pagination.current"
            :length="pagination.total"
            @input="onPageChange"
          ></v-pagination>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { format, subMonths } from "date-fns";

export default {
  data() {
    return {
      baseUrl: "",
      dateFormat: "DD MMM YYYY",
      startDate: localeFormat(subMonths(new Date(), 1), this.dateFormat),
      endDate: localeFormat(new Date(), this.dateFormat),
      headers: [
        {
          text: "id",
          sortable: false,
          value: "idproforma"
        },
        { text: "Vendedor", sortable: false, value: "idvendedor" },
        { text: "Cliente", sortable: false, value: "idcliente" },
        { text: "Fecha", sortable: false, value: "fecha" },
        { text: "Acciones", sortable: false, value: "fecha" }
      ],
      loading: true,
      proformas: [],
      pagination: {
        rowsPerPage: 10,
        current: 1,
        total: 0
      }
    };
  },
  mounted() {
    this.getSearchProformas();
    this.baseUrl = document.head.querySelector(
      'meta[name="api-base-url"]'
    ).content;
  },
  methods: {
    formatDates(startDate, endDate) {
      let formattedDates = "";
      if (startDate) {
        formattedDates = localeFormat(startDate, this.dateFormat);
      }
      if (endDate) {
        formattedDates += " - " + localeFormat(endDate, this.dateFormat);
      }
      return formattedDates;
    },

    onSearch() {
      this.pagination.current = 1;
      this.getSearchProformas();
    },

    getSearchProformas() {
      const params = {
        startDate: this.startDate,
        endDate: this.endDate,
        page: this.pagination.current
      };
      axios
        .get(`/api/search-proformas`, { params })
        .then(({ data }) => {
          console.log(data);

          this.proformas = data.data;
          this.pagination.current = data.current_page;
          this.pagination.total = data.last_page;
          this.loading = false;
        })
        .catch(error => {
          notify.error(error.response.data.message);
          this.loading = false;
        });
      console.log(this.startDate, this.endDate);
    },
    onPageChange() {
      this.getSearchProformas();
    },

    onEdit(proforma) {
      if (proforma.fecha === format(new Date(), "YYYY-MM-DD")) {
        window.location = `${this.baseUrl}/proformas/${proforma.idproforma}`;
      } else {
        notify.error("La proforma no se puede editar");
      }
    },

    showPdf(proforma) {
      window.open(`${this.baseUrl}/proforma/${proforma.documento}`, "_blank");
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
