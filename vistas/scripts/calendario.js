//FUNCIÓN QUE SE EJECUTA AL INICIO
function init() {
  calendario()
  fecha_cita.min = new Date().toISOString().split("T")[0];
  $("#formCitas").on("submit",function(e){
    guardaryeditar(e);
  });

  $("#btnHora").click(function(e){
    e.preventDefault();
    especialidad=$("#especialidad_idespecialidad").val();
    personaMedico=$("#personaMedico_idpersona").val();
    fecha=$("#fecha_cita").val();

    $.post("../ajax/calendario.php?op=selecthora",
    {"especialidad_idespecialidad":especialidad,
    "personaMedico_idpersona":personaMedico,
    "fecha_cita":fecha},

    function(data) {
      if (data!="null") {
        $("#idcita_medica").html(data);    
      } else {
        Swal.fire({
          icon: 'warning',
          title: 'Disponibilidad',
          text: 'No existen horarios disponibles es esa fecha',
          showConfirmButton: false,
          timer: 2500
        });
      }
    });
  });


  // CARGAMOS LOS ITEMS AL SELECT ESPECIALIDAD
  $.post("../ajax/calendario.php?op=selectEspecialidad",function(r) {
    //console.log(data);
    $("#especialidad_idespecialidad").html(r);
    $("#especialidad_idespecialidad").selectpicker('refresh');
  });
  
  $.post("../ajax/calendario.php?op=selectPaciente",function(r) {        
    //console.log(data);
    $("#personaPaciente_idpersona").html(r);
    $("#personaPaciente_idpersona").selectpicker('refresh');    
  });

  $("#especialidad_idespecialidad").change(function() {
    $("#especialidad_idespecialidad option:selected").each(function() {
      idespecialidad= $(this).val();
      $.post("../ajax/calendario.php?op=selectMedico",{idespecialidad:idespecialidad},function(r) {         
        $("#personaMedico_idpersona").html(r);
        //$("#personaMedico_idpersona").selectpicker('refresh');
      });
    });
  });      

} //FIN INIT

// FUNCIÓN LIMPIAR CITAS
function limpiar(){
  $("#idcita_medica").val("");
  $("#especialidad_idespecialidad").val("");
  $("#personaPaciente_idpersona").val("");
  $("#personaMedico_idpersona").val("");
  $("#fecha_cita").val("");
  $("#motivo_consulta").val("");
  $("#horario_idhorario").val("");
}

// FUNCIÓN CALENDARIO CITAS
function calendario() { 

  document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
      locale: 'es',
      navLinks: true,
      headerToolbar: {
        left: 'prev,next today',
        center: 'title',
        right: 'dayGridMonth,timeGridWeek,timeGridDay'
      },
      events: '../ajax/calendario.php?op=listarCitas',

      dateClick: function(info) {
        var date = new Date(info.date);
        var hoy = new Date();
        var ayer = new Date(hoy - 24 * 60 * 60 * 1000);

        if (date > ayer) {
          $("#fecha_cita").val(info.dateStr);   
          $("#modalCitas").modal();
        } else {
          bootbox.alert({
            message: "No se puede agendar citas en una fecha vencida"
          });
        }  
      },
      
      /*eventClick: function(event, jsEvent, view){
        $('#modalCitas').modal(); //hay que verificar para que traiga los datos a editar
      },*/

      hiddenDays: [0,6]
    }); // FIN EVENLISTENER
    calendar.render();
  });
} // FIN FUNCIÓN CALENDARIO


// FUNCIÓN GUARDAR Y EDITAR CITAS
function guardaryeditar(e){
  e.preventDefault(); // NO SE ACTIVA LA ACCIÓN PREDETERMINADA DEL EVENTO
  
  var formData = new FormData($("#formCitas")[0]);
  $.ajax({
    url: "../ajax/calendario.php?op=guardarCita",
    type: "POST",
    data: formData,
    contentType: false,
    processData: false,
      
    success: function(datos){
      alert(datos);
      location.reload();
    }   
  });
}

init();