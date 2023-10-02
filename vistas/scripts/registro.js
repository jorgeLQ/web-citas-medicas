//FUNCIÓN QUE SE EJECUTA AL INICIO
function init() {
    $("#frmRegistro").on("submit",function(e){
    guardaryeditar(e);
    //bootbox.alert("Usuario registrado");
    //$(location).attr("href","login.php");
    });
}

// FUNCIÓN LIMPIAR
function limpiar(){
    $("#idusuario").val("");
    $("#cedula").val("");
    $("#nombres").val("");
    $("#apellidos").val("");
    $("#email").val("");
    $("#telefono").val("");
    $("#direccion").val("");
    $("#ciudad_residencia").val("");
    $("#fecha_nacimiento").val("");
    $("#edad").val("");
    $("#genero").val("");
    $("#imagen").val("");
    $('#cedula').css("background-color", "#FFFFFF");
}

// FUNCIÓN GUARDAR O EDITAR
function guardaryeditar(e){
    e.preventDefault();
    //$("#btnGuardar").prop("disabled",true);
    var formData = new FormData($("#frmRegistro")[0]);
    $.ajax({
        url: "../ajax/registro.php?op=guardaryeditar",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,

        success: function(datos){
            alert(datos);
            $("#frmRegistro").hide();
            $(location).attr("href","login.php");
        }
    });
    limpiar();

}

init();