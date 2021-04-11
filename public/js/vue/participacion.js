const tabs = new Vue({
    // Donde se ejecuta el script
    el: '#tabsFicha',

    // Se ejecuta al iniciar la pagina
    mounted: function () {
        this.cargarTodo();
    },
    data: {

        // Variable uso sistema
        errors: [],

        // Listado de participaciones de la ficha
        participaciones: [],

        // Notas de referencias
        notas: '',

        // Datos generales cargados desde DB 
        areas: [],
        zonas: [],
        cargos: [],
        instituciones: [],
        capillas: [],

        // Variables por defecto
        Defecto_Z_IdZona: '',
        Defecto_I_INCodigo: '',

        // Datos del formulario de participacion
        MAP_F_IdFicha: document.getElementById('IdFicha').value != null ? document.getElementById('IdFicha').value : null,

        // Id para dehabilitar participacion
        participacionDeshabilitar: '',
        referenciaDeshabilitar: '',

        // Arrego para editar datos participacion
        datosParticipacion: {
            'MAP_FechaInicio': '',
            'MAP_FechaTermino': '',
            'MAP_I_INCodigo': '',
            'MAP_I_INCodigoCapilla': '',
            'MAP_A_IdArea': '',
            'MAP_C_IdCargo': '',
            'MAP_Z_IdZona': ''
        },

        // Arreglo para ingreso de datos participacion
        nuevaParticipacion: {
            'MAP_FechaInicio': '',
            'MAP_FechaTermino': '',
            'MAP_I_INCodigo': '',
            'MAP_I_INCodigoCapilla': '',
            'MAP_A_IdArea': '',
            'MAP_C_IdCargo': '',
            'MAP_Z_IdZona': ''
        },

        // Arreglo para ingreso de datos referencia
        nuevaReferencia: {
            'MAP_P_IdParticipacion': '',
            'MAP_Nota': '',
            'MAP_Observacion': ''
        },

    },
    methods: {
        // Ajax Cargar los datos
        cargarTodo: function(){
            var urlCarga = '/ajax/listar/todo/ficha/' + this.MAP_F_IdFicha;
            axios.get(urlCarga).then( response => {
                if(response.data.status == 'ERROR'){
                    swal({
                        title: "¡ADVERTENCIA!",
                        text: "Ocurrio un error al detectar la unidad recaudadora que esta utilizando,debe selecionarla nuevamente",
                        type: "warning"
                    }, function() {
                        window.location = response.data.route;
                    });
                }else{
                    this.participaciones = response.data[0];
                    this.zonas = response.data[1];
                    this.areas = response.data[2];
                    this.instituciones = response.data[3];
                    this.capillas = response.data[4];
                    
                    this.nuevaParticipacion.MAP_I_INCodigo = response.data[3][0].INCodigo;
                    this.nuevaParticipacion.MAP_Z_IdZona = response.data[1][0].IdZona;

                    this.Defecto_I_INCodigo = response.data[3][0].INCodigo;
                    this.Defecto_Z_IdZona = response.data[1][0].IdZona;
                }

            });
        },
        // Ajax Cargar los datos de las participaciones
        cargarParticipaciones: function(){
            var urlCarga = '/ajax/listar/participaciones/ficha/' + this.MAP_F_IdFicha;
            axios.get(  urlCarga ).then( response => {
                if(response.data.status == 'ERROR'){
                    swal({
                        title: "¡ADVERTENCIA!",
                        text: "Ocurrio un error al detectar la unidad recaudadora que esta utilizando,debe selecionarla nuevamente",
                        type: "warning"
                    }, function() {
                        window.location = response.data.route;
                    });
                }else{
                    this.participaciones = response.data;
                }
            });
        },
        // Ajax Cargar los datos de las participaciones
        cargarReferencias: function(){
            var urlCarga = '/ajax/listar/referencias/ficha/' + this.MAP_F_IdFicha;
            axios.get(  urlCarga).then( response => {
                this.referencias = response.data;
            });
        },
        // Ajax Para comletar los Select
        listarZonas: function(){
            var urlZonas = '/ajax/listar/zonas/';
            axios.get(  urlZonas).then( response => {
                this.zonas = response.data;
            });
        },
        listarAreas: function(){
            var urlCargos = '/ajax/listar/areas/';
            axios.get(  urlCargos).then( response => {
                this.areas = response.data;
            });
        },
        listarURS: function(){
            var urlURS = '/ajax/listar/urs/';
            axios.get(urlURS).then( response => {
                this.instituciones = response.data;
                this.nuevaParticipacion.MAP_I_INCodigo = this.instituciones[0].INCodigo;
                this.nuevaParticipacion.MAP_Z_IdZona = this.instituciones[0].INZona;
                this.Defecto_I_INCodigo = this.instituciones[0].INCodigo;
                this.Defecto_Z_IdZona = this.instituciones[0].INZona;

            });
        },
        // Eventos de seleccion
        seleccionaAreaIngreso: function(){
            this.cargos = this.areas.find(area => area.MAP_IdArea === this.nuevaParticipacion.MAP_A_IdArea).cargos 
                            ? this.areas.find(area => area.MAP_IdArea === this.nuevaParticipacion.MAP_A_IdArea).cargos : '';
        },

        // Eventos de seleccion
        seleccionaAreaEdicion: function(){
            this.cargos = this.areas.find(area => area.MAP_IdArea === this.datosParticipacion.MAP_A_IdArea).cargos 
                            ? this.areas.find(area => area.MAP_IdArea === this.datosParticipacion.MAP_A_IdArea).cargos : '';
        },

        // Eventos de envio de datos
        postCrearParticipacion: function(){
            var urlStore = '/historial/participacion/parroquial';
            this.nuevaParticipacion.MAP_F_IdFicha = this.MAP_F_IdFicha,
            this.MAP_I_INCodigo = this.Defecto_I_INCodigo,
            this.MAP_Z_IdZona = this.Defecto_Z_IdZona,
            this.nuevaParticipacion.MAP_Z_IdZona = this.Defecto_Z_IdZona;//this.instituciones[0].INZona,
            axios.post(  urlStore, this.nuevaParticipacion).then( response => {
                this.cargarParticipaciones();
                this.nuevaParticipacion = {
                    'MAP_FechaInicio': '',
                    'MAP_FechaTermino': '',
                    'MAP_I_INCodigo': this.Defecto_I_INCodigo,
                    'MAP_I_INCodigo':'',
                    'MAP_A_IdArea': '',
                    'MAP_C_IdCargo': '',
                    'MAP_Z_IdZona': this.Defecto_Z_IdZona
                };
                this.errors = '';
                $('#ModalAgregarHistorial').modal('hide');
                toastr['success']('Participacion cargadas correctamente', 'Listado actualizado');
            }).catch(error => {
                this.errors = error.response.data
            });
        },
        // Seleccionar los valores en el modal
        editarParticipacion: function(participacion){
            this.datosParticipacion.MAP_IdParticipacion = participacion.MAP_IdParticipacion;
            this.datosParticipacion.MAP_FechaInicio = participacion.MAP_FechaInicio;
            this.datosParticipacion.MAP_FechaTermino = participacion.MAP_FechaTermino;
            this.datosParticipacion.MAP_I_INCodigo = participacion.MAP_I_INCodigo;
            this.datosParticipacion.MAP_I_INCodigoCapilla = participacion.MAP_I_INCodigoCapilla;
            this.datosParticipacion.MAP_A_IdArea = participacion.area.MAP_IdArea;
            this.datosParticipacion.MAP_C_IdCargo = participacion.cargo.MAP_IdCargo;
            this.datosParticipacion.MAP_Z_IdZona = participacion.MAP_Z_IdZona;
            this.seleccionaAreaEdicion();
            $('#ModalEditar').modal('show');
        },
        // Enviar post con datos del modal de editar
        postEditarParticipacion: function(IdParticipacion){
            var url = '/historial/participacion/parroquial/' + IdParticipacion;
            axios.put(url, this.datosParticipacion).then(response => {
                this.cargarParticipaciones();
                $('#ModalEditar').modal('hide');
                this.datosParticipacion = {
                    'MAP_IdParticipacion': '',
                    'MAP_FechaInicio': '',
                    'MAP_FechaTermino': '',
                    'MAP_I_INCodigo': this.Defecto_I_INCodigo,
                    'MAP_I_INCodigoCapilla': '',
                    'MAP_A_IdArea': '',
                    'MAP_C_IdCargo': '',
                    'MAP_Z_IdZona': this.Defecto_Z_IdZona,
                },
                this.errors = [];
                toastr['success']('Participacion actualizada correctamente', 'Participacion actualizada');
            }).catch(error => {
                this.errors = error.response.data;
            });
        },
        // Pasar Id de la participacion al modal de confirmacion
        deshabilitarParticipacion: function(IdParticipacion){
            this.participacionDeshabilitar = IdParticipacion;
        },

        postDeshabilitarParticipacion: function(IdParticipacion){
            eliminar_participacion(IdParticipacion);
        },

        // Funciones de referencias
        // Envio de datos de referencia por post
        postCrearReferencia: function(){
            var urlStore = '/historial/referencia/parroquial/store';
            // Insercion de datos [ Arreglo Vue = v-model Formulario ]
            this.nuevaReferencia.F_IdFicha = this.F_IdFicha,
            axios.post(  urlStore, this.nuevaReferencia).then( response => {
                this.cargarParticipaciones();
                this.nuevaReferencia = {
                    'MAP_P_IdParticipacion': '',
                    'MAP_Nota': '',
                    'MAP_Observacion': ''
                };
                this.errors = '';
                $('#ModalAgregarRef').modal('hide');
                toastr['success']('referencias cargadas correctamente', 'Listado actualizado');
            }).catch(error => {
                this.errors = error.response.data
            });
        },
        // Pasar Id de la participacion al modal de confirmacion
        deshabilitarReferencia: function(IdReferencia){
            this.referenciaDeshabilitar = IdReferencia;
        },
        // Cambio de estatus a inactivo de una referencia GET
        // Al final lo deje por GET ignoren el POST del nombre
        postDeshabilitarReferencia: function(IdReferencia){
            var url = '/historial/referencia/deshabilitar/' + IdReferencia;
            axios.get(  url).then(response => {
                this.cargarParticipaciones();
                $('#ModalEliminarReferencia').modal('hide');
                this.errors = [];
                toastr['success']('Referencia eliminada correctamente', 'Referencias actualizadas');
            }).catch(error => {
                this.errors = error.response.data;
            });
        },
    }
});