
var PUBLICACION_ID = null;

$(document).ready(function () {
    select2.iniciar();

    cargarControlador('Publicacion');

    obtenerPublicaciones();

});


function respuestaAjax(data)
{
    console.log(data);
    switch (data.nombre)
    {

        case "obtenerPublicaciones":
            onResponseobtenerPublicaciones(data.respuesta);
            break;
        case "agregarPublicacion":
            if (data.respuesta[0]['vout_resultado'] === 1)
            {
                onResponseAgregarPublicacion(data.respuesta);
            }
            else
            {
                mensajeAviso(data.respuesta[0]['vout_mensaje']);
            }
            break;
        case "obtenerPublicacionXId":
            onResponseObtenerPublicacionXId(data.respuesta);
            break;
           
        case "editarPublicacion":
            if (data.respuesta[0]['vout_resultado'] === 1)
            {
                onResponseEditarPublicacion(data.respuesta);

            }
            else
            {
                mensajeAviso(data.respuesta[0]['vout_mensaje']);
            }
            break;
        case "eliminarPublicacion":
            if (data.respuesta[0]['vout_resultado'] === 1)
            {
                mensajeExito(data.respuesta[0]['vout_mensaje']);
                obtenerPublicaciones();
            }
            else
            {
                mensajeAviso(data.respuesta[0]['vout_mensaje']);
            }
            break;
        default :
            break;
    }
}


function obtenerPublicaciones()
{
    agregarFuncion("obtenerPublicaciones");
    enviarDataAjax();
}


function onResponseobtenerPublicaciones(data)
{
    if (data !== "-1")
    {
        $.each(data, function (index, item) {

            data[index]["opciones"] = '<a onclick="editarPublicacion(' + item['id'] + ')"><b><i class="fa fa-edit" style="color:#E8BA2F;"></i><b></a>\n\
                                   <a onclick="eliminarPublicacion(' + item['id'] + ')"><b><i class="fa fa-trash-o" style="color:#cb2a2a;"></i><b></a>';

            if (data[index]["estado"] === 1)
            {
                data[index]["estado"] = '<a href="#"><b><i class="fa fa-check-circle" style="color:#5cb85c"></i><b></a>';
            }
            else
            {
                data[index]["estado"] = '<a href="#"><b><i class="fa fa-check-circle" style="color:#cb2a2a"></i><b></a>';
            }
        });

        $('#datatable').dataTable({
//            "scrollX": true,
            "order": [[0, "asc"]],
            "data": data,
            "columns": [
                {"data": "titulo"},
                {"data": "estado", "sClass": "alignCenter"},
                {"data": "opciones", "sClass": "alignCenter"}
            ],
            "destroy": true
        });
    }
    else
    {
        var table = $('#datatable').DataTable();
        table.clear().draw();
    }
}


function guardarPublicacion(titulo,mensaje, estado)
{
    if (!isEmpty(PUBLICACION_ID))
    {
        agregarFuncion("editarPublicacion");
        agregarParametro("publicacion_id", PUBLICACION_ID);
    }
    else
    {
        agregarFuncion("agregarPublicacion");
    }
    agregarParametro("titulo", titulo);
    agregarParametro("mensaje", mensaje);
    agregarParametro("estado", estado);
    enviarDataAjax();
}

function onResponseAgregarPublicacion(data)
{
    mensajeExito(data[0]['vout_mensaje']);
    obtenerPublicaciones();
    limpiarFormPublicacion();
}

function onResponseEditarPublicacion(data)
{
    mensajeExito(data[0]['vout_mensaje']);
    obtenerPublicaciones();
    limpiarFormPublicacion();
}

function eliminarPublicacion(publicacionId)
{
    agregarFuncion("eliminarPublicacion");
    agregarParametro("publicacion_id", publicacionId);
    enviarDataAjax();
}

function editarPublicacion(publicacionId)
{
    agregarFuncion("obtenerPublicacionXId");
    agregarParametro("publicacion_id", publicacionId);
    enviarDataAjax();
}

function onResponseObtenerPublicacionXId(data)
{
    PUBLICACION_ID = data[0]['id'];
    $('#txtTitulo').val(data[0]['titulo']);
    $('#txtMensaje').val(data[0]['mensaje']);
    select2.asignarValor('cboEstado',data[0]['estado']);
    
    $('#txtTitulo').focus();
}


//funciones extras

function agregarPublicacion()
{
    var titulo = $('#txtTitulo').val();
    var mensaje = $('#txtMensaje').val();
    var estado = $('#cboEstado').val();


    if (validarCadena(titulo,200) && validarCadena(mensaje,5000))
    {
        guardarPublicacion(titulo,mensaje, estado);
    }
    else
    {
        mensajeAviso("Ingrese una carrera.");
    }

}

function limpiarFormPublicacion()
{
    $('#txtTitulo').val("");
    $('#txtMensaje').val("");
    select2.asignarValor('cboEstado', "1");
}



