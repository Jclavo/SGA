// JavaScript Document

$(document).ready(function () {
    cargarURL('./controlador/prueba/controlador.php');
});

function grabar() {
    // Parametros
    var nombre = $('#nombre').val();
    var apellido = $('#apellidos').val();

    agregarFuncion("agregar");
    agregarParametro("nombre", nombre);
    agregarParametro("apellido", apellido);
    enviarDataAjax();
}

function grabar2() {
    $('#modificar').val(prompt('escriba el id del campo que desea modificar ', ''));     ///  campo oculto de  nombre  modificar 
    // Agregamos el valor de   cada  funcion
    // 
    var id = $('#modificar').val();
    var nombre = $('#nombre').val();
    var apellido = $('#apellidos').val();

    agregarFuncion("modificar");
    agregarParametro("id", id);
    agregarParametro("nombre", nombre);
    agregarParametro("apellido", apellido);
    enviarDataAjax();
}

function grabar3() {
    $('#modificar').val(prompt('escriba el id del campo que desea eliminar ', ''));
    // Agregamos el valor de suma
    var id = $('#modificar').val();

    agregarFuncion("eliminar");
    agregarParametro("id", id);
    enviarDataAjax();

}

function respuestaAjax(data)
{
    console.log(data);
    switch (data.nombre)
    {
        case "agregar":
            $('img#Preloader').css('display', 'none');  //  aca se oculta mi imagen 
            $("#respuesta").fadeIn();  //   muestro el  div
            $("#respuesta").addClass('result_ok');   ///  aca le agrego un clase  aeste div 
            $("#respuesta").html(data.respuesta[0]['vout_mensaje']).fadeOut(10000);    //la  opca  en  este tiempo
            break;
        case "modificar":
            $('img#Preloader').css('display', 'none');  //  aca se oculta mi imagen 
            $("#respuesta").fadeIn();  //   muestro el  div
            if (data.respuesta[0]['vout_exito'] == 1)
            {
                $("#respuesta").addClass('result_ok');   ///  aca le agrego un clase  aeste div 
            }
            else
            {
                $("#respuesta").addClass('result_error');   ///  aca le agrego un clase  aeste div 
            }
            $("#respuesta").html(data.respuesta[0]['vout_mensaje']).fadeOut(10000);    //la  opca  en  este tiempo
            break;
        case "eliminar":
            $('img#Preloader').css('display', 'none');  //  aca se oculta mi imagen 
            $("#respuesta").fadeIn();  //   muestro el  div
            if (data.respuesta[0]['vout_exito'] == 1)
            {
                $("#respuesta").addClass('result_ok');   ///  aca le agrego un clase  aeste div 
            }
            else
            {
                $("#respuesta").addClass('result_error');   ///  aca le agrego un clase  aeste div 
            }
            $("#respuesta").html(data.respuesta[0]['vout_mensaje']).fadeOut(10000);    //la  opca  en  este tiempo
            break;
    }

}







