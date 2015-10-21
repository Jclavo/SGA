// JavaScript Document

$(document).ready(function () {
    cargarControlador('Usuario');
    cargarControlador('Usuario');
    obtenerPerfiles();
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

function iniciarSesion()
{
    var codigo = $('#codigo').val();
    var perfil = $('#cboPerfilesUsuario').val();
    var clave = $('#clave').val();

    if (validarCadena(codigo,0) && validarCbo(perfil))
    {
        agregarFuncion("iniciarSesion");
        agregarParametro("codigo", codigo);
        agregarParametro("perfil", perfil);
        agregarParametro("clave", clave);
        enviarDataAjax();
    }
    else
    {
        mensajeAviso("Falta ingresar datos");
    }

}

function respuestaAjax(data)
{
    console.log(data);
    switch (data.nombre)
    {
        case "iniciarSesion":

            console.log(data.respuesta[0]['vout_resultado']);
            if (data.respuesta[0]['vout_resultado'] == 1)
            {
                location.href = 'index.php';
            }
            else
            {
                mensajeError(data.respuesta[0]['vout_mensaje']);
            }

            break;
        case "obtenerPerfiles":
            onResponseObtenerPerfiles(data.respuesta);
            break;
        default :
            break;
    }

}

function obtenerPerfiles()
{
    agregarFuncion("obtenerPerfiles");
    enviarDataAjax();
}

function onResponseObtenerPerfiles(data)
{
    $('cboPerfilesUsuario').empty();
    select2.cargar('cboPerfilesUsuario', data, 'id', 'nombre');
    select2.cargar('cboPerfilValidado', data, 'id', 'nombre');
}









