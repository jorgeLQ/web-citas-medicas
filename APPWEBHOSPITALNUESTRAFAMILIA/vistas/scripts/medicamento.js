var tabla;

//FUNCIÓN QUE SE EJECUTA AL INICIO
function init() {
    mostrarform(false);
    listar();
    $("#formularioe").on("submit", function(e) {
        guardaryeditar(e);
    });
}


//FUNCIÓN LIMPIAR
function limpiar(){
    $("#idmedicamento").val("");
    $("#nombre").val("");
    $("#descripcion").val("");
}


//FUNCIÓN MOSTRAR FORMULARIO
function mostrarform(flag){
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
function cancelarform(){
    limpiar();
    mostrarform(false);
}


//FUNCIÓN LISTAR MEDICAMENTOS
function listar(){
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
            url: '../ajax/medicamento.php?op=listar',
            type: "get",
            dataType: "json",
            error: function(e){
                console.log(e,responseText);
            }
        },
        "bDestroy":true,
        "iDisplayLength": 6, //paginacion--> cada 6 registros
        "order": [[0, "desc" ]]//ordenar (columna)
    }).DataTable();
}

//FUNCIÓN GUARDAR O EDITAR MEDICAMENTO
function guardaryeditar(e){
    e.preventDefault(); //NO SE ACTIVA LA ACCIÓN PREDETERMINADA DEL EVENTO
    $("#btnGuardar").prop("disabled",true);
    var formData = new FormData($("#formularioe")[0]);
    $.ajax({
        url: "../ajax/medicamento.php?op=guardaryeditar",
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


//FUNCIÓN MOSTRAR MEDICAMENTOS
function mostrar(idmedicamento){
    $.post("../ajax/medicamento.php?op=mostrar",{idmedicamento : idmedicamento}, function(data, status) {
        data = JSON.parse(data);
        mostrarform(true);
        $("#nombre").val(data.nombre);
        $("#descripcion").val(data.descripcion);
        $("#idmedicamento").val(data.idmedicamento);
    });
}


//FUNCIÓN PARA DESACTIVAR MEDICAMENTO
function desactivar(idmedicamento) {
    alertify.confirm("Medicamento","¿Estas seguro de desactivar el tipo medicamento?", function() {
        $.post("../ajax/medicamento.php?op=desactivar", {idmedicamento : idmedicamento}, function(e) {
            //alertify.alert(e);
            tabla.ajax.reload();
            alertify.success('Medicamento desactivado');
        });
    },
    function(){
        alertify.error('Cancelado');
    });
}


//FUNCIÓN PARA ACTIVAR MEDICAMENTO
function activar(idmedicamento) {
    alertify.confirm("Medicamento","¿Estas seguro de activar el medicamento?", function() {
        $.post("../ajax/medicamento.php?op=activar", {idmedicamento : idmedicamento}, function(e) {
            //alertify.alert(e);
            tabla.ajax.reload();
            alertify.success('Medicamento activado');
        });
    },
    function(){
        alertify.error('Cancelado');
    });
}

init();