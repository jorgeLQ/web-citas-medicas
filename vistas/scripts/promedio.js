var tabla;

//FUNCIÓN QUE SE EJECUTA AL INICIO
function init() {
    mostrarform(false);
    listar();
}


//FUNCIÓN LIMPIAR
function limpiar(){
}


//FUNCIÓN MOSTRAR FORMULARIO
function mostrarform(flag) {
    limpiar();
    if(flag){
        $("#listadoregistros").hide();
    }else{
        $("#listadoregistros").show();
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
            url: '../ajax/promedio.php?op=listar',
            type: "get",
            dataType: "json",
            error: function(e){
                console.log(e,responseText);
            }
        },
        "bDestroy":true,
        "iDisplayLength": 10, //PAGINACIÓN --> CADA 10 REGISTROS
        "order": [[0, "desc" ]] //ORDENAR (COLUMNA, ORDEN)
    }).DataTable();
}

init();