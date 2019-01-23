<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'Consulta de Proformas') }}</title>
        <link rel="shortcut icon" href="https://storage.googleapis.com/builderbook/favicon32.png">
        <link href='https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Material+Icons' rel="stylesheet">
        <link href="https://unpkg.com/vuetify/dist/vuetify.min.css" rel="stylesheet">
    </head>
    <body>
        <div id="app">
            <v-toolbar>
              <v-toolbar-side-icon></v-toolbar-side-icon>
              <v-toolbar-title>Title</v-toolbar-title>
              <v-spacer></v-spacer>
              <v-toolbar-items class="hidden-sm-and-down">
                <v-btn flat>Link One</v-btn>
                <v-btn flat>Link Two</v-btn>
                <v-btn flat>Link Three</v-btn>
              </v-toolbar-items>
            </v-toolbar>
            <v-app>
              @yield('content')
            </v-app>
        </div>
        <script src="{{ asset('js/app.js') }}"></script>
    </body>
</html>
