<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="api-base-url" content="{{ url('') }}" />
        <title>{{ config('app.name', 'Consulta de Proformas') }}</title>
        <link rel="shortcut icon" href="https://storage.googleapis.com/builderbook/favicon32.png">
        <link href='https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Material+Icons' rel="stylesheet">
        {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/vuetify/2.0.19/vuetify.min.css"> --}}
        {{-- <link href="https://unpkg.com/vuetify/dist/vuetify.min.css" rel="stylesheet"> --}}
                {{-- <link href="{{ secure_asset('css/app.css') }}" rel="stylesheet"> --}}
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    </head>
    <body>
        <div id="app">
            @if(!isset($header))
                <v-toolbar color="primary" dark>
                    <v-toolbar-title><a class="white--text" href="{{ url('') }}">PEDIDOS</a></v-toolbar-title>
                    <v-spacer></v-spacer>
                    <v-toolbar-items class="hidden-sm-and-down">
                        <a class="white--text" href="{{ route('clientes-form') }}">
                            <v-btn flat class="full-height">
                                CLIENTES
                            </v-btn>
                        </a>
                        <a class="white--text" href="{{ route('consultas') }}">
                            <v-btn flat class="full-height">
                                CONSULTAS
                            </v-btn>
                        </a>
                        <a class="white--text" href="{{ route('logout') }}">
                            <v-btn flat class="full-height">
                                Cerrar sesion
                            </v-btn>
                        </a>
                    </v-toolbar-items>
                    <v-menu class="hidden-md-and-up">
                        <v-toolbar-side-icon slot="activator"></v-toolbar-side-icon>
                        <v-list >
                            <a class="white--text" href="{{ route('clientes-form') }}">
                                <v-btn flat>
                                    CLIENTES
                                </v-btn>
                            </a>
                            <a class="white--text" href="{{ route('consultas') }}">
                                <v-btn flat>
                                    CONSULTAS
                                </v-btn>
                            </a>
                            <a class="white--text" href="{{ route('logout') }}">
                                <v-btn flat>
                                    Cerrar sesion
                                </v-btn>
                            </a>
                        </v-list>
                    </v-menu>
                </v-toolbar>
            @endif
            <v-app>
              @yield('content')
            </v-app>
        </div>
        <script src="{{ asset('js/app.js') }}"></script>
    </body>
</html>
<style>
    .container {
        max-width: 1280px;
    }
    .v-toolbar__content, .v-toolbar__extension {
        max-width: 1280px;
        margin: auto;
        padding: 0 15px;
    }

    a {
        text-decoration: none;
    }

    .application--wrap {
        min-height: inherit;
    }

    .full-height {
        height: 100% !important;
    }
</style>
