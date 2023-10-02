var tabla;

//FUNCIÓN QUE SE EJECUTA AL INICIO
function init() {
    mostrarform(false);
    listar();
    $("#formularioe").on("submit",function(e){
        guardaryeditar(e);
    });
}


//FUNCIÓN LIMPIAR
function limpiar(){
    $("#idespecialidad").val("");
    $("#nombre").val("");
}


//FUNCIÓN MOSTRAR FORMULARIO
function mostrarform(flag) {
    limpiar();
    if(flag){
        $("#listadoregistros").hide();
        $("#formularioregistros").show();
        $("#btnGuardar").prop("disabled",false);
        $("#btnagregar").hide();
    }else{
        $("#listadoregistros").show();
        $("#formularioregistros").hide();
        $("#btnagregar").show();
    }
}


//FUNCIÓN CANCELAR FORM
function cancelarform() {
    limpiar();
    mostrarform(false);
}


// FUNCIÓN LISTAR
function listar() 
{
    tabla=$('#tbllistadoe').dataTable({
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
            url: '../ajax/especialidad.php?op=listar',
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

//FUNCIÓN GUARDAR O EDITAR
function guardaryeditar(e) {
    e.preventDefault(); //NO SE ACTIVA LA ACCIÓN PREDETERMINADA DEL EVENTO
    $("#btnGuardar").prop("disabled",true);
    var formData = new FormData($("#formularioe")[0]);
    $.ajax({
        url: "../ajax/especialidad.php?op=guardaryeditar",
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


// FUNCIÓN MOSTRAR ESPECIALIDAD
function mostrar(idespecialidad) {
    $.post("../ajax/especialidad.php?op=mostrar",{idespecialidad : idespecialidad}, function(data, status) {
        data = JSON.parse(data); //Lo que recivimos de ../ajax/especialidad.php?op=mostrar, lo convertimos a un objeto javaScript
        mostrarform(true);
        
        $("#nombre").val(data.nombre)
        $("#idespecialidad").val(data.idespecialidad)
    });
}


//FUNCIÓN DESACTIVAR ESPECIALIDAD
function desactivar(idespecialidad) {
    alertify.confirm("Especialidad","¿Estas seguro de desactivar la Especialidad?", function() {
        $.post("../ajax/especialidad.php?op=desactivar", {idespecialidad : idespecialidad}, function(e) {
            //alertify.alert(e);
            tabla.ajax.reload();
            alertify.success('Especialidad desactivada');
        });
    },
    function() {
        alertify.error('Cancelado');
    });
}


//FUNCIÓN ACTIVAR ESPECIALIDAD
function activar(idespecialidad)
{
    alertify.confirm("Especialidad","¿Estas seguro de activar la Especialidad?", function(){
        $.post("../ajax/especialidad.php?op=activar", {idespecialidad : idespecialidad}, function(e) {
            //alertify.alert(e);
            tabla.ajax.reload();
            alertify.success('Especialidad activada');
        });
    },
    function(){
        alertify.error('Cancelado');
    });
}

init();