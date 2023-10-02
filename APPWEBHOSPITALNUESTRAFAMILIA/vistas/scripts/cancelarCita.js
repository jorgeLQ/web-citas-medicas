var tabla;

//FUNCIÓN QUE SE EJECUTA AL INICIO
function init() {
    mostrarform(false);
    listar();
    $("#formularioe").on("submit",function(e) {
        guardaryeditar(e);
    });
}

// FUNCIÓN LIMPIAR
function limpiar(){
    $("#idcita_medica").val("");
    $("#nombre").val("");
}

// FUNCIÓN MOSTRAR FORMULARIO
function mostrarform(flag){
    limpiar();
    if(flag){
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

// FUNCIÓN CARCELAR FORM
function cancelarform(){
    limpiar();
    mostrarform(false);
}

//FUNCIÓN LISTAR
function listar(){
    tabla=$('#tbllistadoe').dataTable({
        "aProcessing":true, //ACTIVAR EL PROCESAMIENTO DEL DATATABLE
        "aServerSide": true, //PAGINACIÓN Y FILTRADO REALIZADO POR EL SERVIDOR
        dom: 'Bfrtip', // DEFINIR LOS PARAMETROS DEL CONTROL DE TABLA
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
            url: '../ajax/cancelarcita.php?op=listar',
            type: "get",
            dataType: "json",
            error: function(e){
                console.log(e,responseText);
            }
        },
        "bDestroy":true,
        "iDisplayLength": 5, // PAGINACIÓN --> CADA 5 REGISTROS
        "order": [[0, "desc" ]] // ORDENAR (COLUMNA, ORDEN)
    }).DataTable();
}

// FUNCIÓN GUARDAR O EDITAR
function guardaryeditar(e){
    e.preventDefault(); // NO SE ACTIVA LA ACCIÓN PREDETERMINADA DEL EVENTO
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

// FUNCIÓN MOSTRAR CITA
function mostrar(idcita_medica){
    $.post("../ajax/especialidad.php?op=mostrar",{idcita_medica : idcita_medica}, function(data, status) {
        data = JSON.parse(data);
        mostrarform(true);
        $("#nombre").val(data.nombre)
        $("#idcita_medica").val(data.idcita_medica)

    });
}

// FUNCIÓN ELIMINAR CITA
function eliminarCita(idcita_medica) {
    $.post(
        "../ajax/cancelarcita.php?op=eliminar", {idcita_medica : idcita_medica}, function(e) {
            tabla.ajax.reload();
            Swal.fire(
                'Cancelada!',
                'La cita fue cancelada correctamente.',
                'success'
            )
        });
}

// FUNCIÓN del MENSAJE ELIMINAR CITA
function alerEliminar(idcita_medica) {
    Swal.fire({
        title: 'Estas seguro de cancelar?',
        text: "El horario de esta cita estará disponible para otro paciente",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, Cancelar!'
      }).then((result) => {
        if (result.isConfirmed) {
            eliminarCita(idcita_medica);
        }
      })
}

init();