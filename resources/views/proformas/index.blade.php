@extends('layouts.app')

@section('content')
<v-container bg grid-list-md>
  <div class="head">
    <a class="white--text" href="/">
      <v-btn slot="activator" color="success" dark class="mb-2">
        Nueva Proforma
      </v-btn>
    </a>
  </div>
  <table>
    <thead>
      <th>ID</th>
      <th>Documento</th>
      <th>Vendedor</th>
      <th>Cliente</th>
      <th>Fecha</th>
      <th>Actions</th>
    </thead>
    <tbody>
      @foreach ($proformas as $proforma)
        <tr>
          <td>{{ $proforma->idproforma }}</td>
          <td>{{ $proforma->documento }}</td>
          <td>{{ $proforma->seller->nombre}}</td>
          <td>{{ $proforma->client->cliente }}</td>
          <td>{{ $proforma->fecha }}</td>
          <td>
            <a href="#"><v-icon ligth>remove_red_eye</v-icon></a>
            <a href="#"><v-icon ligth>edit</v-icon></a>
          </td>
        </tr>          
      @endforeach
    </tbody>
  </table>
</v-container>
@endsection

<style>
body {
  color: #606c76;
}

.head {
    text-align: right;
    width: 100%;
    padding: 1em 0
}

.head button{
  margin: 0;
}

table {
  border-spacing: 0;
  width: 100%;
  font-size: 14px;
}

td, th {
  border-bottom: 0.1rem solid #e1e1e1;
  padding: 1.2rem 1.5rem;
  text-align: left;
}

td:first-child, th:first-child {
  padding-left: 0;
}
</style>
