
var USUARIO_ID = null;

$(document).ready(function () {
    select2.iniciar();
    
    cargarControlador('Usuario');

    obtenerConfiguracionInicial();
    obtenerUsuarios();

});


function respuestaAjax(data)
{
    console.log(data);
    switch (data.nombre)
    {
        case "obtenerConfiguracionInicial":
            onResponseObtenerPerfiles(data.respuesta);
            break;
        case "obtenerUsuarios":
            onResponseObtenerUsuarios(data.respuesta);
            break;
        case "validarDNI":
            if (data.respuesta[0]['vout_exito'] === 1)
            {
                onResponseValidarDNI(data.respuesta);
            }
            else
            {
                mensajeAviso(data.respuesta[0]['vout_mensaje']);
            }
            break;
        case "agregarUsuario":
            if (data.respuesta[0]['vout_exito'] === 1)
            {
                onResponseAgregarUsuario(data.respuesta);

            }
            break;
        case "editarUsuario":
            if (data.respuesta[0]['vout_resultado'] === 1)
            {
                onResponseEditarUsuario(data.respuesta);

            }
            break;
        case "eliminarUsuario":
            if (data.respuesta[0]['vout_resultado'] === 1)
            {
                mensajeExito(data.respuesta[0]['vout_mensaje']);
                obtenerUsuarios();
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


function obtenerConfiguracionInicial()
{
    agregarFuncion("obtenerConfiguracionInicial");
    enviarDataAjax();
}

function onResponseObtenerPerfiles(data)
{
    $('cboPerfilesUsuario').empty();
    select2.cargar('cboPerfilesUsuario', data.perfiles, 'id', 'nombre');
    select2.asignarValorPredeterminado('cboPerfilesUsuario');
    select2.cargar('cboPerfilValidado', data.perfiles, 'id', 'nombre');
    select2.cargar('cboCarrera', data.carreras, 'id', 'nombre');
}

function obtenerUsuarios()
{
    agregarFuncion("obtenerUsuarios");
    enviarDataAjax();
}

function onResponseObtenerUsuarios(data)
{
    if (data !== "-1")
    {
        $.each(data, function (index, item) {

            data[index]["opciones"] = '<a onclick="editarUsuario(' + item['id'] + ',' + item['codigo_identificacion'] + ',' + item['perfil_id'] + ', \'' + item['nombres'] + '\', \'' + item['apellido_paterno'] + '\', \'' + item['apellido_materno'] + '\',' + item['edad'] + ', \'' + item['sexo_valor'] + '\',\'' + item['celular'] + '\', \'' + item['fecha_nacimiento'] + '\',' + item['carrera_id'] + ',' + item['estado_usuario'] + ')"><b><i class="fa fa-edit" style="color:#E8BA2F;"></i><b></a>\n\
                                   <a onclick="eliminarUsuario(' + item['id'] + ')"><b><i class="fa fa-trash-o" style="color:#cb2a2a;"></i><b></a>';

            if (data[index]["estado_usuario"] === 1)
            {
                data[index]["estado_usuario"] = '<a href="#"><b><i class="fa fa-check-circle" style="color:#5cb85c"></i><b></a>';
            }
            else
            {
                data[index]["estado_usuario"] = '<a href="#"><b><i class="fa fa-check-circle" style="color:#cb2a2a"></i><b></a>';
            }
        });

        $('#datatable').dataTable({
//            "scrollX": true,
            "order": [[0, "desc"]],
            "data": data,
            "columns": [
                {"data": "codigo_identificacion"},
                {"data": "nombre_perfil"},
                {"data": "nombre_usuario"},
                {"data": "edad"},
                {"data": "sexo"},
                {"data": "celular"},
                {"data": "fecha_nacimiento"},
                {"data": "carrera_nombre"},
                {"data": "estado_usuario", "sClass": "alignCenter"},
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

function validarDNI(dni, perfil)
{
    agregarFuncion("validarDNI");
    agregarParametro("usuario_id", USUARIO_ID);
    agregarParametro("dni", dni);
    agregarParametro("perfil", perfil);
    enviarDataAjax();
}

function onResponseValidarDNI(data)
{
    $('#txtDNIValidado').val(data[0]['dni']);

    select2.asignarValor('cboPerfilValidado', data[0]['perfil']);
    select2.readonly('cboPerfilValidado', data[0]['perfil']);
    $('#modalDatosUsuario').modal('show');
}

function guardarUsuario(dni, perfil, nombre, apellidoPaterno, apellidoMaterno, edad, sexo, celular, fechaNacimiento, estado, carrera)
{
    if (!isEmpty(USUARIO_ID))
    {
        agregarFuncion("editarUsuario");
        agregarParametro("usuario_id", USUARIO_ID);
    }
    else
    {
        agregarFuncion("agregarUsuario");
    }
    agregarParametro("dni", dni);
    agregarParametro("perfil", perfil);
    agregarParametro("nombre", nombre);
    agregarParametro("apellido_paterno", apellidoPaterno);
    agregarParametro("apellido_materno", apellidoMaterno);
    agregarParametro("edad", edad);
    agregarParametro("sexo", sexo);
    agregarParametro("celular", celular);
    agregarParametro("fecha_nacimiento", fechaNacimiento);
    agregarParametro("estado", estado);
    agregarParametro("carrera", carrera);
    enviarDataAjax();
}

function onResponseAgregarUsuario(data)
{
    $('#modalDatosUsuario').modal('hide');
    mensajeExito(data[0]['vout_mensaje']);
    obtenerUsuarios();
    limpiarModal();
}

function onResponseEditarUsuario(data)
{
    $('#modalDatosUsuario').modal('hide');
    mensajeExito(data[0]['vout_mensaje']);
    obtenerUsuarios();
    limpiarModal();
}

function eliminarUsuario(usuarioId)
{
    agregarFuncion("eliminarUsuario");
    agregarParametro("usuario_id", usuarioId);
    enviarDataAjax();
}
//funciones extras

function validarDNIUsuario()
{
    var dni = $('#txtDni').val();
    var perfil = $('#cboPerfilesUsuario').val();

    if (validarNumero(dni, 8) && dni.length === 8)
    {
        if (validarCadena(perfil, 0))
        {
            validarDNI(dni, perfil);

        }
        else
        {
            mensajeAviso("Seleccione un perfil.");
        }

    }
    else
    {
        mensajeAviso("Ingrese un DNI valido.");
    }
}

function agregarDatosUsuario()
{
    var dni = $('#txtDNIValidado').val();
    var perfil = $('#cboPerfilValidado').val();
    var nombre = $('#txtNombre').val();
    var apellidoPaterno = $('#txtApellidoPaterno').val();
    var apellidoMaterno = $('#txtApellidoMaterno').val();
    var edad = $('#txtEdad').val();
    var sexo = $('#cboSexo').val();
    var celular = $('#txtCelular').val();
    var fechaNacimiento = $('#txtFechaNacimiento').val();
    var estado = $('#cboEstado').val();
    var carrera = $('#cboCarrera').val();

    if (validarCadena(nombre, 50) && validarCadena(apellidoPaterno, 50) &&
            validarCadena(apellidoMaterno, 50) && validarNumero(edad, 2) &&
            validarCadena(sexo, 1) && validarNumero(celular, 0) &&
            validarCadena(fechaNacimiento, 10) && validarNumero(estado, 1))
    {
        guardarUsuario(dni, perfil, nombre, apellidoPaterno, apellidoMaterno, edad, sexo, celular, fechaNacimiento, estado,carrera);
    }
    else
    {
        mensajeAviso("Falta ingresar datos.");
    }
}

function editarUsuario(usuarioId, dni, perfilId, nombre, apellidoPaterno, apellidoMaterno, edad,
        sexo, celular, fechaNacimiento,carreraId, estado)
{
    USUARIO_ID = usuarioId;
    $('#txtDni').val(dni);
    select2.asignarValor('cboPerfilesUsuario', perfilId);

    $('#txtNombre').val(quitarNULL(nombre));
    $('#txtApellidoPaterno').val(quitarNULL(apellidoPaterno));
    $('#txtApellidoMaterno').val(quitarNULL(apellidoMaterno));
    $('#txtEdad').val(quitarNULL(edad));
    select2.asignarValor('cboSexo', sexo);
    $('#txtCelular').val(quitarNULL(celular));
    $('#txtFechaNacimiento').val(quitarNULL(fechaNacimiento));
    select2.asignarValor('cboEstado', estado);
    select2.asignarValor('cboCarrera',carreraId);
    
    focus();
}

function limpiarModal()
{
    $('#txtDni').val("");
    select2.asignarValor('cboPerfilesUsuario', "");

    $('#txtDNIValidado').val("");
    select2.asignarValor('cboPerfilValidado', "");
    $('#txtNombre').val("");
    $('#txtApellidoPaterno').val("");
    $('#txtApellidoMaterno').val("");
    $('#txtEdad').val("");
    select2.asignarValor('cboSexo', "M");
    $('#txtCelular').val("");
    $('#txtFechaNacimiento').val("");
    select2.asignarValor('cboEstado', "1");
}

function focus()
{
    $('#txtDni').focus();
}



