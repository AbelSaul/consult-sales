<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <title>Ticket</title>
        <link rel="stylesheet" href="css/pdf.css" media="all" />
    </head>
<body>
    <header class="row">
		<div id="logo" class="column">
			<img src="img/logo.png" />
		</div>
    	<div id="company" class="column">
			<h2 class="name">NAME EMPRESA</h2>
			<div>Sistema de proformas</div>
			<div><a href="mailto:proformas@gmail.com">proformas@gmail.com</a></div>
      	</div>
      </div>
    </header>
    <main>
      	<div id="details" class="row">
			<div id="client" class="column">
				<div>
					<div class="name">Nombre completo</div>
					<div class="to">Dni: dni</div>
					<div class="to">Código: akgu</div>
					<div class="to">Tipo: tupe</div>
					<div class="to">Email: <a href="mailto:davis.con.fab@gmail.com">davis.con.fab@gmail.com</a></div>
				</div>
        	</div>
			<div id="invoice" class="column">
				<h1>Proforma #123123</h1>
				<div class="date">Fecha de pago: fecha</div>
			</div>
      	</div>
      	<table class="table">
			<thead>
				<tr>
					<th class="no" width="50px">#</th>
					<th class="desc">SERVICIO</th>
					<th>COSTO</th>
				</tr>
			</thead>
			<tbody>
				{{-- @foreach ($sale->services()->get() as $service)
					@if(!$service->selected_concept)
						<tr>
							<td class="no"> {{ $loop->iteration < 9 ? '0':'' }}{{ $loop->iteration }}</td>
							<td class="desc">{{ $service->title }}</td>
							<td class="total">S/ {{ Field::format($service->cost) }}</td>
						</tr>
					@else
						<tr>
							<td class="no"> {{ $loop->iteration < 9 ? '0':'' }}{{ $loop->iteration }}</td>
							<td class="desc">{{ $service->title .' / costo de '.$service->pivot->quantity. " " .Field::conceptName($service->selected_concept) }}</td>
							<td class="total">S/ {{Field::cost_extra($service->id, $service->pivot->quantity) }}</td>
						</tr>
					@endif
				@endforeach --}}
			</tbody>
			<tfoot>
				<tr>
					<td colspan="2">TOTAL:</td>
					<td class="total">S/ 123 </td>
				</tr>
			</tfoot>
      	</table>
    </main>
</body>
</html>
