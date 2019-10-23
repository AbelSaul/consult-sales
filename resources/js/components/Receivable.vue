
<template>
  <div>
    <v-toolbar flat color="white">
      <v-layout wrap>
        <v-flex xs12 sm6 md4>
          <v-toolbar-title>Cuentas por cobrar</v-toolbar-title>
          <v-divider class="mx-2" inset vertical></v-divider>
          <v-spacer></v-spacer>
        </v-flex>
        <v-flex xs12 sm6 md4>
          <v-text-field
            v-model="search"
            label="Búscar aqui"
            append-icon="search"
            single-line
            hide-details
            v-on:keyup="onSearch"
          ></v-text-field>
        </v-flex>
      </v-layout>
    </v-toolbar>
    <v-data-table
      :headers="headers"
      :items="receivables"
      :loading="isLoadingTable"
      class="elevation-1"
      :pagination.sync="pagination"
      hide-actions
    >
      <template slot="items" slot-scope="props">
        <td class="text-xs-center">{{ props.item.fecha}}</td>
        <td class="text-xs-center">{{ props.item.fecha_vto }}</td>
        <td class="text-xs-center">{{ props.item.tipodoc }}</td>
        <td class="text-xs-center">{{ props.item.documento }}</td>

        <td  class="text-xs-center">{{ props.item.client.cliente ? props.item.client.ruc : '' }}</td>
 
        <td  class="text-xs-center">{{ props.item.client.cliente ? props.item.client.cliente : '' }}</td>

        <td class="text-xs-center">{{ props.item.moneda }}</td>
        <td class="text-xs-center">{{ props.item.total }}</td>
        <td class="text-xs-center">{{ props.item.saldo }}</td>
        <td class="text-xs-center">{{ props.item.saldo_cred }}</td>
        <td class="text-xs-center">{{ props.item.seller ? props.item.seller.nombre : '' }}</td>

        <td class="justify-center layout px-0">
          <v-icon small class="mr-2" @click="newPayment()">edit</v-icon>
          <v-icon small class="mr-2" @click="detailPayment()">list</v-icon>
        </td>
      </template>
    </v-data-table>
    <div class="text-xs-center pt-2">
      <v-pagination v-model="pagination.current" :length="pagination.total" @input="onPageChange"></v-pagination>
    </div>
  </div>
</template>

<script>
export default {

  data() {
    return {
      search: "",
      receivables: [],
      isLoadingTable: true,
      headers: [
        { text: "Fecha Emi.", value: "fecha" },
        { text: "Fecha Vto.", value: "fecha_vto" },
        { text: "Tipo", value: "tipodoc" },
        { text: "Documento", value: "documento" },
        { text: "RUC/DNI", value: "ruc" },
        { text: "Cliente", value: "cliente" },
        { text: "Moneda", value: "moneda" },
        { text: "Total", value: "total" },
        { text: "Saldo Deudor", value: "saldo" },
        { text: "Saldo Favor", value: "saldo_cred"},
        { text: "Vendedor", value: "vendedor"},
        { text: "Acciones", value: "action", sortable: false }
        
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
        direccion: ""
      },
      defaultItem: {
        numero_documento: "",
        primer_nombre: "",
        segundo_nombre: "",
        telefono: "",
        celular: "",
        correo: "",
        direccion: ""
      },
      pagination: {
        rowsPerPage: 10,
        current: 1,
        total: 0
      }
    };
  },
  mounted() {
    this.pagination.current = 1;
    this.getReceivables();
  },

  methods: {
    onSearch() {
      this.pagination.current = 1;
      this.getReceivables();
    },

    getReceivables() {

      const params = {
        search: this.search,
        page: this.pagination.current
      };
      axios
        .get(`/api/receivables`, { params })
        .then(({ data }) => {
          console.log(data);
          this.receivables = data.data;
          this.pagination.current = data.current_page;
          this.pagination.total = data.last_page;
          this.isLoadingTable = false;
        })
        .catch(error => {
          notify.error(error.response.data.message);
          this.isLoadingTable = false;
        });

    },
    onPageChange() {
      this.getReceivables();
    },



    // save() {
    //   if (this.editedIndex > -1) {
    //     Object.assign(this.clients[this.editedIndex], this.editedItem);
    //     console.log(this.editedItem);
    //   } else {
    //     const data = {
    //       numero_documento: this.editedItem.numero_documento,
    //       primer_nombre: this.editedItem.primer_nombre,
    //       segundo_nombre: this.editedItem.segundo_nombre,
    //       direccion: this.editedItem.direccion,
    //       telefono: this.editedItem.telefono,
    //       celular: this.editedItem.celular,
    //       correo: this.editedItem.correo
    //     };

    //     console.log("ESTO ES EDITED ITEM", this.editedItem);

    //     if (!this.editedItem.numero_documento) {
    //       notify.error("Ingrese número de documento");
    //       return;
    //     }

    //     if (!this.editedItem.primer_nombre) {
    //       notify.error("Ingrese Nombre/Razón social ");
    //       return;
    //     }

    //     if (!this.editedItem.segundo_nombre) {
    //       notify.error("Ingrese Apellidos/Nombre comercial");
    //       return;
    //     }

    //     if (!this.editedItem.direccion) {
    //       notify.error("Ingrese dirección");
    //       return;
    //     }
    //     if (this.editedItem.direccion === " ") {
    //       notify.error("Ingrese dirección");
    //       return;
    //     }

    //     this.isLoading = true;

    //     axios
    //       .post("/api/client/create", data)
    //       .then(({ data }) => {
    //         notify.showCool(data.message);
    //         this.reset();
    //         this.close();
    //         this.getReceivables();
    //         this.isLoadingTables = false;
    //       })
    //       .catch(error => {
    //         notify.error(error.response.data.message);
    //         this.isLoadingTable = false;
    //       });
    //   }
    // },

    reset() {
 
        // (this.editedItem["primer_nombre"] = ""),
        // (this.editedItem["segundo_nombre"] = ""),
        // (this.editedItem["telefono"] = ""),
        // (this.editedItem["celular"] = ""),
        // (this.editedItem["correo"] = ""),
        // (this.editedItem["direccion"] = "");
    }
  }
};
</script>
