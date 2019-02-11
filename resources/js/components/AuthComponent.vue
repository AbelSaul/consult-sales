<template>
  <v-container bg grid-list-md text-xs-center fill-height class="full-heigth">
    <v-layout row wrap align-center>
      <v-flex xs12 sm8 offset-sm2 md6 offset-md3>
        <v-card v-if="page === 'ruc'">
          <v-card-title class="headline font-weight-regular blue-grey white--text">Iniciar sesión</v-card-title>
          <v-card-text>
            <v-subheader class="pa-0">INGRESA TÚ RUC</v-subheader>
            <v-text-field v-model="ruc" label="RUC" required></v-text-field>
            <v-btn color="success darken-1" outline @click="onNext" :disabled="!ruc">SIGUIENTE</v-btn>
          </v-card-text>
        </v-card>
        <v-card v-else>
          <v-card-title class="headline font-weight-regular blue-grey white--text">Iniciar sesión</v-card-title>
          <v-card-text>
            <v-form @submit="onLogin">
              <p class="head">RUC seleccionado:
                <v-chip label>{{ userInfo.ruc }}</v-chip>
              </p>
              <v-text-field v-model="user" prepend-icon="person" name="Usuario" label="Usuario"></v-text-field>
              <v-text-field
                v-model="password"
                prepend-icon="lock"
                name="Contraseña"
                label="Contraseña"
                type="password"
              ></v-text-field>
              <v-card-actions style="justify-content: center;">
                <v-btn outline color="orange darken-2" dark @click="onBack">
                  <v-icon dark left>arrow_back</v-icon>VOLVER
                </v-btn>
                <v-btn outline color="success darken-1" type="submit" @click="onLogin">Login</v-btn>
              </v-card-actions>
            </v-form>
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
      userInfo: null,
      user: null,
      password: null,
      ruc: null,
      page: "ruc"
    };
  },
  mounted() {},
  methods: {
    onNext: function() {
      axios
        .get(`/api/validate_ruc?ruc=${this.ruc}`)
        .then(({ data }) => {
          this.userInfo = data;
          this.page = "login";
          notify.showCool("RUC encontrado");
        })
        .catch(error => {
          notify.error(error.response.data.message);
        });
    },
    onBack: function() {
      this.page = "ruc";
    },
    onLogin: function(e) {
      e.preventDefault();
      if (this.user && this.password) {
        const data = {
          basedata: this.userInfo.basedata,
          user: this.user,
          password: this.password
        };
        console.log(data);
        axios
          .post("/api/login", data)
          .then(({ data }) => {
            notify.showCool(data.message);
            window.location = document.head.querySelector(
              'meta[name="api-base-url"]'
            ).content;
          })
          .catch(error => {
            notify.error(error.response.data.message);
          });
      } else {
        notify.error("Complete los campos");
      }
    }
  }
};
</script>

<style>
.head {
  border-bottom: 1px solid #ddd;
  padding-bottom: 8px;
}
@media (min-width: 1000px) {
  .full-heigth {
    height: 100vh;
  }
}

@media (max-width: 800px) {
  .full-heigth {
    margin-top: 4em;
  }
}
</style>
