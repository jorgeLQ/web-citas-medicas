//VERIFICA LAS CREDENCIALES DE ACCESO AL SISTEMA CON EL LOGIN, CLAVE Y ROL

$("#frmAcceso").on('submit', function(e) {
	e.preventDefault();
    logina=$("#logina").val();
    clavea=$("#clavea").val();
    rol_idrol=$("#rol_idrol").val();

    $.post("../ajax/login.php?op=verificar", {"logina":logina,"clavea":clavea,"rol_idrol":rol_idrol}, function(data) {
        if (data!="null") {
            $(location).attr("href","home.php");               
        } else {
            Swal.fire({
                icon: 'error',
                title: 'ERROR',
                text: 'Usuario y/o Password incorrectos!',
                showConfirmButton: false,
                timer: 2500
            });
        }
    });
});
$.post("../ajax/login.php?op=selectRol", function(r) {        
    //console.log(data);
    $("#rol_idrol").html(r);
    
});