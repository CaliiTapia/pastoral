<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $comprobante->cpbNum }}</title>

    <style>
        body {
            font-family: 'sans-serif', 'Courier New', Courier, monospace;
            font-size: 12px;
        }

        .left {
            ftext-align: left;
        }

        .right {
            text-align: right;
        }

        .center {
            text-align: center;
        }

        .justify {
            text-align: justify;
        }

        .border {
            border: 1px solid black;
        }

        .border-bottom {
            border-bottom: 1px solid #000000;
        }

        table {
            width: 100%;
        }

        .custom-bg {
            background-color: #c2c2c2a6;
        }

    </style>
</head>

<body>
    <table width="100%" style="width:100%" border="0">
        <tr>
            <td>{{ $comprobante->institucion->INNombre }}</td>
            <td class="right">Fecha comprobante: {{ date('d/m/Y', strtotime($comprobante->cpbFec)) }}</td>
        </tr>
        <tr>
            <td>RUT {{ $comprobante->institucion->INRut }}</td>
            <td class="right">Fecha ingreso: {{ date('d/m/Y H:m:s', strtotime($comprobante->cpbFecIn)) }}</td>
        </tr>
        <tr>
            <td>{{ $comprobante->institucion->INDireccion .' '. $comprobante->institucion->InCOCodigo }}</td>
            <td class="right">N° Cpbte: {{ str_pad($comprobante->cpbNum, 8, '0', STR_PAD_LEFT) }}</td>
        </tr>
        <tr>
            <td>ORGANIZACIÓN RELIGIOSA</td>
            <td class="right">
                Tipo Cpbte:
                @if ($comprobante->cpbTip === 'I')
                Ingreso
                @elseif ($comprobante->cpbTip === 'E')
                Egreso
                @elseif ($comprobante->cpbTip === 'T')
                Traspaso
                @else
                Tipo no registrado
                @endif
            </td>
        </tr>
        <tr>
            <td></td>
            <td class="right">
                Área negocio:
                {{ $comprobante->movimientos[0]->areaNegocio->areaNom }}
            </td>
        </tr>
        <tr>
            <td></td>
            <td class="right">
                Estado:
                @if ($comprobante->cpbEst === 'V')
                Vigente
                @elseif ($comprobante->cpbEst === 'P')
                Pendiente
                @elseif ($comprobante->cpbEst === 'A')
                Anulado
                @else
                Estado Invalido
                @endif
            </td>
        </tr>
    </table>
    <br>
    <table width="100%" style="width:100%" border="0">
        <tr>
            <td class="center">COMPROBANTE CONTABLE</td>
        </tr>
    </table>
    <br>
    <table width="100%" style="width:100%" border="0">
        <tr>
            <td>Glosa: {{ $comprobante->cpbGlo }}</td>
        </tr>
    </table>
    <table width="100%" style="width:100%" border="0">
        <tr class="border" style="border-bottom: 1px solid #000000;">
            <td class="border-bottom custom-bg">Código</td>
            <td class="border-bottom custom-bg">Cuenta</td>
            <td class="border-bottom custom-bg">C.Costo</td>
            <td class="border-bottom custom-bg">Debe</td>
            <td class="border-bottom custom-bg">Haber</td>
            <td class="border-bottom custom-bg">Glosa</td>
            <td class="border-bottom custom-bg">Auxiliar</td>
            <td class="border-bottom custom-bg">TD</td>
            <td class="border-bottom custom-bg">N°</td>
        </tr>
        @foreach($comprobante->movimientos as $movimiento)
        <tr>
            <td class="border-bottom">{{ $movimiento->cuenta->pctCod }}</td>
            <td class="border-bottom">{{ $movimiento->cuenta->pctNombre }}</td>
            <td class="border-bottom right">
                {{ $movimiento->centroCosto != null ? $movimiento->centroCosto->ccCod : '' }}
            </td>
            <td class="border-bottom right">{{ '$ ' . number_format(floor($movimiento->movDebe), ...[0, '', '.']) }}
            </td>
            <td class="border-bottom right">{{ '$ ' . number_format(floor($movimiento->movHaber), ...[0, '', '.']) }}
            </td>
            <td class="border-bottom">{{ $movimiento->movGlosa }}</td>
            <td class="border-bottom center">
                {{ $movimiento->auxiliar != null ? $movimiento->auxiliar->codAux : '' }}
            </td>
            <td class="border-bottom">
                {{ $movimiento->tipoDocumento != null ? $movimiento->tipoDocumento->TipDoc : '' }}
            </td>
            <td class="border-bottom">{{ $movimiento->movNum }}</td>
        </tr>
        @endforeach
        <tr>
            <td class="custom-bg">Totales</td>
            <td class="custom-bg"></td>
            <td class="custom-bg"></td>
            <td class="custom-bg right">
                {{ 
                    '$ ' . number_format(array_sum(array_map(function($item) { 
                        return floor($item['movDebe']); 
                    }, $comprobante->movimientos->toArray())), ...[0, '', '.'])
                }}
            </td>
            <td class="custom-bg right">
                {{ 
                    '$ ' . number_format(array_sum(array_map(function($item) { 
                        return floor($item['movHaber']); 
                    }, $comprobante->movimientos->toArray())), ...[0, '', '.'])
                }}
            </td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
    </table>
    <br>
    <table width="100%" style="width:100%" border="0">
        <tr>
            <td>OBSERVACIONES: <br><br></td>
        </tr>
        <tr>
            <td>
                ____________________________________________________________________________________________________________________________________
            </td>
        </tr>
        <tr>
            <td>
                <br>
                ____________________________________________________________________________________________________________________________________
            </td>
        </tr>
    </table>
    <br>
    <br>
    <br>
    <table width="100%" style="width:100%" border="0">
        <tr>
            <td class="center">
                ________________________
            </td>
            <td class="center">
                ________________________
            </td>
            <td class="center">
                ________________________
            </td>
        </tr>
        <tr>
            <td class="center">
                Contador
            </td>
            <td class="center">
                Administrador
            </td>
            <td class="center">
                Párroco
            </td>
        </tr>
        <tr>
            <td class="center">

            </td>
            <td class="center">

            </td>
            <td class="center">
                <br>
                <br>
                <br>
                ________________________
            </td>
        </tr>
        <tr>
            <td class="center">

            </td>
            <td class="center">

            </td>
            <td class="center">
                Recibo conforme
            </td>
        </tr>

        <tr>
            <td class="center">

            </td>
            <td class="center">

            </td>
            <td class="center" style="margin-left: -70px !important;">
                rut:
            </td>
        </tr>
    </table>
</body>

</html>
