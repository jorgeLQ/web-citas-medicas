var tabla;

//FUNCIÓN QUE SE EJECUTA AL INICIO
function init() {
    mostrarform(false);
    listar();
    $("#formulario").on("submit",function(e){
        guardaryeditar(e);
    });

    //MOSTRAR ROLES
	$.post("../ajax/medico.php?op=roles&id2=", function(r) {
		$("#roles").html(r);
	});

    //MOSTRAR ESPECIALIDADES
    $.post("../ajax/medico.php?op=especialidades&id=",function(r) {   
        $("#especialidades").html(r);
    });

    $("#imagenmuestra").hide();
}


//FUNCIÓN LIMPIAR
function limpiar(){
    $("#idpersona").val("");
    $("#usuario_idusuario").val("");
    $("#especialidades").val("");
    $("#cedula").val("");
    $("#nombres").val("");
    $("#apellidos").val("");
    $("#email").val("");
    $("#telefono").val("");
    $("#direccion").val("");
    $("#especialidades").val("");
	$("#imagenmuestra").attr("src","");
	$("#imagenactual").val("");
    $("#ciudad_residencia").val("");
    $("#fecha_nacimiento").val("");
    $("#genero").val("");
    $('#cedula').css("background-color", "#FFFFFF");
}


//FUNCIÓN MOSTRAR FORMULARIO
function mostrarform(flag){
    limpiar();
    if(flag){
        $("#listadoregistros").hide();
        $("#formularioregistros").show(); 
        $("#btnGuardar").prop("disabled",false);
        $("#btnagregar").hide(); //OCULTA EL BOTON NUEVO MÉDICO
    }else{
        $("#listadoregistros").show();
        $("#formularioregistros").hide();
        $("#btnagregar").show(); //MUESTRA EL BOTON NUEVO MÉDICO
    }
}


//FUNCIÓN CANCELAR FORM
function cancelarform(){
    limpiar();
    mostrarform(false);
}


//FUNCIÓN LISTAR MÉDICO
function listar(){
    tabla=$('#tbllistado').dataTable({
        "aProcessing":true, //ACTIVAR EL PROCESAMIENTO DEL DATATABLE
        "aServerSide": true, //PAGINACIÓN Y FILTRADO REALIZADO POR EL SERVIDOR
        dom: 'Bfrtip', //DEFINIR LOS PARAMETROS DEL CONTROL DE TABLA
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json"
        },
        //BOTONES PARA COPIAR LOS REGISTROS EN DIFERENTES FORMATOS
        buttons:[
            'copyHtml5',
            'excelHtml5',
            'csvHtml5',
            'pdf',
        ],
        "ajax":{
            url: '../ajax/medico.php?op=listar',
            type: "get",
            dataType: "json",
            error: function(e){
                console.log(e,responseText);
            }
        },
        "bDestroy":true,
        "iDisplayLength": 5, //PAGINACIÓN --> CADA 5 REGISTROS
        "order": [[0, "desc" ]] //ORDENAR (COLUMNA, ORDEN)
    }).DataTable();
}


//FUNCIÓN GUARDAR O EDITAR MÉDICO
function guardaryeditar(e){
    e.preventDefault();
    $("#btnGuardar").prop("disabled",true);
    var formData = new FormData($("#formulario")[0]);
    $.ajax({
        url: "../ajax/medico.php?op=guardaryeditar",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,

        success: function(datos){
            bootbox.alert(datos);
            mostrarform(false);
            tabla.ajax.reload();
        }
    });
    limpiar();
}


//FUNCIÓN MOSTRAR MÉDICO
function mostrar(idpersona){
    $.post("../ajax/medico.php?op=mostrar",{idpersona : idpersona}, function(data, status) {
        data = JSON.parse(data);
        mostrarform(true);
        $("#cedula").val(data.cedula);
        $("#nombres").val(data.nombres);
        $("#apellidos").val(data.apellidos);
        $("#email").val(data.email);
        $("#telefono").val(data.telefono);
        $("#direccion").val(data.direccion);
        $("#ciudad_residencia").val(data.ciudad_residencia);
        $("#fecha_nacimiento").val(data.fecha_nacimiento);
        $("#genero").val(data.genero);
        $("#imagenmuestra").show();
		$("#imagenmuestra").attr("src","../files/usuarios/"+data.imagen);
		$("#imagenactual").val(data.imagen);
        $("#usuario_idusuario").val(data.usuario_idusuario)
        $("#idpersona").val(data.idpersona);

    });

    $.post("../ajax/medico.php?op=roles&id2="+idpersona, function(r) {
		$("#roles").html(r);
	});

    $.post("../ajax/medico.php?op=especialidades&id="+idpersona, function(r) {
		$("#especialidades").html(r);
    });
    
}


//FUNCIÓN PARA DESACTIVAR MÉDICO
function desactivar(idpersona) {
    alertify.confirm("Médico","¿Estas seguro de desactivar al Médico?", function() {
        $.post("../ajax/medico.php?op=desactivar", {idpersona : idpersona}, function(e) {
            //alertify.alert(e);
            tabla.ajax.reload();
            alertify.success('Médico desactivado');
        });
    },
    function(){
        alertify.error('Cancelado');
    });
}


//FUNCIÓN PARA ACTIVAR MÉDICO
function activar(idpersona) {
    alertify.confirm("Médico","¿Estas seguro de activar al Médico?", function() {
        $.post("../ajax/medico.php?op=activar", {idpersona : idpersona}, function(e) {
            //alertify.alert(e);
            tabla.ajax.reload();
            alertify.success('Médico activado');
        });
    },
    function(){
        alertify.error('Cancelado');
    });
}

init();