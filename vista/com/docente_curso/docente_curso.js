
var DOCENTE_CURSO_ID = null;
var CURSO_ID = null;

$(document).ready(function () {
    select2.iniciar();

    cargarControlador('DocenteCurso');

    obtenerConfiguracionInicialDocenteCurso();
    obtnerDocenteCurso();

});

function respuestaAjax(data)
{
    console.log(data);
    switch (data.nombre)
    {
        case "obtenerConfiguracionInicial":
            onResponseConfiguracionInicial(data.respuesta);
            break;
        case "obtnerDocenteCurso":
            onResponseObtenerDocenteCurso(data.respuesta);
            break;

        case "obtenerCursoXCarrera":
            onResponseObtenerCursoXCarrera(data.respuesta);
            break;
        case "agregarDocenteCurso":
            if (data.respuesta[0]['vout_resultado'] === 1)
            {
                onResponseAgregarDocenteCurso(data.respuesta);
            }
            else
            {
                mensajeAviso(data.respuesta[0]['vout_mensaje']);
            }
            break;
        case "editarDocentecurso":
            if (data.respuesta[0]['vout_resultado'] === 1)
            {
                onResponseEditarDocenteCurso(data.respuesta);
            }
            else
            {
                mensajeAviso(data.respuesta[0]['vout_mensaje']);
            }
            break;
        case "eliminarDocenteCurso":
            if (data.respuesta[0]['vout_resultado'] === 1)
            {
                mensajeExito(data.respuesta[0]['vout_mensaje']);
                obtnerDocenteCurso();
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


function obtenerConfiguracionInicialDocenteCurso()
{
    agregarFuncion("obtenerConfiguracionInicial");
    enviarDataAjax();
}

function onResponseConfiguracionInicial(data)
{
    select2.cargar('cboDocente', data.docentes, 'id', 'nombre_usuario');
    select2.asignarValorPredeterminado('cboDocente');
    select2.cargar('cboCarrera', data.carreras, 'id', 'nombre');
    select2.asignarValorPredeterminado('cboCarrera');

    if (!isEmpty(data.anio_academico[0]['anio']))
    {
        $('#txtAnioAcademico').val(data.anio_academico[0]['anio']);
    }
}

function obtnerDocenteCurso()
{
    agregarFuncion("obtnerDocenteCurso");
    enviarDataAjax();
}

function onResponseObtenerDocenteCurso(data)
{
    if (!isEmpty(data))
    {
        $.each(data, function (index, item) {

            data[index]["opciones"] = '<a onclick="editarDocentecurso(' + item['id'] + ',' + item['usuario_id'] + ',' + item['carrera_id'] + ',' + item['curso_id'] + ',\'' + item['anio_academico'] + '\',' + item['usuario_curso_estado'] + ')"><b><i class="fa fa-edit" style="color:#E8BA2F;"></i><b></a>\n\
                                   <a onclick="eliminarDocenteCurso(' + item['id'] + ')"><b><i class="fa fa-trash-o" style="color:#cb2a2a;"></i><b></a>';

            if (data[index]["usuario_curso_estado"] === 1)
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
                {"data": "usuario_nombre"},
                {"data": "carrera_nombre"},
                {"data": "curso_nombre"},
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

function guardarDocenteCurso(docente, carrera, curso, anioAcademico, estado)
{
    if (!isEmpty(DOCENTE_CURSO_ID))
    {
        agregarFuncion("editarDocentecurso");
        agregarParametro("docente_curso_id", DOCENTE_CURSO_ID);
    }
    else
    {
        agregarFuncion("agregarDocenteCurso");
    }

    agregarParametro("docente", docente);
    agregarParametro("curso", curso);
    agregarParametro("carrera", carrera);
    agregarParametro("anio_academico", anioAcademico);
    agregarParametro("estado", estado);
    enviarDataAjax();
}

function onResponseAgregarDocenteCurso(data)
{
    mensajeExito(data[0]['vout_mensaje']);
    obtnerDocenteCurso();
    limpiarFormDocenteCurso();
}

function onResponseEditarDocenteCurso(data)
{
    mensajeExito(data[0]['vout_mensaje']);
    obtnerDocenteCurso();
    limpiarFormDocenteCurso();
}

function eliminarDocenteCurso(DocenteCursoId)
{
    agregarFuncion("eliminarDocenteCurso");
    agregarParametro("docente_curso_id", DocenteCursoId);
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
        
        if(!isEmpty(CURSO_ID))
        {
            select2.asignarValor('cboCurso',CURSO_ID);
            CURSO_ID = null;
        }
    }

}

//funciones extras

function agregarDocenteCurso()
{
    var docente = $('#cboDocente').val();
    var carrera = $('#cboCarrera').val();
    var curso = $('#cboCurso').val();
    var anioAcademico = $('#txtAnioAcademico').val();
    var estado = $('#cboEstado').val();

    if (validarCbo(docente) && validarCbo(carrera) && validarCbo(curso) && validarCadena(anioAcademico,0) && validarCbo(estado))
    {
        guardarDocenteCurso(docente, carrera, curso, anioAcademico, estado);

    }
    else
    {
        mensajeAviso("Falta ingresar datos.");
    }
}

function editarDocentecurso(docenteCursoId,usuarioId,carreraId,cursoId,anioAcademico, estado)
{

    DOCENTE_CURSO_ID = docenteCursoId;
    $("#cboDocente").focus();
    select2.asignarValor('cboDocente', usuarioId);
    select2.asignarValor('cboCarrera', carreraId);
    onChangeCboCarrera();
    CURSO_ID = cursoId;
    $('#txtAnioAcademico').val(anioAcademico);
    select2.asignarValor('cboEstado', estado);
}

function limpiarFormDocenteCurso()
{
    select2.asignarValor('cboDocente', "-1");
    select2.asignarValor('cboCarrera', "-1");
    select2.asignarValor('cboCurso', "-1");
    select2.asignarValor('cboEstado', "1");
}



