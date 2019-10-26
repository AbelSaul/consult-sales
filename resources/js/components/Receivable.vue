
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
            v-on:keyup="onSearchReceivable"
          ></v-text-field>
        </v-flex>
      </v-layout>
       <v-dialog v-model="dialogDetailsCharges" max-width="1000px">
        <v-card>
          <v-card-title>
            <span class="headline">Detalle de cobranza</span>
          </v-card-title>
          <v-card-text>
            <v-container grid-list-md>
              <v-data-table
                    :headers="headersDetailsCharges"
                    :items="detailsCharges"
                    :loading="isLoadingTableDetailsCharges"
                    class="elevation-1"
                    hide-actions
                  >
                    <template slot="items" slot-scope="props">
                      <td class="text-xs-center">{{ props.item.fecha_cob}}</td>
                      <td class="text-xs-center">{{ props.item.documento_ref}}</td>
                      <td class="text-xs-center">{{ props.item.forma_pago }}</td>
                      <td class="text-xs-center">{{ props.item.ref_pago }}</td>
                      <td class="text-xs-center">{{Number(props.item.monto ).toFixed(2)   }}</td>
                        <td class="text-xs-center">{{ props.item.seller ? props.item.seller.nombre : '' }}</td>
                      <td class="text-xs-center">{{ props.item.observacion }}</td>

                    </template>
                  </v-data-table>
                            <div class="total-flex">
            <div class="total-header elevation-1">
              <div>Total: </div>
              <div> {{Number(this.totalDetailsCharges).toFixed(2)}}</div>
            </div>
          </div>
            </v-container>
          </v-card-text>
          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn color="error darken-1" flat @click="closeDialogDetailsCharges">Cerrar</v-btn>
          </v-card-actions>
        </v-card>
      </v-dialog>

      <v-dialog v-model="dialogCharge" max-width="900px">
        <v-card>
          <v-card-title>
            <span class="headline">Documento a cobrar: {{document}}</span>
          </v-card-title>
          <v-card-text>
            <v-container grid-list-md>
              <v-layout wrap>
                
                <v-flex xs12 sm6 md4>
                  <v-text-field v-model="charge.monto" :rules="[rules.onlyNumbers]" label="Monto a Cobrar"></v-text-field>
                </v-flex>
     

                                <v-flex xs12 sm6 md4>
                 <v-autocomplete
                    v-model="charge.cobrador"
                    :items="sellers"
                    :loading="isLoadingSeller"
                    :search-input.sync="searchSeller"
                    :label="`Cobrador`"
                    no-data-text="No hay ningun cobrador"
                    persistent-hint
                    item-text="nombre"
                    item-value="idpersonal"
                    return-object
                    disabled
                  ></v-autocomplete>
                </v-flex>
                <v-flex xs12 sm6 md4>
                <label for="">Fecha de pago</label>
                <datetime type="datetime" v-model="charge.fecha_pago" use12-hour></datetime>
                
                </v-flex>
                <v-flex xs12 sm6 md4>
                              <v-combobox
                    :label="`Forma de pago`"
                    v-model="charge.forma_pago"
                    :items="conditions"
                    clearable
                  ></v-combobox>
                </v-flex>
           <v-flex xs12 sm6 md4>
                  <v-text-field
                    v-model="charge.referencia_pago"
                    label="Referencia de pago"
                  ></v-text-field>
                </v-flex>

                <v-flex xs12 sm6 md4>
                  <v-text-field v-model="charge.observacion" label="Observación"></v-text-field>
                </v-flex>
              </v-layout>
            </v-container>
          </v-card-text>
          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn color="error darken-1" flat @click="closeDialogNewChage">Cerrar</v-btn>
            <v-btn color="success darken-1" flat @click="save">Guardar</v-btn>
          </v-card-actions>
          <loader v-if="isLoading"></loader>
        </v-card>
      </v-dialog>
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
        <td  class="text-xs-center">{{  props.item.client.ruc  }}</td>
        <td  class="text-xs-center">{{  props.item.client.cliente }}</td>
        <td class="text-xs-center">{{ props.item.moneda }}</td>
        <td class="text-xs-center">{{ Number(props.item.total).toFixed(2) }}</td> 
        <td class="text-xs-center">{{ Number(props.item.saldo).toFixed(2) }}</td>
        <td class="text-xs-center">{{ Number(props.item.saldo_cred).toFixed(2) }}</td>
        <td class="text-xs-center">{{ props.item.seller ? props.item.seller.nombre : '' }}</td>

        <td class="justify-center layout px-0">
          <v-icon ligth @click="newCharge(props.item.idcobro,props.item.documento, props.item.saldo, props.item.client.cliente)">edit</v-icon>
          <v-icon ligth @click="getDetailsCharges(props.item.idcobro, props.item.documento)">list</v-icon>
        </td>
 

      </template>
    </v-data-table>
                                <div class="total-flex">
            <div class="total-header elevation-1">
              <div>Total Saldo Deudor: </div>
              <div> {{Number(this.totalReceivables).toFixed(2)}}</div>
            </div>
          </div>

    <div class="text-xs-center pt-2">
      <v-pagination v-model="pagination.current" :length="pagination.total" @input="onPageChange"></v-pagination>



    </div>
  </div>


</template>

<script>

import { DateTime as LuxonDateTime } from "luxon";

export default {

  data() {
    return {

      search: "",
      receivables: [],
      detailsCharges: [],
      sellers:[],
      searchSeller: null,
      isLoadingSeller: false,
      sellerDefault: {},
      isLoading: false,
      isLoadingTable: true,
      isLoadingTableDetailsCharges : true,
      dialogDetailsCharges : false,
      dialogCharge : false,
      idcobro: 0,
      cliente: "",
      document:"",
      conditions: ["Efectivo", "Depósito","Transferencia"],
      totalReceivables : 0,
      totalDetailsCharges: 0,
      headers: [
        { text: "Fecha Emi.", value: "fecha" },
        { text: "Fecha Vto.", value: "fecha_vto" },
        { text: "Tipo", value: "tipodoc" },
        { text: "Documento", value: "documento" },
        { text: "RUC/DNI", value: "client.ruc" },
        { text: "Cliente", value: "client.client" },
        { text: "Moneda", value: "moneda" },
        { text: "Total", value: "total" },
        { text: "Saldo Deudor", value: "saldo" },
        { text: "Saldo Favor", value: "saldo_cred"},
        { text: "Vendedor", value: "seller.nombre"},
        { text: "Acciones", value: "action", sortable: false }
        
      ],
      headersDetailsCharges: [
        { text: "Fecha Pago", value: "fecha_cob" },
        { text: "Documento", value: "documento_ref" },
        { text: "Forma de pago.", value: "forma_pago" },
        { text: "Ref. Pago", value: "referencia_pago" },
        { text: "Monto.", value: "monto" },
        { text: "Cobrador", value: "cobrador" },
        { text: "Observación", value: "observacion" },
      ],
       rules:{
         onlyNumbers(value){
        console.log('validating value');
        if (/^\d+(\.\d{1,4})?$/.test(value)){
          return true;
        }
        return 'Ingrese un monto válido '
      }
    },

      charge: {
        monto: "",
        referencia_pago: "",
        fecha_pago: LuxonDateTime.local().toISO(),
        forma_pago: "",
        cobrador: "",
        observacion: ""
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
    this.getSellers();

  },


  watch: {
    searchSeller(val) {
      if (this.sellerDefault.nombre === val) return;
      this.isLoadingSeller = true;
      axios.get(`/api/sellers?search=${val}`).then(({ data }) => {
        this.isLoadingSeller = false;
        this.sellers = data;
      });
    },
  },
  methods: {
    onSearchReceivable() {
      this.pagination.current = 1;
      this.getReceivables();
    },

    getSellers(){
    axios.get("/api/seller_user").then(({ data }) => {
      this.sellerDefault = data;
      this.sellers = [data];
      this.charge.cobrador = data;
    });
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
          this.calculateTotalReceivables();
        })
        .catch(error => {
          notify.error(error.response.data.message);
          this.isLoadingTable = false;
        });

    },

    calculateTotalReceivables(){
      if(this.receivables.length > 0){
     const saldo = this.receivables.map(dc => dc.saldo).reduce((accumulator, currentValue) => parseFloat(accumulator) + parseFloat(currentValue));
          this.totalReceivables = saldo;
      }else{
        this.totalReceivables = 0;
      }
    },

    newCharge(idcobro,documento, saldoDeudor, cliente){
       this.dialogCharge = true;
       this.document = documento;
       this.idcobro = idcobro;
       this.charge.monto = Number(saldoDeudor).toFixed(2);
       this.cliente = cliente;
    },
    getDetailsCharges(idcobro) {
       this.dialogDetailsCharges = true;
      const params = {
        idcobro
      };
      axios
        .get(`/api/details-charges`, { params })
        .then(({ data }) => {
          console.log(data);
          this.detailsCharges = data;
          this.isLoadingTableDetailsCharges = false;
          this.calculateTotalDetailsCharges();
        
        })
        .catch(error => {
          notify.error(error.response.data.message);
          this.isLoadingTableDetailsCharges = false;
        });

    },

    calculateTotalDetailsCharges(){
      if(this.detailsCharges.length > 0){
     const saldo = this.detailsCharges.map(dc => dc.monto).reduce((accumulator, currentValue) => parseFloat(accumulator) + parseFloat(currentValue));
          this.totalDetailsCharges = saldo;
      }else{
        this.totalDetailsCharges = 0;
      }
    },

    formatDateYearMonthDay(date) {
      return date.getFullYear() + "-" 
      + (date.getMonth() + 1 < 10 ? '0'+ date.getMonth() + 1 : date.getMonth() + 1) + "-" 
      + (date.getDate() < 10 ? '0' + date.getDate() : date.getDate());
    },

    formatHourAmPm(date) {
      let hours = date.getHours();
      let minutes = date.getMinutes();
      let seconds = date.getSeconds();
      
      let ampm = hours >= 12 ? 'PM' : 'AM';
      hours = hours % 12;
      hours = hours ? hours : 12; 
      minutes = minutes < 10 ? '0'+minutes : minutes;
      seconds = seconds < 10 ? '0'+seconds : seconds;


      const strTime = hours + ':' + minutes +':' + seconds + ' ' + ampm;
      
      return strTime;
    },

    onPageChange() {
      this.getReceivables();
    },

    closeDialogDetailsCharges() {
      this.dialogDetailsCharges = false;
    },
    closeDialogNewChage() {
      this.dialogCharge = false;
    },


    save() {
    
        const fecha = new Date(this.charge.fecha_pago);
       
        const data = {
          idcobro:this.idcobro,
          cliente: this.cliente,
          monto: this.charge.monto,
          referencia_pago: this.charge.referencia_pago,
          fecha_pago: this.formatDateYearMonthDay(fecha),
          hora_pago: this.formatHourAmPm(fecha),
          forma_pago: this.charge.forma_pago,
          cobrador: this.charge.cobrador.idpersonal,
          observacion: this.charge.observacion,
       
        };

        if (!this.charge.monto || isNaN(this.charge.monto || this.charge.monto <=0 )) {
          notify.error("Ingrese un monto validó");
          return;
        }

        if (!this.charge.referencia_pago) {
          notify.error("Ingrese referencia de pago ");
          return;
        }

        if (!this.charge.fecha_pago) {
          notify.error("Ingrese fecha de pago");
          return;
        }

        if (!this.charge.forma_pago) {
          notify.error("Ingrese forma de pago");
          return;
        }

        if (!this.charge.cobrador) {
          notify.error("Ingrese cobrador");
          return;
        }

        if (!this.charge.observacion) {
          notify.error("Ingrese observación");
          return;
        }

        this.isLoading = true;
        this.isLoadingTable = true;


        console.log("Esto es charge", data);
        axios
          .post("/api/charge/create", data)
          .then(({ data }) => {
            notify.showCool(data.message);
            this.reset();            
            this.closeDialogNewChage();
            this.isLoading = false;            
            this.getReceivables();
            this.isLoadingTable = false;

          })
          .catch(error => {
            notify.error(error.response.data.message);
            this.isLoadingTable = false;
            this.isLoading = false;
          });
      
    },

    reset() {
        (this.charge["monto"] = ""),
        (this.charge["referencia_pago"] = ""),
        (this.charge["fecha_pago"] =  LuxonDateTime.local().toISO()),
        (this.charge["forma_pago"] = ""),
        (this.charge["observacion"] = "");
    }
  }
};
</script>
