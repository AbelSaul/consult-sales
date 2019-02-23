@extends('layouts.app')

@section('content')
<div class="container">
  <edit-proforma :proforma="{{ $proforma }}" ></edit-proforma>
</div>
@endsection
