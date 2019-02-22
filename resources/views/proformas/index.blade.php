@extends('layouts.app')

@section('content')
<div class="container">
  {{-- <div class="head">
    <a class="white--text" href="/">
      <v-btn slot="activator" color="success" dark class="mb-2">
        Nueva Proforma
      </v-btn>
    </a>
  </div> --}}
  <list-proformas></list-proformas>
</div>
@endsection

<style>
.head {
    text-align: right;
    width: 100%;
    padding: 1em 0 !important;
}

.head button{
  margin: 0;
}

</style>
