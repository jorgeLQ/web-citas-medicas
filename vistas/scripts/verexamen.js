var tabla;

//FUNCIÓN QUE SE EJECUTA AL INICIO
function init() {
    mostrarform(false);
    listar();
}


//FUNCIÓN MOSTRAR FORMULARIO
function mostrarform(flag){
    if(flag){
        $("#listadoregistros").hide();
        $("#formularioregistros").show();
    }else{
        $("#listadoregistros").show();
        $("#formularioregistros").hide();       
    }
}


//FUNCIÓN CANCELAR FORM
function cancelarform(){
    mostrarform(false);
}


//FUNCIÓN LISTAR VER EXÁMENES
function listar(){
    tabla=$('#tblListadoExamenes').dataTable({
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
            url: '../ajax/verexamen.php?op=listar',
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


//FUNCIÓN MOSTRAR VER EXÁMENES
function mostrar(idpedido_examen){
    $.post("../ajax/verexamen.php?op=mostrar",{idpedido_examen : idpedido_examen}, function(data, status) {
        data = JSON.parse(data);
        mostrarform(true);
        $("#especialidad").val(data.especialidad);
        $("#paciente").val(data.paciente);
        $("#medico").val(data.medico);
        $("#idpedido_examen").val(data.idpedido_examen);

    });
    $.post("../ajax/verexamen.php?op=listarDetalle&id="+idpedido_examen, function(r) {
        $("#examenes").html(r);
    });
}

init();