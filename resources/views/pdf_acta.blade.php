<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Acta de Entrega #{{ $acta->numero }}</title>
    <style>
        body {
            font-family: sans-serif;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        .celda1 {
            font-size: 16px;
            text-align: left;
            height: 2%;
            border: solid;
        }

        .celda2 {
            font-size: 16px;
            text-align: right;
            height: 2%;
            border: solid;
        }

        p {
            text-align: right;
        }
    </style>
</head>

<body>
    <table style="width: 100%;">
        <tr>
            <td style="width: 10%;">
                <center><img src="{{ public_path('imagenes/medicina.png') }}" style="width:100px;height:100px;">
                </center>
            </td>
            <td style="text-align: center; width: 60%">
                <label><strong style="font-size: 20px;"> INSTITUTO DE ENFERMEDADES DIGESTIVAS</strong></label><br>
                <label><strong>RUC:</strong>0912345678001</label><br>
                <label><strong>Dir:</strong> Av. Abel R. Castillo S/N y Av Juan Tanca Marengo</label><br>
            </td>
            <td style="text-align: center; width: 30%;">
                <strong style="font-size: 23px;">Acta de Entrega</strong><br>
                <label style="font-size: 22px; color: red">{{ $acta->numero }}</label>
            </td>
        </tr>
    </table>
    <table>
        <tr>
            <td colspan="2"><strong>Paciente:</strong> {{ $acta->paciente->nombre1 }} {{ $acta->paciente->nombre2 }} {{ $acta->paciente->apellido1 }} {{ $acta->paciente->apellido2 }}</td>
            <td><strong>Cedula:</strong> {{ $acta->id_paciente}}</td>
        </tr>
        <tr>
            <td><strong>Direccion:</strong> {{ $acta->paciente->direccion }}</td>
            <td><strong>Telefono:</strong> {{ $acta->paciente->telefono}}</td>
            <td><strong>Fecha:</strong> {{ \Carbon\Carbon::now()->format('d/m/Y') }}</td>
        </tr>
    </table><br>
    <table>
        <tr>
            <th style="width: 50%; text-align: center !important" class="celda1">Producto</th>
            <th style="width: 15%; text-align: center !important" class="celda2">Cantidad</th>
            <th style="width: 15%; text-align: center !important" class="celda2">Precio</th>
            <th style="width: 15%; text-align: center !important" class="celda2">Valor total</th>
        </tr>
        @foreach($acta->detalles as $detalle)
        <tr>
            <td class="celda1">{{ $detalle->medicina->nombre }}</td>
            <td class="celda2">{{ $detalle->cantidad }}</td>
            <td class="celda2">$ {{ $detalle->precio }}</td>
            <td class="celda2">$ {{ $detalle->total }}</td>
        </tr>
        @endforeach
        @if(!is_null($acta->detalles))
        @if(count($acta->detalles) < 20)
            @for($i=count($acta->detalles); $i <=25; $i++)
                <tr>
                <td class="celda1"> </td>
                <td class="celda2"> </td>
                <td class="celda2"> </td>
                <td class="celda1"> </td>
                </tr>
                @endfor
                @endif
                @endif
    </table>

    <table style="width: 40%; margin-left: auto; text-align: right;">
        <tr>
            <td><strong>Subtotal 15%:</strong></td>
            <td>$ 0.00</td>
        </tr>
        <tr>
            <td><strong>Subtotal 0%:</strong></td>
            <td>$ {{ number_format($acta->total, 2) }}</td>
        </tr>
        <tr>
            <td><strong>Total Final:</strong></td>
            <td><strong>$ {{ number_format($acta->total, 2) }}</strong></td>
        </tr>
    </table><br><br>
    <table>
        <tr>
            <td style="text-align: left !important; "><span>Firma Autorizada: ____________________</span></td>
            <td style="text-align: left !important; "><span>Recibi Conforme: _____________________</span></td>
        </tr>
    </table>
</body>

</html>