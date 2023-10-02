//FUNCIÓN QUE SE EJECUTA AL INICIO
function init() {
  validar();
  //soloLetras();
  //soloNumeros();
}


//FUNCIÓN PARA VALIDAR CÉDULA
function validar() {
  $('#cedula').keyup(function() {
    var cad = $("#cedula").val();
    var total = 0;
    var longitud = cad.length;
    var longcheck = longitud - 1;

    if (cad !== "" && longitud === 10){
      for(i = 0; i < longcheck; i++){
        if (i%2 === 0) {
          var aux = cad.charAt(i) * 2;
          if (aux > 9) aux -= 9;
          total += aux;
        } else {
          total += parseInt(cad.charAt(i)); // parseInt o concatenará en lugar de sumar
        }
      }

      total = total % 10 ? 10 - total % 10 : 0;

      if (cad.charAt(longitud-1) == total) {
        $('#cedula').css("background-color", "#D8F6CE");
        //$('#text').html('<label> Cédula válida</label>');
      }else{
        $('#cedula').css("background-color", "#F8E0E6");
        //$('#text').html('<label> Cédula no válida</label>');
      }
    }
  });
}


//FUNCIÓN PARA VALIDAR SOLO LETRAS
/*function soloLetras(e) {
  key = e.keyCode || e.which;
  tecla = String.fromCharCode(key).toLowerCase();
  letras = " áéíóúabcdefghijklmnñopqrstuvwxyz";
  especiales = [8, 37, 39, 46];

  tecla_especial = false
  for(var i in especiales) {
    if(key == especiales[i]) {
      tecla_especial = true;
      break;
    }
  }

  if(letras.indexOf(tecla) == -1 && !tecla_especial)
  return false;
}*/


//FUNCIÓN PARA VALIDAR SOLO NUMEROS
/*function soloNumeros(e) {
  key = e.keyCode || e.which;
  tecla = String.fromCharCode(key).toLowerCase();
  letras = "0123456789";
  especiales = [8, 37, 39, 46];

  tecla_especial = false
  for(var i in especiales) {
    if(key == especiales[i]) {
      tecla_especial = true;
      break;
    }
  }

  if(letras.indexOf(tecla) == -1 && !tecla_especial)
  return false;
}*/
init();