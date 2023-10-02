var tabla;

//FUNCIÓN QUE SE EJECUTA AL INICIO
function init() {
    mostrarform(false);
    listar();

}


//FUNCIÓN LIMPIAR
function limpiar(){
    $("#idtipo_examen").val("");
    $("#seleccita").val("");
    $("#nombre").val("");
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


//FUNCIÓN LISTAR
function listar(){
    tabla=$('#tbllistadocita').dataTable({
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
            url: '../ajax/citaatendida.php?op=listar',
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


//FUNCIÓN MOSTRAR TIPO DE EXAMEN
function mostrar(idtipo_examen){
    $.post("../ajax/examenmedico.php?op=mostrar",{idtipo_examen : idtipo_examen}, function(data, status)
    {
        data = JSON.parse(data);
        mostrarform(true);
        $("#seleccita").val(data.cita); 
        $("#seleccita").selectpicker('refresh');
        $("#nombre").val(data.nombre);
        $("#idtipo_examen").val(data.idtipo_examen)

    });
}


init();