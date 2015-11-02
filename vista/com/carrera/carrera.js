
var CARRERA_ID = null;

$(document).ready(function () {
    select2.iniciar();

    cargarControlador('Carrera');

    obtenerCarreras();

});


function respuestaAjax(data)
{
    console.log(data);
    switch (data.nombre)
    {

        case "obtenerCarreras":
            onResponseObtenerCarreras(data.respuesta);
            break;
        case "agregarCarrera":
            if (data.respuesta[0]['vout_resultado'] === 1)
            {
                onResponseAgregarCarrera(data.respuesta);
            }
            else
            {
                mensajeAviso(data.respuesta[0]['vout_mensaje']);
            }
            break;
        case "editarCarrera":
            if (data.respuesta[0]['vout_resultado'] === 1)
            {
                onResponseEditarCarrera(data.respuesta);

            }
            else
            {
                mensajeAviso(data.respuesta[0]['vout_mensaje']);
            }
            break;
        case "eliminarCarrera":
            if (data.respuesta[0]['vout_resultado'] === 1)
            {
                mensajeExito(data.respuesta[0]['vout_mensaje']);
                obtenerCarreras();
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


function obtenerCarreras()
{
    agregarFuncion("obtenerCarreras");
    enviarDataAjax();
}


function onResponseObtenerCarreras(data)
{
    if (data !== "-1")
    {
        $.each(data, function (index, item) {

            data[index]["opciones"] = '<a onclick="editarCarrera(' + item['id'] + ', \'' + item['nombre'] + '\',\'' + item['precio'] + '\',' + item['estado'] + ')"><b><i class="fa fa-edit" style="color:#E8BA2F;"></i><b></a>\n\
                                   <a onclick="eliminarCarrera(' + item['id'] + ')"><b><i class="fa fa-trash-o" style="color:#cb2a2a;"></i><b></a>';

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
                {"data": "nombre"},
                {"data": "precio"},
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


function guardarCarrera(carrera,precio, estado)
{
    if (!isEmpty(CARRERA_ID))
    {
        agregarFuncion("editarCarrera");
        agregarParametro("carrera_id", CARRERA_ID);
    }
    else
    {
        agregarFuncion("agregarCarrera");
    }
    agregarParametro("carrera", carrera);
    agregarParametro("precio", precio);
    agregarParametro("estado", estado);
    enviarDataAjax();
}

function onResponseAgregarCarrera(data)
{
    mensajeExito(data[0]['vout_mensaje']);
    obtenerCarreras();
    limpiarFormCarrera();
}

function onResponseEditarCarrera(data)
{
    mensajeExito(data[0]['vout_mensaje']);
    obtenerCarreras();
    limpiarFormCarrera();
}

function eliminarCarrera(usuarioId)
{
    agregarFuncion("eliminarCarrera");
    agregarParametro("carrera_id", usuarioId);
    enviarDataAjax();
}



//funciones extras

function agregarCarrera()
{
    var carrera = $('#txtCarrera').val();
    var precio = $('#txtPrecio').val();
    var estado = $('#cboEstado').val();

    if (validarCadena(carrera, 50))
    {
        if (validarNumero(precio, 0))
        {
            guardarCarrera(carrera,precio, estado);
        }
        else
        {
            mensajeAviso("Ingrese un precio.");
        }

    }
    else
    {
        mensajeAviso("Ingrese una carrera.");
    }

}

function editarCarrera(carreraId, nombre,precio, estado)
{
    CARRERA_ID = carreraId;
    $('#txtCarrera').val(nombre);
    $('#txtPrecio').val(precio);
    select2.asignarValor('cboEstado', estado);

    $('#txtCarrera').focus();
}

function limpiarFormCarrera()
{
    $('#txtCarrera').val("");
    $('#txtPrecio').val("");
    select2.asignarValor('cboEstado', "1");
}



