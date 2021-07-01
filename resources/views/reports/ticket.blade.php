<!DOCTYPE html>
<html lang="es">

<head>
	<meta charset="utf-8">
	<title>Ticket</title>
	<link rel="stylesheet" href="css/pdf.css" media="all" />
	<style>
		.title {
			display: inline-block;
		}

		.empresa {
			display: inline-block;
		}
	</style>
</head>

<body>
	<header>
		<div id="logo">
			<img src="img/logo.jpg" />
			<div class="title">
				<h2 class="name text-left"><strong> COTIZACIÓN N° {{$proforma->documento}}</strong></h2>
				<div class="text-left">{{ $proforma->fecha}} {{$proforma->hora}}</div>
			</div>
		</div>
	</header>
	<main>
		<div id="details" class="row">
			<div id="client" class="column">
				<div>
					<div class="to"><strong>F.Emision:</strong> {{ $proforma->fecha}}</div>
					<div class="to"><strong>Cliente:</strong> {{ $proforma->client->dni.' '.$proforma->client->cliente }}</div>
					<div class="to"><strong>Direccion:</strong> {{ $proforma->observac}}</div>
					<div class="to"><strong>Telefono:</strong> {{ $proforma->client->celular }}</div>
					<div class="to"><strong>Atencion:</strong> {{ $proforma->atencion}}</div>
				</div>
			</div>
		</div>
		<table class="table">
			<thead>
				<tr>
					<th style="width: 30px">Item</th>
					<th style="width: 40px">Codigo</th>
					<th style="width: 30px">Cant.</th>
					<th class="desc">Descripcion</th>
					<th style="width: 60px">Uni. Med</th>
					<th style="width: 5pc">Marca</th>
					<th class="desc">Precio Unit</th>
					<th class="desc">Desc. %</th>
					<th>Importe</th>
				</tr>
			</thead>
			<tbody>

				@foreach ($proforma->details as $detail)
				<tr>
					<td class="no"> {{ $loop->iteration < 9 ? '0':'' }}{{ $loop->iteration }}</td>
					<td class="no">{{ $detail->codigo }}</td>
					<td class="no">{{ number_format($detail->cantidad, 0) }}</td>
					<td class="no">{{ $detail->descripcion }}</td>
					<td class="text-center">{{ $detail->medida }}</td>
					<td class="no">{{ $detail->marca }}</td>
					<td class="text-right">{{ number_format($detail->precio, 2) }}</td>
					<td class="text-center">{{ $detail->descuento }}</td>
					<td>{{ number_format($detail->precio * $detail->cantidad, 2) }}</td>
				</tr>
				@endforeach
			</tbody>
			<tfoot>
				<tr>
					<td colspan="6" class="text-uppercase">Dos mil Treinta y nueve con 00/100 Soles</td>
					<td colspan="2" class="text-right">Neto:</td>
					<td class="total">{{ number_format($proforma->total, 2) }}</td>
				</tr>
				<tr class="back">
					<td colspan="6">
						<div class="conditions">Condiciones generales</div>
					</td>
					<td colspan="2" class="text-right data">
						<div>SUBTOTAL:</div>
					</td>
					<td>
						<div>{{ number_format($proforma->subtotal, 2) }}</div>
					</td>
				</tr>
				<tr class="back">
					<td colspan="6">
						<div class="to">
							<span class="bolder">Condicion de pago:</span>
							<span class="text-uppercase">{{ $proforma->condicion}}</span>
						</div>
					</td>
					<td colspan="2" class="text-right data">
						<div>IGV:</div>
					</td>
					<td>
						<div>{{ number_format($proforma->igv, 2) }}</div>
					</td>
				</tr>
				<tr class="back">
					<td colspan="6">
						<div class="to">
							<span class="bolder">Observaciones:</span>
							<span class="text-uppercase">{{ $proforma->observac}}</span>
						</div>
					</td>
					<td colspan="2" class="text-right data">
						<div>TOTAL: S/</div>
					</td>
					<td>
						<div>{{ number_format($proforma->total, 2) }}</div>
					</td>
				</tr>
			</tfoot>
		</table>
	</main>
</body>

</html>