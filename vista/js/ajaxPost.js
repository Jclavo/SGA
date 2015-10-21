/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
var url;
var cadena = "";
function agregarParametro(nombre, valor)
{
    cadena += nombre + "=" + valor + "&";
}

function agregarFuncion(nombre)
{
    cadena = "";
    cadena += "funcion=" + nombre + "&";
}

function cargarControlador(controlador)
{
    url = URL_BASE + 'controlador/sga/' + controlador + 'Controlador.php';
}

function enviarDataAjax() {
    console.log(url);
    console.log(cadena);

    $.ajax({
        async: true,
        type: "POST",
        dataType: "json",
        contentType: "application/x-www-form-urlencoded",
        url: url,
        data: cadena,
        success: function (data) {   ///    peticion  de  php 
            switch (data.nombre)
            {

                case "cerrarSesion":
                    if (data.respuesta[0]['vout_resultado'] === 0)
                    {
                        location.href = 'login.php';
                    }
                    break;
                case "cambiarContrasenha":
                    if (data.respuesta[0]['vout_resultado'] === 0)
                    {
                        mensajeAviso(data.respuesta[0]['vout_mensaje']);
                    }
                    else
                    {
                        onResponseCambiarcontrasenha(data.respuesta);

                    }
                    break;

                default :respuestaAjax(data);
                    break;
            }
            
        },
        error: function () {
            mensajeError("error");
        },
        timeout: 4000
    }).fail(function (jqXHR, textStatus, errorThrown) {

        if (jqXHR.status === 0) {

            mensajeError('Not connect: Verify Network.');

        } else if (jqXHR.status == 404) {

            mensajeError('Requested page not found [404]');

        } else if (jqXHR.status == 500) {

            mensajeError('Internal Server Error [500].');

        } else if (textStatus === 'parsererror') {

            mensajeError('Requested JSON parse failed.');

        } else if (textStatus === 'timeout') {

            mensajeError('Time out error.');

        } else if (textStatus === 'abort') {

            mensajeError('Ajax request aborted.');

        } else {

            mensajeError('Uncaught Error: ' + jqXHR.responseText);

        }

    });
}

function functionBreak()
{
    return;
}

function cerrarSesion()
{
    agregarFuncion("cerrarSesion");
    enviarDataAjax();
}

function onResponseCambiarcontrasenha(data)
{
    $('#modalCambiarContrasenha').modal('hide');
    mensajeExito(data[0]['vout_mensaje']);
}
                

function abrirModalCambiarContrasenha()
{
    $('#txtContrasenhaAnterior').val("");
    $('#txtContrasenhaNueva1').val("");
    $('#txtContrasenhaNueva2').val("");
    
    $('#modalCambiarContrasenha').modal('show');
}

function aceptarCambiarContrasenha()
{
    var contrasenhaAnterior = $('#txtContrasenhaAnterior').val();
    var contrasenhaNueva1 = $('#txtContrasenhaNueva1').val();
    var contrasenhaNueva2 = $('#txtContrasenhaNueva2').val();
    
    if(validarCadena(contrasenhaAnterior,0) && validarCadena(contrasenhaNueva1,0) && validarCadena(contrasenhaNueva2,0))
    {
        cambiarContrasenha(contrasenhaAnterior,contrasenhaNueva1,contrasenhaNueva2);
    }
    else
    {
        mensajeAviso("Falta ingresar datos.");
    }
}

function cambiarContrasenha(contrasenhaAnterior,contrasenhaNueva1,contrasenhaNueva2)
{
    agregarFuncion("cambiarContrasenha");
    agregarParametro("contrasenha_anterior", contrasenhaAnterior);
    agregarParametro("contrasenha_nueva_1", contrasenhaNueva1);
    agregarParametro("contrasenha_nueva_2", contrasenhaNueva2);
    enviarDataAjax();
}
