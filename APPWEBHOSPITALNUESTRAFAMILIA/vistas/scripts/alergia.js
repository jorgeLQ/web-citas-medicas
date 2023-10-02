var tabla;

//FUNCIÓN QUE SE EJECUTA AL INICIO
function init() {
    mostrarform(false);
    listar();
    $("#formularioe").on("submit",function(e){
        guardaryeditar(e);
    });
    //cargamos el select persona paciente 
    $.post("../ajax/alergia.php?op=selectPaciente",function(r) {        
        $("#personaPaciente_idpersona").html(r);
        $("#personaPaciente_idpersona").selectpicker('refresh');    
      });
    //deshabilitar los dias anteriores al dia actual
    fecha.min = new Date().toISOString().split("T")[0];
}


//FUNCIÓN LIMPIAR
function limpiar(){
    $("#idalergia").val("");
    $("#personaPaciente_idpersona").val("");
    $("#fecha").val("");
    $("#observacion").val("");
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
            url: '../ajax/alergia.php?op=listar',
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
        url: "../ajax/alergia.php?op=guardaryeditar",
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
function mostrar(idalergia) {
    $.post("../ajax/alergia.php?op=mostrar",{idalergia : idalergia}, function(data, status) {
        data = JSON.parse(data); //Lo que recivimos de ../ajax/especialidad.php?op=mostrar, lo convertimos a un objeto javaScript
        mostrarform(true);
        $("#personaPaciente_idpersona").val(data.persona_idpersona);
        $("#personaPaciente_idpersona").selectpicker('refresh');
        $("#fecha").val(data.fecha);
        $("#observacion").val(data.observacion);
        $("#idalergia").val(data.idalergia);
    });
}


/*//FUNCIÓN DESACTIVAR ESPECIALIDAD
function desactivar(idalergia) {
    alertify.confirm("Alergia","¿Estas seguro de desactivar la Alergia?", function() {
        $.post("../ajax/alergia.php?op=desactivar", {idalergia : idalergia}, function(e) {
            //alertify.alert(e);
            tabla.ajax.reload();
            alertify.success('Alergia desactivada');
        });
    },
    function() {
        alertify.error('Cancelado');
    });
}


//FUNCIÓN ACTIVAR ESPECIALIDAD
function activar(idalergia)
{
    alertify.confirm("Alergia","¿Estas seguro de activar la Alergia?", function(){
        $.post("../ajax/alergia.php?op=activar", {idalergia : idalergia}, function(e) {
            //alertify.alert(e);
            tabla.ajax.reload();
            alertify.success('Alergia activada');
        });
    },
    function(){
        alertify.error('Cancelado');
    });
}*/
//eliminar alergia

function eliminarAlergia(idalergia) {
    $.post("../ajax/alergia.php?op=eliminar", {idalergia : idalergia}, function(e) {
        tabla.ajax.reload();
        Swal.fire(
        'Eliminado!',
        'La alergia fue eliminada correctamente.',
        'success'
        )
    });
} 
//FUNCIÓN ALERTA PARA ELIMINAR HORARIOS DISPONIBLES
function alerEliminar(idalergia) {
    Swal.fire({
        title: 'Estas seguro de eliminar?',
        text: "No volveras  ver el registro",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, Eliminar!'
    }).then((result) => {
        if (result.isConfirmed) {
            eliminarAlergia(idalergia);
        }
    })
}


init();