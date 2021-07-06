<html>

<head>
    <link rel="stylesheet" href="css/report.css">
</head>

<body>
    <table class="full-width">
        <tr>
            <td width="20%">
                <div class="company_logo_box">
                    <img src="img/logo.jpg" class="company_logo" style="max-width: 150px;">
                </div>
            </td>
            <td width="50%" class="pl-3">
                <div class="text-left">
                    <h4 class="m-0">{{ $empresa->empresa }}</h4>
                    <h5 class="m-0">{{ 'RUC '.$empresa->ruc }}</h5>
                    <h6 class="m-0"> {{$empresa->direccion}} </h6>
                    <h6 class="m-0"> {{$empresa->telefono}} </h6>
                    <h6 class="m-0"> {{$empresa->correo}} </h6>
                </div>
            </td>
            <td width="30%" class="border-box py-4 px-2 text-center">
                <h5 class="m-0 text-center">COTIZACIÓN</h5>
                <h3 class="m-0 text-center">{{$proforma->documento}}</h3>

            </td>
        </tr>
    </table>

    <table class="full-width mt-5">
        <tr>
            <td width="15%">Fecha de emisión:</td>
            <td width="45%">{{ $proforma->fecha}} {{$proforma->hora}}</td>
        </tr>
        <tr>
            <td width="15%">Cliente:</td>
            <td width="45%">{{ $proforma->client->dni.' '.$proforma->client->cliente }}</td>
        </tr>

        <tr>
            <td class="align-top">Dirección:</td>
            <td colspan="2">
                {{ $proforma->observac}}
            </td>
            </td>
        </tr>
        <tr>
            <td class="align-top">Teléfono:</td>
            <td colspan="2">
                {{ $proforma->client->celular }}
            </td>
        </tr>
        <tr>
            <td class="align-top">Atención:</td>
            <td colspan="2">
                {{ $proforma->atencion }}
            </td>
        </tr>
    </table>

    <table class="full-width mt-10 mb-10">
        <thead class="">
            <tr class="bg-grey">
                <th class="border-top-bottom text-center py-2" width="8%">Item</th>
                <th class="border-top-bottom text-center py-2" width="12%">Código</th>
                <th class="border-top-bottom text-center py-2" width="8%">Cant.</th>
                <th class="border-top-bottom text-left py-2">Descripción</th>
                <th class="border-top-bottom text-left py-2" width="12%">Uni. Med</th>
                <th class="border-top-bottom text-right py-2" width="8%">Marca</th>
                <th class="border-top-bottom text-right py-2" width="12%">Precio Unit</th>
                <th class="border-top-bottom text-right py-2" width="12%">Desc. %</th>
                <th class="border-top-bottom text-right py-2" width="12%">Importe</th>

            </tr>
        </thead>
        <tbody>
            @foreach($proforma->details as $detail)
            <tr>
                <td class="text-center"> {{ $loop->iteration < 9 ? '0':'' }}{{ $loop->iteration }} </td>
                <td class="text-right">{{ $detail->codigo }}</td>
                <td class="text-center">{{ number_format($detail->cantidad, 0) }}</td>
                <td>{{ $detail->descripcion }}</td>}
                <td class="text-left">{{ $detail->medida }}</td>
                <td class="text-center">{{ $detail->marca }}</td>
                <td class="text-right">{{ number_format($detail->precio, 2) }}</td>
                <td class="text-right">{{ $detail->descuento }}</td>
                <td class="text-right">{{ number_format($detail->precio * $detail->cantidad, 2) }}</td>
            </tr>
            <tr>
                <td colspan="9" class="border-bottom"></td>
            </tr>
            @endforeach
            <tr>
                <td colspan="6" class="text-uppercase"></td>
                <td colspan="2" class="text-right font-bold">NETO:</td>
                <td class="text-right font-bold">{{ number_format($proforma->total, 2) }}</td>
            </tr>
            <tr>
                <td colspan="6">
                    <div class="font-bold">Condiciones generales</div>
                </td>
                <td colspan="2" class="text-right font-bold">
                    <div>SUBTOTAL:</div>
                </td>
                <td class="text-right font-bold">
                    {{ number_format($proforma->subtotal, 2) }}
                </td>
            </tr>
            <tr>
                <td colspan="6">
                    <span class="font-bold">Condicion de pago:</span>
                    <span class="text-uppercase">{{ $proforma->condicion }}</span>
                </td>
                <td colspan="2" class="text-right font-bold">
                    <div>IGV:</div>
                </td>
                <td class="text-right font-bold">
                    {{ number_format($proforma->igv, 2) }}
                </td>
            </tr>
            <tr>
                <td colspan="6">
                    <span class="font-bold">Observaciones:</span>
                    <span class="text-uppercase">{{ $proforma->observac }}</span>
                </td>
                <td colspan="2" class="text-right font-bold">
                    <div>TOTAL: S/</div>
                </td>
                <td class="text-right font-bold">
                    {{ number_format($proforma->total, 2) }}
                </td>
            </tr>


        </tbody>
    </table>
</body>

</html>