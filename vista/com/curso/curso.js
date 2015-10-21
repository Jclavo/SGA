
var CURSO_ID = null;

$(document).ready(function () {
    select2.iniciar();

    cargarControlador('Curso');

    obtenerConfiguracionInicialCurso();
    obtenerCursos();
    
});
      
function respuestaAjax(data)
{
    console.log(data);
    switch (data.nombre)
    {
        case "obtenerConfiguracionInicial":
            onResponseConfiguracionInicial(data.respuesta);
            break;
        case "obtenerCursos":
            onResponseObtenerCursos(data.respuesta);
            break;
            
        case "obtenerCursoXCarrera":
            obtenerCursoXCarrera(data.respuesta);
            break;
        case "agregarCurso":
            if (data.respuesta[0]['vout_resultado'] === 1)
            {
                onResponseAgregarCurso(data.respuesta);
            }
            else
            {
                mensajeAviso(data.respuesta[0]['vout_mensaje']);
            }
            break;
        case "editarCurso":
            if (data.respuesta[0]['vout_resultado'] === 1)
            {
                onResponseEditarCurso(data.respuesta);
            }
            else
            {
                mensajeAviso(data.respuesta[0]['vout_mensaje']);
            }
            break;
        case "eliminarCurso":
            if (data.respuesta[0]['vout_resultado'] === 1)
            {
                mensajeExito(data.respuesta[0]['vout_mensaje']);
                obtenerCursos();
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


function obtenerConfiguracionInicialCurso()
{
    agregarFuncion("obtenerConfiguracionInicial");
    enviarDataAjax();
}

function onResponseConfiguracionInicial(data)
{
    select2.cargar('cboCarrera', data.carreras, 'id', 'nombre');
    select2.cargar('cboCiclo', data.ciclos, 'id', 'nombre');
}

function obtenerCursos()
{
    agregarFuncion("obtenerCursos");
    enviarDataAjax();
}

function onResponseObtenerCursos(data)
{
    if (data !== "-1")
    {
        $.each(data, function (index, item) {

            data[index]["opciones"] = '<a onclick="editarCurso(' + item['id'] + ',\'' + item['nombre_curso'] + '\',' + item['pre_requisito'] + ',' + item['creditos'] + ',' + item['carrera_id'] + ',' + item['ciclo_id'] + ',' + item['estado'] + ')"><b><i class="fa fa-edit" style="color:#E8BA2F;"></i><b></a>\n\
                                   <a onclick="eliminarCurso(' + item['id'] + ')"><b><i class="fa fa-trash-o" style="color:#cb2a2a;"></i><b></a>';

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
                {"data": "nombre_curso"},
                {"data": "pre_requisito_nombre"},
                {"data": "creditos"},
                {"data": "carrera_nombre"},
                {"data": "ciclo_nombre"},
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

function guardarCurso(curso, carrera, prerequisito, credito, ciclo, estado)
{
    if (!isEmpty(CURSO_ID))
    {
        agregarFuncion("editarCurso");
        agregarParametro("curso_id", CURSO_ID);
    }
    else
    {
        agregarFuncion("agregarCurso");
    }

    agregarParametro("curso", curso);
    agregarParametro("carrera", carrera);
    agregarParametro("prerequisito", prerequisito);
    agregarParametro("credito", credito);
    agregarParametro("ciclo", ciclo);
    agregarParametro("estado", estado);
    enviarDataAjax();
}

function onResponseAgregarCurso(data)
{
    mensajeExito(data[0]['vout_mensaje']);
    obtenerCursos();
    limpiarFormCurso();
}

function onResponseEditarCurso(data)
{
    mensajeExito(data[0]['vout_mensaje']);
    obtenerCursos();
    limpiarFormCurso();
}

function eliminarCurso(cursoId)
{
    agregarFuncion("eliminarCurso");
    agregarParametro("curso_id", cursoId);
    enviarDataAjax();
}

function onChangeCboCarrera()
{
    var carrera = $('#cboCarrera').val();
    agregarFuncion("obtenerCursoXCarrera");
    agregarParametro("carrera", carrera);
    enviarDataAjax();
}

function obtenerCursoXCarrera(data)
{
    $('#cboPrerequisito').empty();
    select2.cargar('cboPrerequisito', data, 'id', 'nombre');
}

//funciones extras

function agregarCurso()
{
    var curso = $('#txtNombre').val();
    var carrera = $('#cboCarrera').val();
    var prerequisito = $('#cboPrerequisito').val();
    var credito = $('#txtCredito').val();
    var ciclo = $('#cboCiclo').val();
    var estado = $('#cboEstado').val();

    if (validarCadena(curso, 50) && validarNumero(carrera, 0) &&
            validarNumero(credito, 0) && validarNumero(ciclo, 0) &&
            validarNumero(estado, 1))
    {

        if (credito > 0 && credito <= 20)
        {
            guardarCurso(curso, carrera, prerequisito, credito, ciclo, estado);

        }
        else
        {
            mensajeAviso("Los creditos deben de estar dentro del rango 1 - 20");
        }
    }
    else
    {
        mensajeAviso("Falta ingresar datos.");
    }
}

function editarCurso(cursoId, cursoNombre,prerequisito,creditos,carreraId,cicloId,estado)
{
    CURSO_ID = cursoId;
    
    $('#txtNombre').val(cursoNombre);
    $('#txtCredito').val(creditos);
    
    if(prerequisito!==null)
    {
        select2.asignarValor('cboPrerequisito',prerequisito);
    }
    
    select2.asignarValor('cboCarrera', carreraId);
    select2.asignarValor('cboCiclo', cicloId);
    select2.asignarValor('cboEstado', estado);
    
    $('#txtNombre').focus();
}

function limpiarFormCurso()
{
//    $("#formCurso").reset();
    document.getElementById("formCurso").reset();
//    $('#txtNombre').val("");
//    $('#txtCredito').val("");
//
////    select2.asignarValor('cboCarrera',"0");
////    select2.asignarValor('cboPrerequisito',"0");
    select2.asignarValor('cboCiclo',"1");
    select2.asignarValor('cboEstado', "1");
}



