
$(document).ready(function () {
    cargarControlador('Usuario');
    verificarSesion();

});

function respuestaAjax(data)
{
    console.log(data);
    switch (data.nombre)
    {
        case "verificarSesion":
            cargarMenu(data.respuesta);
            cargarPagina("vista/com/publicacion/reportePublicacion.php");
            break;
//        case "cerrarSesion":
//            if (data.respuesta[0]['vout_resultado'] === 0)
//            {
//                location.href = 'login.php';
//            }
//            break;
//        case "cambiarContrasenha":
//            if (data.respuesta[0]['vout_resultado'] === 0)
//            {
//                mensajeAviso(data.respuesta[0]['vout_mensaje']);
//            }
//            else
//            {
//                onResponseCambiarcontrasenha(data.respuesta);
//                
//            }
//            break;

        default :
            break;
    }
}

function cargarMenu(data)
{
//    if (data[0]['vout_resultado'] === 0)
//    {
//        location.href = 'login.php';
//    }
//    else
//    {
        if (data.menu[0]['vout_resultado'] === 0)
        {
            location.href = 'login.php';
        }
        else
        {
            cargarInfoUsuario(data.info);
            cargarOpciones(data.menu);
        }
//    }
}

function cargarInfoUsuario(data)
{
    $('#nombreUsuario').empty();
    $('#nombreUsuario').append(data[0]['nombre'] + " [" + data[0]['perfil'] + "]");
}
function cargarOpciones(data)
{
    var plantillaMenu = "";
    $.each(data, function (index, value) {

        plantillaMenu += "<li class='active'>";
        plantillaMenu += "<a onclick=cargarPagina('" + value.ruta + "')>";
        plantillaMenu += "<i class = \"" + value.icono + "\"></i>";
        plantillaMenu += "<span>" + value.descripcion + "</span>";
        plantillaMenu += "</a>";
        plantillaMenu += "</li>";
    });

    $('#usuarioMenu').append(plantillaMenu);
}

function verificarSesion()
{
    agregarFuncion("verificarSesion");
    enviarDataAjax();
}

//function cerrarSesion()
//{
//    agregarFuncion("cerrarSesion");
//    enviarDataAjax();
//}
function cargarPagina(ruta)
{
//    mensajeAviso(ruta);
    $("#cuerpo").empty();
    $("#cuerpo").load(ruta);
}
//
//function onResponseCambiarcontrasenha(data)
//{
//    $('#modalCambiarContrasenha').modal('hide');
//    mensajeExito(data[0]['vout_mensaje']);
//}
//                
//
//function abrirModalCambiarContrasenha()
//{
//    $('#txtContrasenhaAnterior').val("");
//    $('#txtContrasenhaNueva1').val("");
//    $('#txtContrasenhaNueva2').val("");
//    
//    $('#modalCambiarContrasenha').modal('show');
//}
//
//function aceptarCambiarContrasenha()
//{
//    var contrasenhaAnterior = $('#txtContrasenhaAnterior').val();
//    var contrasenhaNueva1 = $('#txtContrasenhaNueva1').val();
//    var contrasenhaNueva2 = $('#txtContrasenhaNueva2').val();
//    
//    if(validarCadena(contrasenhaAnterior,0) && validarCadena(contrasenhaNueva1,0) && validarCadena(contrasenhaNueva2,0))
//    {
//        cambiarContrasenha(contrasenhaAnterior,contrasenhaNueva1,contrasenhaNueva2);
//    }
//    else
//    {
//        mensajeAviso("Falta ingresar datos.");
//    }
//}
//
//function cambiarContrasenha(contrasenhaAnterior,contrasenhaNueva1,contrasenhaNueva2)
//{
//    agregarFuncion("cambiarContrasenha");
//    agregarParametro("contrasenha_anterior", contrasenhaAnterior);
//    agregarParametro("contrasenha_nueva_1", contrasenhaNueva1);
//    agregarParametro("contrasenha_nueva_2", contrasenhaNueva2);
//    enviarDataAjax();
//}