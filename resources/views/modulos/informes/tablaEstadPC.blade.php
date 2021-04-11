<html lang="{{ app()->getLocale() }}">
<head>

    {{--<meta charset="utf-8">--}}
    {{--<meta name="viewport" content="width=device-width, initial-scale=1">--}}
    {{--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">--}}
    <style>
        .saltopagina{
            page-break-after:always;
        }
        table{
            width: 100%;
            border-collapse: collapse;
            /* padding-top: -180px; */
        }
        table, th, td, tr {
            border: 1px solid black;
        }
        b {
            font-size: 12px;
        }
        th, td {
            padding: 7px;
            height: 20px;
            width: 30px;
        }
        th {
            background-color: #c2c2c2;
        }
        .logoArzo{
            margin-left: 30px;
            height: 180px;
            width: auto;
        }
        .indicador{
            display: inline-block;
            width: 150px;
        }
        .logoEncabezado{
            display: inline-block;
            position: sticky;
            width: 250px;
            height: 250px;
            margin-top: 50px;
        }
        .depto{
            margin-top: 0px;
            padding-top: -30px;
            margin-left: 0px;
            font-size: 14px;
            color: #323232;
        }
        .tipoInforme{
            display: inline-block;
            width: 600px;
            padding-left: -50px;
            padding-top: -50px
        }
        tbody:before, tbody:after {
            display: none;
        }
        .total {
            background-color: #c2c2c2;
            font-weight: bold;
        }
        .periodo {
            background-color: #c2c2c2;
            font-weight: bold;
        }
        .footer-text{
            position: static;
            padding-top: 100px;
        }
        .encabezadoTabla{
            margin-bottom: -150px;
        }

    </style>

</head>
<body>
    <div class="encabezadoTabla">

        <div class="logoEncabezado">
            <img src="{{ public_path().'/img/LogoGIngreso.png' }}" class="logoArzo">
        </div>
        <div class="tipoInforme">
            <h4 style="padding-left: 50px">Pago Contribuyente</h4>
            <br>
            <b class="indicador">Periodo</b>   <b>: {{ $ano }}</b>
        </div>

    </div>
        <table>
            <thead style="border: 1px solid black">
            <tr >
                <th colspan="4" style="text-align: center;"></th>
            </tr>

            <tr>
                <th>Nombres</th>
                <th>Apellido Paterno</th>
                <th>Rut</th>
                <th>Monto</th>
            </tr>

            </thead>
            <tbody>

                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>

                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td  style="text-align: center;"></td>
                </tr>
            </tbody>
        </table>

        <div class="footer">
            <h5 class="footer-text">
                © Sistema de Gestión de Ingresos - Arzobispado de Santiago - Desarrollado por Dirección de Tecnologias de la Información
            </h5>
        </div>  
</body>
</html>