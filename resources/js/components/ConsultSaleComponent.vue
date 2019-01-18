<template>
  <v-container bg fill-height grid-list-md text-xs-center>
    <v-layout row wrap>
      <v-flex xs12 sm8 offset-sm2 md8 offset-md2>
        <v-card>
          <v-card-title class="headline font-weight-regular blue-grey white--text">Inicio</v-card-title>
          <v-card-text>
            <v-subheader class="pa-0">INGRESA TÚ RUC</v-subheader>
            <v-autocomplete
              v-model="model"
              :items="rucs"
              :label="`RUC`"
              persistent-hint
              item-text="ruc"
              item-value="database"
              no-data-text="No se encontro este RUC"
            ></v-autocomplete>
            <v-btn color="success darken-1" @click="onSubmit" dark>SIGUIENTE</v-btn>
          </v-card-text>
        </v-card>
      </v-flex>
    </v-layout>
  </v-container>
</template>

<script>
export default {
  data() {
    return {
      model: null,
      rucs: []
    };
  },
  mounted() {
    axios.get("/api/connections").then(({ data }) => {
      this.rucs = data;
    });
  },
  methods: {
    onSubmit: function() {
      console.log(this.model);
    }
  }
};
</script>
