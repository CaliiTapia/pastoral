<style>

.letra_datos{
    font-size: 16px;
}
.tabla_montos{
  line-height: 15px;
  width: 100%;
  margin-left: 5rem;
  margin-top: 60px;
}
.forma_pago{
  font-size: 16px;
  padding-left: 20px;
  padding-top: : -10px;
}
.texto_footer{
  padding-top: 4rem;
  text-align: center;
  color: gray;
  font-size: small;
}
.fecha_hora{
  text-align: right;
  width: 95%;
  line-height: 1px;
  font-weight: bold;
}

</style>
<div style="width: 100%;font-family: Arial;">
    <div style="font-family: Arial; line-height: 1px;width: 35%">
        <img src="{{ public_path().'/img/logohorizontal.png' }}" width="300px" height="100px" >
    </div>
    <div style="text-align: center;width: 100%">
        <h3>{{ $preboleta['tiporecaudacion'] }}</h3>
    </div>
    <div class="fecha_hora">
    </div>
    <div  style="text-align: left;width: 100%; line-height: 1px;">
        <p class="letra_datos">Institucion: {{ $preboleta['unidadrecaudadora'] }} </p>
        <p class="letra_datos">Decanato: {{ $preboleta['decanato'] }}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Zona: {{ $preboleta['zona'] }}</p>
    </div>
    <div style="line-height: 1px; width: 30%;float: left">
        <p class="letra_datos">Part. Parroquial: {{ $preboleta['PorcentajeParroquial'] }}%</p>
        <p class="letra_datos">N° Contribuyentes : {{ $preboleta['NroContribuyente'] }}</p>
    </div>
    <div style="line-height: 1px; width: 30%;float: left;">
        <p class="letra_datos">Fecha Contable : {{ $preboleta['FechaContab'] }}</p>
        <p class="letra_datos">N° Cuotas : {{ $preboleta['NroCuota'] }}</p>
    </div>
    <div style="line-height: 1px; width: 30%;float: right;">
        <p class="letra_datos">Fecha Estadistica : {{ $preboleta['FechaEstad'] }}</p>
        <p class="letra_datos">N° Visitadoras : {{ $preboleta['NroVisitadora'] }}</p>
    </div>
    <div class="tabla_montos">
        @php $subtotal = $preboleta['MontoAporte'] - $preboleta['MontoPapal'] @endphp

        <table class="table" width="80%">
           <tbody>
            <tr>
                <td scope="row">Contribucion Total ........................................</td>
                <td>$ </td>
                <td align="right">{{ number_format($preboleta['MontoAporte'],0,',','.') }}</td>
            </tr>
            <tr>
                <td scope="row">1% Aporte Papal ...........................................</td>
                <td>$ </td>
                <td align="right">{{ number_format($preboleta['MontoPapal'] ,0,',','.')}}</td>
            </tr>
            <tr>
                <td scope="row">Sub Total ......................................................</td>
                <td>$ </td>
                <td align="right">{{ number_format($subtotal ,0,',','.') }}</td>
            </tr>
            <tr>
                <td scope="row">Recaudación ({{ $preboleta['PorcRecaudacion'].' %' }}) : $ {{ number_format($preboleta['MontoRecaudacion'],0,',','.') }}</td>
                <td></td>
                <td align="right"></td>
                <td></td>
            </tr>
            <tr>
                <td scope="row">Otros Gastos: $ {{ number_format($preboleta['MontoGasto'],0,',','.') }}</td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td scope="row">Total a Deducir ..............................................</td>
                <td>$ </td>
                <td align="right">{{ number_format(($preboleta['MontoRecaudacion'] + $preboleta['MontoGasto']),0,',','.') }}</td>
            </tr>
            <tr>
                <td scope="row">Monto Líquido a Repartir .............................</td>
                <td>$ </td>
                <td align="right">{{ number_format($subtotal - ($preboleta['MontoRecaudacion'] + $preboleta['MontoGasto']),0,',','.') }}</td>
            </tr>
            <tr>
                <td scope="row">Participación Parroquial ................................</td>
                <td>$ </td>
                <td align="right">{{ number_format($preboleta['MontoParroquial'] ,0,',','.')}} </td>
            </tr>
            <tr>
                <td scope="row">Pasrticipación Diocesana ..............................</td>
                <td>$ </td>
                <td align="right">{{ number_format($preboleta['MontoDiocesano'] ,0,',','.')}} </td>
            </tr>
            <tr>
                <td scope="row">Aporte Papal .................................................</td>
                <td> $ </td>
                <td align="right">{{ number_format($preboleta['MontoPapal'] ,0,',','.')}}</td>
            </tr>
          </tbody>
          <tfoot>
            <tr>
                <td scope="row">TOTAL A PAGAR A TESORERIA ............</td>
                <td> $ </td>
                <td align="right">{{ number_format($preboleta['MontoDiocesano'] + $preboleta['MontoPapal'],0,',','.') }}</td>
            </tr>
          </tfoot>
        </table>
    </div>
   <div style="width: 100%">
       <p>Forma de Pago:</p>
       <p class="forma_pago">Efectivo :&nbsp;&nbsp; <input type="checkbox" ></p>
       <p class="forma_pago">Cheques :&nbsp;&nbsp; <input type="checkbox">&nbsp;&nbsp; Nro Cheque:______________&nbsp;&nbsp;Banco:_____________________</p>
   </div>
   <div style="width:100%;">
    <div style="width: 70%">
        <p style="font-weight: bold">Comprobante Ingreso N°:____________________________</p>
        @if(isset($preboleta['Nombre']))
          <p style="font-weight: bold">Pagado Por: {{$preboleta['Nombre']}}</p>
        @else
          <p style="font-weight: bold">Pagado Por:_______________________________________</p>
        @endif
        <p style="font-weight: bold">Firma:____________________________________________</p>
    </div>

    </div>
<br>
<br>
<br>
    <footer>
        <p class="texto_footer">Arzobispado de Santiago - Direccion de Gestion de ingreso | Plaza de armas 444 | Teléfono 22 7875619</p>

    </footer>

</div>
