var tabla;

//FUNCIÓN QUE SE EJECUTA AL INICIO
function init() {
    mostrarform(false);
    listar();
    $("#formulariocita").on("submit",function(e) 
    {
        guardaryeditar(e);
    })

    //CARGAMOS LOS ITEMS AL SELECT ESTADO
    $.post("../ajax/cita.php?op=selectEstado",function(r) {        
        //console.log(data);
        $("#estado_idestado").html(r);
        $('#estado_idestado').selectpicker('refresh');
    });
}


//FUNCIÓN LIMPIAR
function limpiar()
{
    $("#idcita_medica").val("");
    $("#especialidad_idespecialidad").val("");
    $("#personaPaciente_idpersona").val("");
    $("#diagnostico").val("");
    $("#sintomas").val("");
    $("#motivo_consulta").val("");
    $("#estado_idestado").val("");
    $(".filas").remove();
}


//FUNCIÓN MOSTRAR FORMULARIO
function mostrarform(flag)
{
    limpiar();
    if(flag) 
    {
        $("#listadoregistros").hide();
        $("#formularioregistros").show();
        $("#btnGuardar").prop("disabled",false);
        $("#btnagregar").hide();
        listarMedicamento();
        listarExamen();
    } else {
        $("#listadoregistros").show();
        $("#formularioregistros").hide();
        $("#btnagregar").show();
    }
}


//FUNCIÓN CANCELAR FORM
function cancelarform()
{
    limpiar();
    mostrarform(false);
}


//FUNCIÓN LISTAR CITA
function listar(){
    tabla=$('#tbllistadocita').dataTable({
        "aProcessing":true, //ACTIVAR EL PROCESAMIENTO DEL DATATABLE
        "aServerSide": true, //PAGINACIÓN Y FILTRADO REALIZADO POR EL SERVIDOR
        dom: 'Bfrtip', //DEFINIR LOS ELEMENTOS DEL CONTROL DE TABLA
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
            url: '../ajax/cita.php?op=listar',
            type: "get",
            dataTyoe: "json",
            error: function(e){
                console.log(e,responseText);
            }
        },
        "bDestroy":true,
        "iDisplayLength": 5, //PAGINACIÓN --> CADA 5 REGISTROS
        "order": [[0, "desc" ]] //ORDENAR (COLUMNA, ORDEN)
    }).DataTable();
}


//FUNCIÓN GUARDAR O EDITAR CITA
function guardaryeditar(e) {
    e.preventDefault(); //NO SE ACTIVA LA ACCIÓN PREDETERMINADA DEL EVENTO
    $("#btnGuardar").prop("disabled",true);
    var formData = new FormData($("#formulariocita")[0]);
    $.ajax({
        url: "../ajax/cita.php?op=guardaryeditar",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,

        success: function(datos)
        {
            alert(datos);
            mostrarform(false);
            location.reload();
        }
    });
    limpiar();
}


//FUNCIÓN MOSTRAR CITA
function mostrar(idcita_medica)
{
    $.post("../ajax/cita.php?op=mostrar",{idcita_medica : idcita_medica}, function(data, status)
    {
        data = JSON.parse(data);
        mostrarform(true);

        $("#especialidad_idespecialidad").val(data.especialidad_idespecialidad);
        $("#personaPaciente_idpersona").val(data.personaPaciente_idpersona);
        $("#diagnostico").val(data.diagnostico);
        $("#sintomas").val(data.sintomas);
        $("#motivo_consulta").val(data.motivo_consulta);
        $("#idcita_medica").val(data.idcita_medica);
    });
}

/****************************************
 *  
 * LISTA DE MEDICAMENTOS
 * 
 * ****************************************/

// LISTAR MEDICAMENTOS
function listarMedicamento() {
    tabla=$('#tblmedicamentos').dataTable({
        "aProcessing":true, //ACTIVAR EL PROCESAMIENTO DEL DATATABLE
        "aServerSide": true, //PAGINACIÓN Y FILTRADO REALIZADO POR EL SERVIDOR
        dom: 'Bfrtip', // DEFINIR LOS PARAMETROS DEL CONTROL DE TABLA
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json"
        },
        // BOTONES PARA COPIAR LOS REGISTROS EN DIFERENTES FORMATOS
        buttons:[
        ],
        "ajax":{
            url: '../ajax/cita.php?op=listarMedicamentos',
            type: "get",
            dataTyoe: "json",
            error: function(e){
                console.log(e,responseText);
            }
        },
        "bDestroy":true,
        "iDisplayLength": 5, //// PAGINACIÓN --> CADA 5 REGISTROS
        "order": [[0, "desc" ]] // ORDENAR (COLUMNA, ORDEN)
    }).DataTable();
}


// FUNCIÓN AGREGAR MEDICAMENTOS
var cont = 0;
var detalles = 0;
function agregarMedicamento(idmedicamento, nombre, descripcion) 
{
    var cantidad = 1;
    var observaciones="";
    if (idmedicamento != "") {
        var fila = '<tr class="filas" id="fila'+cont+'">'+
        '<td><div class="text-center"><button type="button" class="btn btn-danger btn-sm" onclick="eliminarMedicamento('+cont+')" title="Eliminar medicamento">X</button></div></td>'+
        '<td><input type="hidden" name="idmedicamento[]" value="'+idmedicamento+'">'+nombre+'</td>'+
        '<td><input type="hidden" name="descripcion[]" value="">'+descripcion+'</td>'+
        '<td><input type="number" max="100" min="1" name="cantidad[]" id="cantidad[]" value="'+cantidad+'"></td>'+
        '<td><textarea name="observaciones[]" id="observaciones[]" value="'+observaciones+'" required></textarea></td>'
        //<textarea name="observaciones[]" id="observaciones[]" rows="2"></textarea>
        '</tr>';
        cont++;
        detalles= detalles+1;
        $('#medicamentos').append(fila);
    } else {
        bootbox.alert("Error al ingresar el medicamento")
    }
}


// FUNCIÓN ELIMINAR MEDICAMENTOS
function eliminarMedicamento(indice) {
    $("#fila" + indice).remove();
  	detalles=detalles-1;
}

/****************************************
 *  
 * LISTA DE EXÁMENES 
 * 
 * ****************************************/

//FUNCIÓN LISTAR EXAMEN
function listarExamen() {
    tabla=$('#tblexamenes').dataTable({
        "aProcessing":true, //ACTIVAR EL PROCESAMIENTO DEL DATATABLE
        "aServerSide": true, //PAGINACIÓN Y FILTRADO REALIZADO POR EL SERVIDOR
        dom: 'Bfrtip', //DEFINIR LOS PARAMETROS DEL CONTROL DE TABLA
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json"
        },
        // BOTONES PARA COPIAR LOS REGISTROS EN DIFERENTES FORMATOS
        buttons:[
        ],
        "ajax":{
            url: '../ajax/cita.php?op=listarExamenes',
            type: "get",
            dataTyoe: "json",
            error: function(e){
                console.log(e,responseText);
            }
        },
        "bDestroy":true,
        "iDisplayLength": 5, //PAGINACIÓN --> CADA 5 REGISTROS
        "order": [[0, "desc" ]] //ORDENAR (COLUMNA, ORDEN)
    }).DataTable();
}


// FUNCIÓN AGREGAR EXAMEN
var cont2=0;
var detalles2=0;
function agregarExamen(idexamen,nombre,tipo) {
    if (idexamen!="") {
        var fila='<tr class="filas" id="fila2'+cont2+'">'+
        '<td><div class="text-center"><button type="button" class="btn btn-danger btn-sm" onclick="eliminarExamen('+cont2+')" title="Eliminar Examen">X</button></div></td>'+
        '<td><input type="hidden" name="idexamen[]" value="'+idexamen+'">'+nombre+'</td>'+
        '<td><input type="hidden" name="tipo[]" value="">'+tipo+'</td>'
        '</tr>';
        cont2++;
        detalles2= detalles2+1;
        $('#examenes').append(fila);
    } else {
        bootbox.alert("Error al ingresar el medicamento")
    }
}


// FUNCIÓN ELIMINAR EXAMEN
function eliminarExamen(indice) {
    $("#fila2" + indice).remove();
  	detalles=detalles-1;
}

init();