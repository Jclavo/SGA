
var CURSO_HORARIO_ID = null;
var CURSO_ID = null;

$(document).ready(function () {
    select2.iniciar();

    cargarControlador('CursoHorario');

    obtenerConfiguracionInicialCursoHorario();
    obtenerCursoHorario();

});

function respuestaAjax(data)
{
    console.log(data);
    switch (data.nombre)
    {
        case "obtenerConfiguracionInicial":
            onResponseConfiguracionInicial(data.respuesta);
            break;
        case "obtenerCursoHorario":
            onResponseObtenerCursoHorario(data.respuesta);
            break;

        case "obtenerCursoXCarrera":
            onResponseObtenerCursoXCarrera(data.respuesta);
            break;
        case "agregarCursoHorario":
            if (data.respuesta[0]['vout_resultado'] === 1)
            {
                onResponseAgregarCursoHorario(data.respuesta);
            }
            else
            {
                mensajeAviso(data.respuesta[0]['vout_mensaje']);
            }
            break;
        case "editarCursoHorario":
            if (data.respuesta[0]['vout_resultado'] === 1)
            {
                onResponseEditarCursoHorario(data.respuesta);
            }
            else
            {
                mensajeAviso(data.respuesta[0]['vout_mensaje']);
            }
            break;
        case "eliminarCursoHorario":
            if (data.respuesta[0]['vout_resultado'] === 1)
            {
                mensajeExito(data.respuesta[0]['vout_mensaje']);
                obtenerCursoHorario();
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


function obtenerConfiguracionInicialCursoHorario()
{
    agregarFuncion("obtenerConfiguracionInicial");
    enviarDataAjax();
}

function onResponseConfiguracionInicial(data)
{
    select2.cargar('cboCarrera', data.carreras, 'id', 'nombre');
    select2.asignarValorPredeterminado('cboCarrera');
    select2.cargar('cboHorario', data.horario, 'id', 'nombre');
    select2.asignarValorPredeterminado('cboHorario');
    if (!isEmpty(data.anio_academico[0]['anio']))
    {
        $('#txtAnioAcademico').val(data.anio_academico[0]['anio']);
    }
}

function obtenerCursoHorario()
{
    agregarFuncion("obtenerCursoHorario");
    enviarDataAjax();
}

function onResponseObtenerCursoHorario(data)
{
    if (!isEmpty(data))
    {
        $.each(data, function (index, item) {

            data[index]["opciones"] = '<a onclick="editarCursoHorario(' + item['id'] + ',' + item['carrera_id'] + ',' + item['curso_id'] + ',' + item['horario_id'] + ',\'' + item['anio_academico'] + '\',' + item['estado'] + ')"><b><i class="fa fa-edit" style="color:#E8BA2F;"></i><b></a>\n\
                                   <a onclick="eliminarCursoHorario(' + item['id'] + ')"><b><i class="fa fa-trash-o" style="color:#cb2a2a;"></i><b></a>';

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
            "scrollX": true,
            "order": [[0, "desc"]],
            "data": data,
            "columns": [
                {"data": "carrera_nombre"},
                {"data": "curso_nombre"},
                {"data": "horario"},
                {"data": "anio_academico"},
                {"data": "estado", "sClass": "alignCenter"},
                {"data": "opciones", "sClass": "alignCenter"}
            ],
            "destroy": true
        });
    }
    else
    {
        var table = $('#datatable').dataTable();
        table.clear().draw();
    }
}

function guardarCursoHorario(horario, curso, anioAcademico, estado)
{
    if (!isEmpty(CURSO_HORARIO_ID))
    {
        agregarFuncion("editarCursoHorario");
        agregarParametro("curso_horario_id", CURSO_HORARIO_ID);
    }
    else
    {
        agregarFuncion("agregarCursoHorario");
    }

    agregarParametro("horario", horario);
    agregarParametro("curso", curso);
    agregarParametro("anio_academico", anioAcademico);
    agregarParametro("estado", estado);
    enviarDataAjax();
}

function onResponseAgregarCursoHorario(data)
{
    mensajeExito(data[0]['vout_mensaje']);
    obtenerCursoHorario();
    limpiarFormCursoHorario();
}

function onResponseEditarCursoHorario(data)
{
    mensajeExito(data[0]['vout_mensaje']);
    obtenerCursoHorario();
    limpiarFormCursoHorario();
}

function eliminarCursoHorario(CursoHorarioId)
{
    agregarFuncion("eliminarCursoHorario");
    agregarParametro("curso_horario_id", CursoHorarioId);
    enviarDataAjax();
}

function onChangeCboCarrera()
{
    var carrera = $('#cboCarrera').val();
    if (carrera != '-1')
    {
        agregarFuncion("obtenerCursoXCarrera");
        agregarParametro("carrera", carrera);
        enviarDataAjax();
    }

}

function onResponseObtenerCursoXCarrera(data)
{
    if (!isEmpty(data))
    {
        select2.cargar('cboCurso', data, 'id', 'nombre');
        select2.asignarValorPredeterminado('cboCurso');

        if (!isEmpty(CURSO_ID))
        {
            select2.asignarValor('cboCurso', CURSO_ID);
            CURSO_ID = null;
        }
    }

}

//funciones extras

function agregarCursoHorario()
{

    var carrera = $('#cboCarrera').val();
    var curso = $('#cboCurso').val();
    var horario = $('#cboHorario').val();
    var anioAcademico = $('#txtAnioAcademico').val();
    var estado = $('#cboEstado').val();
    
    if (validarCbo(horario) && validarCbo(carrera) && validarCbo(curso) && validarCadena(anioAcademico, 0) && validarCbo(estado))
    {
        guardarCursoHorario(horario, curso, anioAcademico, estado);

    }
    else
    {
        mensajeAviso("Falta ingresar datos.");
    }
}

function editarCursoHorario(CursoHorarioId,carreraId, cursoId, horarioId, anioAcademico, estado)
{
    CURSO_HORARIO_ID = CursoHorarioId;
    $("#cboCarrera").focus();
    select2.asignarValor('cboHorario', horarioId);
    select2.asignarValor('cboCarrera', carreraId);
    onChangeCboCarrera();
    CURSO_ID = cursoId;
    $('#txtAnioAcademico').val(anioAcademico);
    select2.asignarValor('cboEstado', estado);
}

function limpiarFormCursoHorario()
{
    select2.asignarValor('cboHorario', "-1");
    select2.asignarValor('cboCarrera', "-1");
    select2.asignarValor('cboCurso', "-1");
    select2.asignarValor('cboEstado', "1");
}



