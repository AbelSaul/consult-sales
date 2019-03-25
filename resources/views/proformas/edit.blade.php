@extends('layouts.app')

@section('content')
<div class="container">
  <edit-proforma :proforma="{{ $proforma }}"  :selected_detail="{{ $selected_detail }}"  ></edit-proforma>
</div>
@endsection
