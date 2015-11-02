
var matricula = [];
var TOTAL_CREDITOS = 22;
var MEDIA_CREDITOS = 16;

$(document).ready(function () {
    select2.iniciar();

    cargarControlador('Matricula');
    $('#resultado').hide();
    obtenerEstadoMatricula();

});

function respuestaAjax(data)
{
    console.log(data);
    switch (data.nombre)
    {
        case "obtenerEstadoMatricula":
            onResponseObtenerEstadoMatricula(data.respuesta);
            break;
        case "obtenerConfiguracionInicial":
            onResponseConfiguracionInicial(data.respuesta);
            break;
        case "validarCursoAMatricular":
            onResponseValidarCursoAMatricular(data.respuesta);
            break;
        case "matricular":
            onResponseMatricular(data.respuesta);
            break;
        case "obtenerReporteMatricula":
            onResponseObtenerReporteMatricula(data.respuesta);
            break;
        default :
            break;
    }
}

function obtenerEstadoMatricula()
{
    agregarFuncion("obtenerEstadoMatricula");
    enviarDataAjax();
}

function onResponseObtenerEstadoMatricula(data)
{
    if (data[0]['vout_resultado'] === 1)
    {
        obtenerConfiguracionInicialMatricula();
    }
    else
    {
        $('#titulo').empty();
        $('#titulo').html("<h2 style='text-align:center;color:red;'>" + data[0]['vout_mensaje'] + "</h2>");
        $('#resultado').show();

    }
}

function obtenerConfiguracionInicialMatricula()
{
    agregarFuncion("obtenerConfiguracionInicial");
    enviarDataAjax();
}

function onResponseConfiguracionInicial(data)
{
    select2.cargar('cboCurso', data, 'id', 'nombre');
    select2.asignarValorPredeterminado('cboCurso');
}

function validarCursoAMatricular(curso)
{
    agregarFuncion("validarCursoAMatricular");
    agregarParametro("curso_id", curso);
    enviarDataAjax();
}

function onResponseValidarCursoAMatricular(data)
{
    if (data[0]['vout_resultado'] === 1)
    {
        agregarCurso(data);
    }
    else
    {
        mensajeAviso(data[0]['vout_mensaje']);
//        mensajeAviso("Aun no ha aprobado el requisito para matricularse en este curso.");
    }
}

function aceptarMatricula()
{
    var cursosId;
    if (!isEmpty(matricula))
    {
        cursosId = convertirCursoMatriculaACadena();
        agregarFuncion("matricular");
        agregarParametro("cursos_id", cursosId);
        enviarDataAjax();
    }
    else
    {
        mensajeAviso("No ha seleccionado ningun curso");
    }
}

function onResponseMatricular(data)
{
    if (data[0]['vout_resultado'] === 1)
    {
        mensajeExito(data[0]['vout_mensaje']);
    }
    else
    {
        mensajeAviso(data[0]['vout_mensaje']);
    }
}


function obtenerReporteMatricula()
{
    agregarFuncion("obtenerReporteMatricula");
    enviarDataAjax();
}

function onResponseObtenerReporteMatricula(data)
{
//   if (data.resultado[0]['vout_resultado'] === 0)
//    {
//        mensajeExito(data.resultado[0]['vout_mensaje']);
//    }
//    else
//    {
    cargarDataBasica(data.dato_basico_usuario);
    cargarAnioAcademico(data.anio_academico);
    cargarPrecioCarrera(data.precio_carrera);
    cargarTablaReporteCursosMatricula(data.matricula);
    abrirModalMatricula();
//    } 
}
//funciones extras

function cargarPrecioCarrera(data)
{
    $('#precio').html(data[0]['precio']);
}
function cargarDataBasica(data)
{
    $('#codigo').html(data[0]['dni']);
    $('#nombre').html(data[0]['nombre']);
    $('#carrera').html(data[0]['nombre_carrera']);
}

function cargarAnioAcademico(data)
{
    $('#anio_academico').html(data[0]['anio']);
}
function cargarTablaReporteCursosMatricula(data)
{
    $('#datatableReporteMatricula').dataTable({
//            "scrollX": true,
        "order": [[0, "desc"]],
        "data": data,
        "columns": [
            {"data": "curso_nombre"},
            {"data": "creditos"},
            {"data": "ciclo_nombre"}
        ],
        "destroy": true
    });
}

function agregarCursoHorario()
{

    var curso = $('#cboCurso').val();

    if (validarCbo(curso))
    {
        if (validarCursoRepetido(curso))
        {
            validarCursoAMatricular(curso);
        }
        else
        {
            mensajeAviso("Curso ya fue agregado.");
        }
    }
    else
    {
        mensajeAviso("Seleccione un curso.");
    }
}

function validarCursoRepetido(cursoId)
{
    var banderaNoRepetido = true;
    $.each(matricula, function (index, item) {
        if (item.id == cursoId)
        {
            banderaNoRepetido = false;
        }
    });

    return banderaNoRepetido;
}

function agregarCurso(data)
{
//    functionBreak();
    var creditos;
    creditos = contarCreditos();
    creditos = creditos + data[0].creditos;

    if (creditos <= TOTAL_CREDITOS)
    {
        var curso = {id: null,
            curso: null,
            ciclo: null,
            credito: null};

        curso.id = data[0].id;
        curso.curso = data[0].nombre;
        curso.ciclo = data[0].ciclo;
        curso.credito = data[0].creditos;


        matricula.push(curso);
        cargarCursoATabla();
        mensajeExito("Curso agregado");
        select2.asignarValorPredeterminado('cboCurso');
    }
    else
    {
        mensajeAviso("No puede sobrepasar el limite de " + TOTAL_CREDITOS + " creditos.");
    }

}

function contarCreditos()
{
    var creditos = 0;
    if (!isEmpty(matricula))
    {
        $.each(matricula, function (index, item) {
            creditos = creditos + item.credito;
        });
    }

    return creditos;
}

function cargarCursoATabla()
{
    var html;
    if (!isEmpty(matricula))
    {
        $('#cuerpoTabla').empty();
        $.each(matricula, function (index, item) {
            html = "";
            html += "<tr>";
            html += "<th style='text-align:center;'>" + item.curso + "</th>";
            html += "<th style='text-align:center;'>" + item.ciclo + "</th>";
            html += "<th style='text-align:center;'>" + item.credito + "</th>";
            html += "<th style='text-align:center;'><a onclick='eliminarCursoHorario(" + index + ")'><b><i class='fa fa-trash-o' style='color:#cb2a2a;'></i><b></a></th>";
            html += "</tr>";
            $('#cuerpoTabla').append(html);
        });
    }
}

function convertirCursoMatriculaACadena()
{
    var arrayCursosId = [];

    $.each(matricula, function (index, item) {
        arrayCursosId[index] = item.id;
    });

    return arrayCursosId.toString();
}

function eliminarCursoHorario(indice)
{
    matricula.splice(indice, 1);
    cargarCursoATabla();
}


function abrirModalMatricula()
{
    $('#modalVerMatricula').modal('show');
}

function imprimirMatricula()
{
//    var ficha = document.getElementById('parteAImprimir');
//    var ventimp = window.open(' ', 'popimpr');
//    ventimp.document.write(ficha.innerHTML);
//    ventimp.document.close();
//    ventimp.print();
//    ventimp.close();
}
