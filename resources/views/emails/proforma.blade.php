@component('mail::message')
# Su proforma N0 {{ $proforma->documento }} esta lista

Puede descargar la proforma en el siguiente link:

@component('mail::button', ['url' => env('APP_URL') ."/proforma/". $proforma->documento])
  Descargar proforma
@endcomponent


Gracias,<br>
{{ config('app.name') }}
@endcomponent
