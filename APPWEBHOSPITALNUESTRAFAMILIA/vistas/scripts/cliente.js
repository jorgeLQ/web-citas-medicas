var tabla;

//FUNCIÓN QUE SE EJECUTA AL INICIO
function init() {
    mostrarform(false);
    listar();
    $("#formulario").on("submit",function(e){
        guardaryeditar(e);
    });
    $("#imagenmuestra").hide();
}


//FUNCIÓN LIMPIAR
function limpiar() {
    $("#idpersona").val("");
    $("#cedula").val("");
    $("#nombres").val("");
    $("#apellidos").val("");
    $("#email").val("");
    $("#telefono").val("");
    $("#direccion").val("");
    $("#ciudad_residencia").val("");    
    $("#fecha_nacimiento").val("");
    $("#edad").val("");
    $("#genero").val("");
	$("#imagenmuestra").attr("src","");
	$("#imagenactual").val("");
    $('#cedula').css("background-color", "#FFFFFF");
}


//FUNCIÓN MOSTRAR FORMULARIO
function mostrarform(flag) {
    limpiar();
    if(flag) {
        $("#listadoregistros").hide();
        $("#formularioregistros").show();
        $("#btnGuardar").prop("disabled",false);
        $("#btnagregar").hide();
    } else {
        $("#listadoregistros").show();
        $("#formularioregistros").hide();
        $("#btnagregar").show();
    }
}


//FUNCIÓN CANCELAR FORMULARIO
function cancelarform(){
    limpiar();
    mostrarform(false);
}


//FUNCIÓN LISTAR CLIENTE
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
            'pdf'
        ],
        "ajax":{
            url: '../ajax/cliente.php?op=listar',
            type: "get",
            dataType: "json",
            error: function(e){
                console.log(e.responseText);
            }
        },
        "bDestroy":true,
        "iDisplayLength": 5, //PAGINACIÓN --> CADA 5 REGISTROS
        "order": [[0, "desc" ]] //ORDENAR (COLUMNA, ORDEN)
    }).DataTable();
}


//FUNCIÓN GUARDAR O EDITAR CLIENTE
function guardaryeditar(e){
    e.preventDefault(); // No se activara la acción predeterminada del evento
    $("#btnGuardar").prop("disabled",true);
    var formData = new FormData($("#formulario")[0]);
    $.ajax({
        url: "../ajax/cliente.php?op=guardaryeditar",
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


//FUNCIÓN MOSTRAR CLIENTE
function mostrar(idpersona){
    $.post("../ajax/cliente.php?op=mostrar",{idpersona : idpersona}, function(data, status) {
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
        $("#edad").val(data.edad);
        $("#genero").val(data.genero);
        $("#imagenmuestra").show();
		$("#imagenmuestra").attr("src","../files/usuarios/"+data.imagen);
		$("#imagenactual").val(data.imagen);
        $("#idpersona").val(data.idpersona);

    })
}


//FUNCIÓN PARA DESACTIVAR CLIENTES
function desactivar(idpersona) {
    alertify.confirm("Cliente","¿Estas seguro de desactivar al Cliente?", function() {
        $.post("../ajax/cliente.php?op=desactivar", {idpersona : idpersona}, function(e) {
            //alertify.alert(e);
            tabla.ajax.reload();
            alertify.success('Cliente desactivado');
        });
        },
        function(){
            alertify.error('Cancelado');
    });
}


//FUNCIÓN PARA ACTIVAR CLIENTES
function activar(idpersona) {
    alertify.confirm("Cliente","¿Estas seguro de activar al Cliente?", function() {
        $.post("../ajax/cliente.php?op=activar", {idpersona : idpersona}, function(e) {
            //alertify.alert(e);
            tabla.ajax.reload();
            alertify.success('Cliente activado');
        });
    },
        function(){
            alertify.error('Cancelado');
        });
}

init();