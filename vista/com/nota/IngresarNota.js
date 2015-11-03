
var arrayIdAlumno = [];
var nota1 = [];
var nota2 = [];
var nota3 = [];

$(document).ready(function () {
    select2.iniciar();
    cargarControlador('Nota');
    obtenerCarreraXDocente();
});

function respuestaAjax(data)
{
    console.log(data);
    switch (data.nombre)
    {
        case "obtenerCarreraXDocente":
            onResponseObtenerCarreraXDocente(data.respuesta);
            break;
        case "obtenerCursoXCarreraXDocente":
            onResponseObtenerCursoXCarreraXDocente(data.respuesta);
            break;
        case "obtenerAlumnosXCurso":
            onResponseObtenerAlumnosXCurso(data.respuesta);
            break;
        case "guardarNota":
            if (data.respuesta[0]['vout_resultado'] === 1)
            {
                mensajeExito(data.respuesta[0]['vout_mensaje']);
            }
            else
            {
                mensajeError("Se produjo un error");
            }
            break;
        case "obtenerPromedio":
            if (data.respuesta[0]['vout_resultado'] === 1)
            {
                mensajeExito(data.respuesta[0]['vout_mensaje']);
            }
            else
            {
                mensajeError("Se produjo un error");
            }
            onChangeCboCurso();
            break;
        default :
            break;
    }
}


function obtenerCarreraXDocente()
{
    agregarFuncion("obtenerCarreraXDocente");
    enviarDataAjax();
}

function onResponseObtenerCarreraXDocente(data)
{
    select2.cargar('cboCarrera', data, 'id', 'nombre');
    select2.asignarValorPredeterminado('cboCarrera');
}

function onChangeCboCarrera()
{
    var carrera = $('#cboCarrera').val();
    if (carrera != '-1')
    {
        agregarFuncion("obtenerCursoXCarreraXDocente");
        agregarParametro("carrera", carrera);
        enviarDataAjax();
    }
}

function onResponseObtenerCursoXCarreraXDocente(data)
{
    select2.cargar('cboCurso', data, 'id', 'nombre');
    select2.asignarValorPredeterminado('cboCurso');
}

function onChangeCboCurso()
{
    var curso = $('#cboCurso').val();
    if (curso != '-1')
    {
        agregarFuncion("obtenerAlumnosXCurso");
        agregarParametro("curso", curso);
        enviarDataAjax();
    }
}

function onResponseObtenerAlumnosXCurso(data)
{
    var html;
    var nota1;
    var nota2;
    var nota3;
    var promedio;
    arrayIdAlumno = [];
    $('#cuerpoTabla').empty();
    if (!isEmpty(data))
    {
        $.each(data, function (index, item) {

            arrayIdAlumno.push(item.id);
            (isEmpty(item.nota_1)) ? nota1 = 0 : nota1 = item.nota_1;
            (isEmpty(item.nota_2)) ? nota2 = 0 : nota2 = item.nota_2;
            (isEmpty(item.nota_3)) ? nota3 = 0 : nota3 = item.nota_3;
            (isEmpty(item.promedio)) ? promedio = "" : promedio = item.promedio;

            html = "";
            html += "<tr>";
            html += "<th style='text-align:center;'> " + item.nombre + "</th>";
            html += "<th style='text-align:center;'> <input type='text' id='txt" + item.id + "_1' value='" + nota1 + "'></th>";
            html += "<th style='text-align:center;'> <input type='text' id='txt" + item.id + "_2' value='" + nota2 + "'></th>";
            html += "<th style='text-align:center;'> <input type='text' id='txt" + item.id + "_3' value='" + nota3 + "'></th>";
            html += "<th style='text-align:center;'> " + promedio + "</th>";
            html += "</tr>";
            $('#cuerpoTabla').append(html);
        });
    }
}

function obtenerNotas()
{
    nota1 = [];
    nota2 = [];
    nota3 = [];
    if (!isEmpty(arrayIdAlumno))
    {
        $.each(arrayIdAlumno, function (index, item) {

            nota1.push(obtenerTextNota(item, 1));
            nota2.push(obtenerTextNota(item, 2));
            nota3.push(obtenerTextNota(item, 3));
        });
    }
}

function obtenerTextNota(id, indice)
{
    var valor = $('#txt' + id + '_' + indice).val();

    if (isEmpty(valor))
    {
        return 0;
    }
    else
    {
        if (isNaN(valor))
        {
            return 0;
        }
        if (valor >= 0 && valor <= 20)
        {
            return valor;
        }
        else
        {
            return 0;
        }
    }
}

function guardarNotas()
{
    obtenerNotas();
    agregarFuncion("guardarNota");
    agregarParametro("array_id", arrayIdAlumno.toString());
    agregarParametro("array_nota_1", nota1.toString());
    agregarParametro("array_nota_2", nota2.toString());
    agregarParametro("array_nota_3", nota3.toString());
    enviarDataAjax();
}

function obtenerPromedio()
{
    agregarFuncion("obtenerPromedio");
    agregarParametro("array_id", arrayIdAlumno.toString());
    enviarDataAjax();
}



