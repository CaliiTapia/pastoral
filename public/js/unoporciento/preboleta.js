$('#monto_aporte').change(function () {
    let porcentajeparroquial = parseFloat($('#p_parroquial').val())/100;
    // let montoaporte = $('#monto_aporte').val() == '' ? 0: parseFloat( $('#monto_aporte').val());
    let montoaporte = $('#monto_aporte').val();
    let porcentajepapal = montoaporte * 0.01;
    let comision = parseFloat(($('#comision').val()) / 100).toFixed(3);
    let recaudacion;
    let aporteparroquial;
    let aporteDiocesano;
    let gastos = parseInt($('#c_gastos').val() * 1);
    let visitadores = parseInt($('#n_visitadores').val() * 1);
    let tipo_pago = $('#tipo_pago').val();

    // Variables a agregar
    var zonaUR = 1;

    // porcentajeparroquial =  porcentajeparroquial / 100;

    

    // Rendicion oficina Arzobispal
   
        if(comision == 0 ){
            if(zonaUR == 10) {
                $('#comision').val(12);
            }else{
                $('#comision').val(10);
            }
            comision = parseFloat(($('#comision').val()) / 100).toFixed(3);
        }
        if(gastos == 0){
            $('#c_gastos').val(0);
        }
        if(visitadores == 0){
            $('#n_visitadores').val(0);
        }
        recaudacion =  parseInt((montoaporte - porcentajepapal) * comision);
        aporteparroquial = parseInt((parseInt(montoaporte - porcentajepapal) - (parseInt(recaudacion) + parseInt(gastos)) )* porcentajeparroquial);
        aporteDiocesano = (parseInt(montoaporte - porcentajepapal)- (parseInt(recaudacion) + parseInt(gastos)) - aporteparroquial);
    

    $('#aporte_papal').val(porcentajepapal.toFixed(0));
    $('#m_parroquial').val(aporteparroquial.toFixed(0));
    $('#m_diocesano').val(aporteDiocesano.toFixed(0));
    $('#recaudacion').val(recaudacion.toFixed(0));
    $('#tesoreria').val((parseInt(aporteDiocesano)+parseInt(porcentajepapal)).toFixed(0));
    $('#valor_tesoreria').text('$ ' + (parseInt(aporteDiocesano)+parseInt(porcentajepapal)).toFixed(0));
});

$('#c_gastos').change(function(){
    // variables
    var recaudacion = document.getElementById('recaudacion').value;
    var parroquial = document.getElementById('p_parroquial').value
    var dec_parroquial = parseFloat(parroquial)/100;
    var monto = document.getElementById('monto_aporte').value;
    var papal = document.getElementById('aporte_papal').value;
    var gastos = document.getElementById('c_gastos').value;
    // calculo
    liquido = monto - papal - recaudacion - gastos;
    monto_parroquial = (liquido * dec_parroquial).toFixed(0);
    monto_diocesano = liquido - monto_parroquial;
    // escritura
    document.getElementById('aporte_papal').value = papal;
    document.getElementById('recaudacion').value = recaudacion;
    document.getElementById('m_parroquial').value = monto_parroquial;
    document.getElementById('m_diocesano').value = monto_diocesano;
    document.getElementById('monto_aporte').value = monto;
    document.getElementById('tesoreria').value = parseInt(monto_diocesano) + parseInt(papal);
    $('#valor_tesoreria').text('$ ' + (parseInt(monto_diocesano) + parseInt(papal)) );
});
