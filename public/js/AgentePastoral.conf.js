$(document).ready(function(){
	$("#form-steps").steps({
		transitionEffect: "slide",
		onStepChanging: function (event, currentIndex, newIndex){
			// Siempre permita retroceder incluso si el paso actual contiene campos no válidos!
			if (currentIndex > newIndex)
			{
				return true;
			}
			if(currentIndex == 0){
				var nacimiento = $("#nacimiento").val();
				var rut = $("#rut").val();
				if(rut != '' && $("#tpDocumentoR").prop("checked")){
					if (!checkRut(rut,null,'rut','tpDocumentoR')){
						return false;
					}
				}
				
				if(nacimiento != ''){
					if(!ValidaFecha(nacimiento,'P','NACIMIENTO','nacimiento')){
						return false;
					}
				}
				var Ids = [ 'nombre', 'apellidoPaterno', 'apellidoMaterno'];
				for (var valor of Ids) {
					if(!StringMax(valor,$("#"+valor).val(),50)){
						return false;
					}
				}
			}
			if(newIndex === 1){
				$("#region").change(function(){
					getComuna($(this).val());
				});
			}
			if(currentIndex === 1){
				var Ids = [ 'correo', 'direccion'];
				for (var valor of Ids) {
					if(valor == 'direccion'){
						if(!StringMax(valor,$("#"+valor).val(),190)){
							return false;
						}
					}else{
						if(!StringMax(valor,$("#"+valor).val(),50)){
							return false;
						}
					}
				}
			}
			if(newIndex === 2){
				
			}
			var form = $(this);
			
			// Clean up if user went backward before
			if (currentIndex < newIndex)
			{
				// To remove error styles
				$(".body:eq(" + newIndex + ") label.error", form).remove();
				$(".body:eq(" + newIndex + ") .error", form).removeClass("error");
			}

			// Deshabilite la validación en los campos que están deshabilitados u ocultos.
			form.validate().settings.ignore = ":disabled,:hidden";

			// Start validation; Prevent going forward if false
			
			return form.valid();
			
		},onFinished: function(event,currentIndex){
			var form = $(this);
			form.submit();
		}

	});
	$("select.select2-steps").select2({
		theme: 'bootstrap4',
		width:'auto',
		placeholder: "Seleccione una Opción",
	});
	if( $('#tpDocumentoR').prop('checked') ) {
		var rut = document.getElementById('rut').value;
		if(rut != ''){
			rut = clean(rut);
			var result = rut.slice(-4, -1) + '-' + rut.substr(rut.length - 1);
			for (var i = 4; i < rut.length; i += 3) {
				result = rut.slice(-3 - i, -i) + '.' + result;
			}
		}

		
		
		$("#rut").val(result);
	}
});

function solo_letras(input){
	if(input.value != ''){
		letras = (input.value + '').replace(/[^a-zA-Z\áéíóúñÑ]/g,'');
		$("#"+input.id).val(letras);
	}
}
function file(input,label){
	var p;
	for ( p=0;p<input.files.length;p++){
		var fileName = input.files[p].name;// alert(this.files[0].size);
		var fileSize = input.files[p].size / 1024 / 1024; // this.files[0].size recupera el tamaño del archivo en MB
		if(fileSize >= 15 ){
			toastr['warning']("El archivo no debe superar los 15MB","Advertencia");
			input.value = '';
			input.files[p].name = '';
		}else{
			// recuperamos la extensión del archivo,convertimos en minusculas
			var ext = fileName.split('.').pop().toLowerCase();
			switch (ext) {
				case 'jpg':
				case 'jpeg':
				case 'png':
				case 'pdf': 
					//$(this).next('.custom-file-label').addClass("selected").html(fileName);
					$("#"+label).addClass("selected").html(fileName);
				break;
				default:
					$("#"+label).removeClass("selected").html('Subir Archivo...');
					toastr['warning']("Existen archivos con extensiones inapropiadas, puede adjuntar archivos de tipo : JPG,JPEG,PNG,PDF","Advertencia");
					input.value = ''; // reset del valor
					// this.files.name = '';
					return false;
			}
		}
	}
}
function comprobar(rut){
	if(checkRut(rut,null,'rut','tpDocumentoR')){
		
		$.ajax({
			headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			data:  {'rut':clean(rut)},
			url:   '/ajax/comprobarRut',
			type : 'get',
			dataType: 'json',
		}).done(function(data) {
			if(data != 0){
				toastr['success']("Redireccionando en 10 seg....","El agente pastoral existe");
				setTimeout(function () {
					location.href = '/pastoral/listado/'+data+'/edit'
				}, 5090);
			}
		});
	}
}
function clean (rut) {
		
	return typeof rut === 'string'
	  ? rut.replace(/^0+|[^0-9kK]+/g, '').toUpperCase()
	  : ''
}