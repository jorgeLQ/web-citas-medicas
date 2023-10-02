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
    $("#idtipo_examen").val("");
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


//FUNCIÓN LISTAR TIPO EXAMEN
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
            url: '../ajax/examen.php?op=listarExamenTipo',
            type: "get",
            dataType: "json",
            error: function(e){
                console.log(e,responseText);
            }
        },
        "bDestroy":true,
        "iDisplayLength": 6, //paginacion--> cada 6 registros
        "order": [[0, "desc" ]] //ORDENAR (COLUMNA, ORDEN)
    }).DataTable();
}


//FUNCIÓN GUARDAR O EDITAR TIPO EXAMEN
function guardaryeditar(e){
    e.preventDefault(); //no se activa la accion predeterminada del evento
    $("#btnGuardar").prop("disabled",true);
    var formData = new FormData($("#formularioe")[0]);
    $.ajax({
        url: "../ajax/examen.php?op=guardaryeditarExamenTipo",
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


//FUNCIÓN MOSTRAR TIPO EXAMEN
function mostrar(idtipo_examen){
    $.post("../ajax/examen.php?op=mostrarExamenTipo",{idtipo_examen : idtipo_examen}, function(data, status)
    {
        data = JSON.parse(data);
        mostrarform(true);
        $("#nombre").val(data.nombre);
        $("#descripcion").val(data.descripcion);
        $("#idtipo_examen").val(data.idtipo_examen);

    });
}


//FUNCIÓN DESACTIVAR TIPO EXAMEN
function desactivar(idtipo_examen)
{
    alertify.confirm("Tipo Examen","¿Estas seguro de desactivar el tipo de examen?",
        function(){
            $.post(
                "../ajax/examen.php?op=desactivar", {idtipo_examen : idtipo_examen}, function(e)
                {
                    //alertify.alert(e);
                    tabla.ajax.reload();
                    alertify.success('Tipo Examen desactivado');
        
                });
        },
        function(){
            alertify.error('Cancelado');
        });
}


//FUNCIÓN ACTIVAR TIPO EXAMEN
function activar(idtipo_examen) {
    alertify.confirm("Tipo Examen","¿Estas seguro de activar el tipo de examen?", function() {
        $.post("../ajax/examen.php?op=activar", {idtipo_examen : idtipo_examen}, function(e) {
            //alertify.alert(e);
            tabla.ajax.reload();
            alertify.success('Tipo Examen activado');
        });
    },
    function(){
        alertify.error('Cancelado');
    });
}

init();