@extends('layouts.app')

@section('content')
<div class="container">
  <client :clients="{{ $clients }}"></client>
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
