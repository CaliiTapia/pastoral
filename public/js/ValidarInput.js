$(document).ready(function() {
	jQuery.extend(jQuery.validator.messages, {
		required: "Este campo es obligatorio.",
		remote: "Por favor, rellena este campo.",
		email: "Por favor, escribe una dirección de correo válida",
		url: "Por favor, escribe una URL válida.",
		date: "Por favor, escribe una fecha válida.",
		dateISO: "Por favor, escribe una fecha (ISO) válida.",
		number: "Por favor, escribe un número entero válido.",
		digits: "Por favor, escribe sólo dígitos.",
		creditcard: "Por favor, escribe un número de tarjeta válido.",
		equalTo: "Por favor, escribe el mismo valor de nuevo.",
		accept: "Por favor, escribe un valor con una extensión aceptada.",
		maxlength: jQuery.validator.format("Por favor, no escribas más de {0} caracteres."),
		minlength: jQuery.validator.format("Por favor, no escribas menos de {0} caracteres."),
		rangelength: jQuery.validator.format("Por favor, escribe un valor entre {0} y {1} caracteres."),
		range: jQuery.validator.format("Por favor, escribe un valor entre {0} y {1}."),
		max: jQuery.validator.format("Por favor, escribe un valor menor o igual a {0}."),
		min: jQuery.validator.format("Por favor, escribe un valor mayor o igual a {0}.")
	});
	$('.solo-numeros').keyup(function (){
		this.value = (this.value + '').replace(/[^0-9]/g, '');
	});
	$('.coordenadas').on('input', function () {
		this.value = this.value.replace(/[^0-9-,.]/g, '').replace(/,/g, '.');
	});
	$('.solo-rut').keyup(function (){
		this.value = (this.value + '').replace(/[^0-9---.-K-k]/g, '');	
	});
	$('.solo-letras').keyup(function (){
		this.value = (this.value + '').replace(/[^a-zA-Z\áéíóúñÑ]/g,'');
	});
	//limpia el campo, cuando pegan texto en el input
	$('.solo-letras').blur(function(){
		this.value = (this.value + '').replace(/[^a-zA-Z\áéíóúñÑ]/g,'');
	})
	$('.fono').keyup(function (){
		this.value = (this.value + '').replace(/[^0-9]/g, '');
		if(this.value.length > 9){
			this.value = this.value.slice(0, 9);
		}
	});
	$('.espacio-centro').blur(function(){
		//solo permite un espacio entre palabras letras,elimina espacio al comienzo y al final
		this.value = (this.value + '').replace(/^\s+|\s+$/g,'');
	})
	//limpia el campo, cuando pegan texto en el input
	$('.fono').blur(function(){
		this.value = (this.value + '').replace(/[^0-9]/g, '');
		if(this.value.length < 9){
			toastr['warning']("El número de teléfono es demasiado corto","Advertencia");
		}				  
	})
	$(".FormatRut").blur(function(){
	// function FormatRut(rut,btn){
		// var rut = this.value;
		
		if(rut != ''){	
			rut = (this.value + '').replace(/[^0-9---.-K-k]/g, '');	
			var actual = rut.replace(/^0+/, "");
			if (actual != '' && actual.length > 1) {
				var sinPuntos = actual.replace(/\./g, "");
				var actualLimpio = sinPuntos.replace(/-/g, "");
				var inicio = actualLimpio.substring(0, actualLimpio.length - 1);
				var rutPuntos = "";
				var i = 0;
				var j = 1;
				for (i = inicio.length - 1; i >= 0; i--) {
					var letra = inicio.charAt(i);
					rutPuntos = letra + rutPuntos;
					if (j % 3 == 0 && j <= inicio.length - 1) {
						rutPuntos = "." + rutPuntos;
					}
					j++;
				}
				var dv = actualLimpio.substring(actualLimpio.length - 1);
				rutPuntos = rutPuntos + "-" + dv;
			}
			// this.value = rutPuntos;
			rut = rutPuntos;
			// checkRut(rutPuntos,btn);
		}
	});
	$('.AutoFormatRut').keyup(function (){
		var rut = this.value;
		var key = event.keyCode || event.charCode;
		if(key == 8){
			switch (rut.length){
				case 3:
					$('.AutoFormatRut').val(rut.slice(0,-1));
				break;
				case 7:
					$('.AutoFormatRut').val(rut.slice(0,-1));
				break;
				case 11:
					$('.AutoFormatRut').val(rut.slice(0,-1));
				break;
			}
		}else{
			switch (rut.length){
				case 2:
					rut+='.';
					tmp = rut.length;
					$('.AutoFormatRut').val(rut);
				break;
				case 6:
					rut+='.';
					tmp = rut.length;
					$('.AutoFormatRut').val(rut);
				break;
				case 10:
					rut+='-';
					tmp = rut.length;
					$('.AutoFormatRut').val(rut);
				break;
			}
		}
		checkRut(rutPuntos);
	});
	//valida la extencion del archivo
	$('.file').on('change', function() {
		
		if(this.files.length<=5){
			for ( var p=0;p<this.files.length;p++){
				var fileName = this.files[p].name;// alert(this.files[0].size);
				var fileSize = this.files[p].size / 1024 / 1024; // this.files[0].size recupera el tamaño del archivo en MB
				if(fileSize >= 15 ){
					toastr['warning']("El archivo no debe superar los 15MB","Advertencia");
					this.value = '';
					this.files[p].name = '';
				}else{
					// recuperamos la extensión del archivo,convertimos en minusculas
					var ext = fileName.split('.').pop().toLowerCase();
					switch (ext) {
						case 'jpg':
						case 'jpeg':
						case 'png':
						case 'pdf': 
							$(this).next('.custom-file-label').addClass("selected").html(fileName);	
						break;
						default:
							$(this).next('.custom-file-label').removeClass("selected").html('Subir Archivo...');
							toastr['warning']("Existen archivos con extensiones inapropiadas,puede adjuntar archivos de tipo : JPG,JPEG,PNG,PDF","Advertencia");
							this.value = ''; // reset del valor
							this.files[p].name = '';
							return false;
					}
				}
			}
		}else{
			toastr['warning']("Solo puede subir 5 archivos","Advertencia");
			$('.file').val('');
		}
	});

	/*Contraseñas*/
	$('#ver_clave').on('click',function (e){
	e.preventDefault();

		var current = $(this).attr('action');
		if (current == 'hide') {
			$('#password').attr('type','text');
			$(this).removeClass('zmdi zmdi-eye').addClass('zmdi zmdi-eye-off').attr('action','show');
		}
		if (current == 'show') {
			$('#password').attr('type','password');
			$(this).removeClass('zmdi zmdi-eye-off').addClass('zmdi zmdi-eye').attr('action','hide');
		}

	});

	$('.coincide').keyup(function (){
		var pass = $('#password').val();
		if(pass == this.value){
			$(this).removeClass('is-invalid').addClass('is-valid');
			
		}else{
			$(this).removeClass('is-valid').addClass('is-invalid');
			
		}    
	});
	$('.contiene-mayuscula').keypress(function (e){
		// Detect current character & shift key
		var character = e.keyCode ? e.keyCode : e.which;
		var sftKey = e.shiftKey ? e.shiftKey : ((character == 16) ? true : false);
		// Is caps lock on?
		isCapsLock = (((character >= 65 && character <= 90) && !sftKey) || ((character >= 97 && character <= 122) && sftKey));
		// Display warning and set css
		if (isCapsLock == true) {
			$('.upperCase').css('display','block');
		}else{
			$('.upperCase').css('display','none');
		}

	});
});
//valida si el rut es correcto
function checkRut (rut,desactivar,input,tpDocumento) {
	//tpDocumento verifica si es rut o otro documento contiene el id 
	if($("#"+tpDocumento).is(':checked')){
		if(rut != null && rut != ""){
			// Obtiene el valor ingresado quitando puntos y guión.
			
			var valor = clean(rut);
		
			// Divide el valor ingresado en dígito verificador y resto del RUT.
			cuerpo = valor.slice(0, -1);
			dv = valor.slice(-1).toUpperCase();
		
			// Separa con un Guión el cuerpo del dígito verificador.
			// rut.value = format(rut);
			
			// Si no cumple con el mínimo ej. (n.nnn.nnn)
			if (cuerpo.length < 7) {
				if(desactivar != null){
					$('#'+desactivar).attr("disabled", true);
				}
				$("#"+input).addClass("error");
				toastr['warning']("El Rut esta incompleto,debe contener almenos 8 digitos","Advertencia");
			return false;
			}
		
			// Calcular Dígito Verificador "Método del Módulo 11"
			suma = 0;
			multiplo = 2;
		
			// Para cada dígito del Cuerpo
			for (i = 1; i <= cuerpo.length; i++) {
			// Obtener su Producto con el Múltiplo Correspondiente
			index = multiplo * valor.charAt(cuerpo.length - i);
		
			// Sumar al Contador General
			suma = suma + index;
		
			// Consolidar Múltiplo dentro del rango [2,7]
			if (multiplo < 7) {
				multiplo = multiplo + 1;
			} else {
				multiplo = 2;
			}
			}
		
			// Calcular Dígito Verificador en base al Módulo 11
			dvEsperado = 11 - (suma % 11);
		
			// Casos Especiales (0 y K)
			dv = dv == "K" ? 10 : dv;
			dv = dv == 0 ? 11 : dv;
			//Le damos formato de rut 
			// $("#"+input).val(format(rut));
			$("#"+input).val(clean(rut));
			// Validar que el Cuerpo coincide con su Dígito Verificador
			if (dvEsperado != dv) {
				if(desactivar != null){
					$('#'+desactivar).attr("disabled", true);
				}
				$("#"+input).addClass("error");
				toastr['warning']("El Rut es <strong>INVÁLIDO</strong>","Advertencia");
		
			return false;
			} else {
				// toastr['success']("El Rut es <strong>VALIDO</strong>","CORRECTO");
				if(desactivar != null){
					$('#'+desactivar).attr("disabled", false);
				}
				$("#"+input).removeClass("error");
				return true;
			}
		}else{
			$("#"+input).addClass("error");
		}
	}
	function format (rut) {
		//console.log("format :"+rut);
		rut = clean(rut)
	  
		var result = rut.slice(-4, -1) + '-' + rut.substr(rut.length - 1)
		for (var i = 4; i < rut.length; i += 3) {
		  result = rut.slice(-3 - i, -i) + '.' + result
		}
	  
		return result
	}
	  
	  function clean (rut) {
		
		return typeof rut === 'string'
		  ? rut.replace(/^0+|[^0-9kK]+/g, '').toUpperCase()
		  : ''
	}
  }

function ValidaCheckbox(min){
	var checked = 0;
	$('input[type=checkbox]:checked').each(function() {
		checked++;
	});
	//console.log("Checkbox seleccionados" + checked );
	if( checked < min ) {
		toastr.warning('Debe seleccionar minimo '+min+' solicitudes','¡Advertencia!');
		return false;
	}
}
function StringMax(input,valor,max){
	if(valor.length > max){
		$("#"+input).addClass('error');
		toastr['warning']("El largo maximo permitido es de : "+max,"¡Advertencia!");
		return false;
	}else{
		$("#"+input).removeClass('error');
		return true;
	}
}
function ValidaFecha(fSeleccionada,cuando,nInput,idInput){
	// $cuando puede ser P:pasado , F:futuro, H:hoy
	//nImput: nombre con el que lo identifica el usuario
	var hoy = today();
	switch(cuando){
		case'P':
			if(fSeleccionada >= hoy){
				$("#"+idInput).addClass('error');
				toastr['warning']("La fecha de "+nInput+" no puede ser mayor a la de hoy","Advertencia");
				return false;
			}else{
				$("#"+idInput).removeClass('error');
				return true;
			}
		break;
		case'H':
			

		break;
		case'F':
			if(fSeleccionada < hoy){
				$("#"+idInput).addClass('error');
				toastr['warning']("La fecha de "+nInput+" no puede ser menor a la de hoy","Advertencia");
				return false;
			}else{
				$("#"+idInput).removeClass('error');
				return true;
			}

		break;
	}
	function today(){
		var d = new Date();
		var month = d.getMonth()+1;
		var day = d.getDate();
		var output = d.getFullYear() + '-' +
			((''+month).length<2 ? '0' : '') + month + '-' +
			((''+day).length<2 ? '0' : '') + day;
		return output;
	}
}