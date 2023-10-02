var tabla;

//FUNCIÓN QUE SE EJECUTA AL INICIO
function init() {
    mostrarform(false);
    listar();
    $("#formularioe").on("submit",function(e){
        guardaryeditar(e);
    });

    //CARGAMOS LOS ITEMS AL SELECT ESPECIALIDAD
    $.post("../ajax/horario.php?op=selectEspecialidad",function(r) {        
        //console.log(data);
        $("#especialidad_idespecialidad").html(r);
        $("#especialidad_idespecialidad").selectpicker('refresh');    
    });

    $("#especialidad_idespecialidad").change(function() {
        $("#especialidad_idespecialidad option:selected").each(function() {
            idespecialidad= $(this).val();
            $.post("../ajax/horario.php?op=selectMedico",{idespecialidad:idespecialidad}, function(r){         
            $("#personaMedico_idpersona").html(r);
            //$("#personaMedico_idpersona").selectpicker('refresh');
            });
        });
    });

    //MOSTRAR HORARIOS
    $.post("../ajax/horario.php?op=selectHorario&id=", function(r) {   
        $("#horarios").html(r);
    });
    //deshabilitar los dias anteriores al dia actual
    fecha_cita.min = new Date().toISOString().split("T")[0];
}


//FUNCIÓN LIMPIAR
function limpiar(){
    $("#idespecialidad").val("");
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


//FUNCIÓN CANCELAR FORM
function cancelarform(){
    limpiar();
    mostrarform(false);
}


//FUNCIÓN LISTAR HORARIO
function listar(){
    tabla=$('#tbllistadoe').dataTable({
        "aProcessing":true, //ACTIVAR EL PROCESAMIENTO DEL DATATABLE
        "aServerSide": true, //PAGINACIÓN Y FILTRADO REALIZADO POR EL SERVIDOR
        dom: 'Bfrtip', //DEFINIR LOS PARAMETROS DEL CONTROL DE TABLA
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json"
        },
        // BOTONES PARA COPIAR LOS REGISTROS EN DIFERENTES FORMATOS
        buttons:[
            'copyHtml5',
            'excelHtml5',
            'csvHtml5',
            'pdf',
        ],
        "ajax":{
            url: '../ajax/horario.php?op=listar',
            type: "get",
            dataType: "json",
            error: function(e){
                console.log(e,responseText);
            }
        },
        "bDestroy":true,
        "iDisplayLength": 10, //PAGINACIÓN --> CADA 5 REGISTROS
        "order": [[0, "desc" ]] //ORDENAR (COLUMNA, ORDEN)
    }).DataTable();
}


//FUNCIÓN GUARDAR Y EDITAR HORARIO
function guardaryeditar(e){
    e.preventDefault(); //no se activa la accion predeterminada del evento
    $("#btnGuardar").prop("disabled",true);
    var formData = new FormData($("#formularioe")[0]);
    $.ajax({
        url: "../ajax/horario.php?op=guardaryeditar",
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


//FUNCIÓN PARA ELIMINAR HORARIOS DISPONIBLES
function eliminarHora(idcita_medica) {
    $.post("../ajax/horario.php?op=eliminar", {idcita_medica : idcita_medica}, function(e) {
        tabla.ajax.reload();
        Swal.fire(
        'Eliminado!',
        'La cita fue eliminada correctamente.',
        'success'
        )
    });
}


//FUNCIÓN ALERTA PARA ELIMINAR HORARIOS DISPONIBLES
function alerEliminar(idcita_medica) {
    Swal.fire({
        title: 'Estas seguro de eliminar?',
        text: "No volveras a agendar esta cita",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, Eliminar!'
    }).then((result) => {
        if (result.isConfirmed) {
            eliminarHora(idcita_medica);
        }
    })
}

init();