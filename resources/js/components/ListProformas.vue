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
            <td>{{ props.item.documento }}</td>
            <td>{{ props.item.seller ? props.item.seller.nombre : '' }}</td>
            <td>{{ props.item.client.cliente ? props.item.client.cliente : '' }}</td>
            <td>{{Number(props.item.total).toFixed(2)}}</td>
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
          <div class="total-flex">
            <div class="total-header elevation-1">
              <div>Total: </div>
              <div> {{Number(this.total).toFixed(2)}}</div>
            </div>
          </div>
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
import { format, subMonths, subDays } from "date-fns";

export default {
  data() {
    return {
      baseUrl: "",
      dateFormat: "DD MMM YYYY",
      startDate: localeFormat(subDays(new Date(), 1), this.dateFormat),
      endDate: localeFormat(new Date(), this.dateFormat),
      headers: [
        { text: "Documento", sortable: false, value: "idproforma" },
        { text: "Vendedor", sortable: false, value: "idvendedor" },
        { text: "Cliente", sortable: false, value: "idcliente" },
        { text: "Total", sortable: false, value: "total" },
        { text: "Fecha", sortable: false, value: "fecha" },
        { text: "Acciones", sortable: false, value: "fecha" }
      ],
      loading: true,
      proformas: [],
      total: 0,
      pagination: {
        rowsPerPage: 10,
        current: 1,
        total: 0
      }
    };
  },
  mounted() {
    this.getSearchProformas();
    this.getTotalProformas();
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
      this.getTotalProformas();
      this.pagination.current = 1;
      this.getSearchProformas();
    },

    getTotalProformas() {
      const params = {
        startDate: this.startDate,
        endDate: this.endDate,
        page: this.pagination.current
      };
      axios
        .get(`/api/total-proformas`, { params })
        .then(({ data }) => {
          this.total = data;
          console.log("data es : ",this.total);

        })
        .catch(error => {
          notify.error(error.response.data.message);          
        });
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
      // proforma.fecha === format(new Date(), "YYYY-MM-DD")
      if (proforma.estado === "PE" ) {
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

.total-flex {
  display: flex;
  justify-content: flex-end;
  margin: 16px 0 !important; 
}


</style>
