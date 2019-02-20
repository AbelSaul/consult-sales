@extends('layouts.app')

@section('content')
<div class="container">
  <list-proformas></list-proformas>
  <div class="head">
    <a class="white--text" href="/">
      <v-btn slot="activator" color="success" dark class="mb-2">
        Nueva Proforma
      </v-btn>
    </a>
  </div>
  <table class="table table-hover">
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
          <td>{{ $proforma->seller ?  $proforma->seller->nombre : '----'}}</td>
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
  <div class="d-flex">
    {{ $proformas->links() }}
  </div>
</div>
@endsection

<style>
body {
  /* color: #606c76; */
}
table {
  font-size: 15px;
}
.head {
    text-align: right;
    width: 100%;
    padding: 1em 0 !important;
}

.head button{
  margin: 0;
}

.pagination {
  justify-content: center;
}


</style>
