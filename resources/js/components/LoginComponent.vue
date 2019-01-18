<template>
  <v-container bg fill-height grid-list-md text-xs-center>
    <v-layout row wrap>
      <v-flex xs12 sm8 offset-sm2 md8 offset-md2>
        <v-card>
          <v-card-title class="headline font-weight-regular blue-grey white--text">Login</v-card-title>
          <v-card-text>
            <v-form>
              <v-text-field prepend-icon="person" name="Username" label="Username"></v-text-field>
              <v-text-field prepend-icon="lock" name="Password" label="Password" type="password"></v-text-field>
              <v-card-actions>
                <v-btn primary large block>Login</v-btn>
              </v-card-actions>
              <v-btn color="orange darken-2" dark>
                <v-icon dark left>arrow_back</v-icon>VOLVER
              </v-btn>
            </v-form>
          </v-card-text>
        </v-card>
      </v-flex>
    </v-layout>
  </v-container>
</template>


