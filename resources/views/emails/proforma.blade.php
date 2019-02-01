@component('mail::message')
# Su proforma #123 esta lista

Puede descargar la proforma en el siguiente link:

@component('mail::button', ['url' => 'https://sistemadeproformas.com'])
Descargar proforma
@endcomponent


Gracias,<br>
{{ config('app.name') }}
@endcomponent
