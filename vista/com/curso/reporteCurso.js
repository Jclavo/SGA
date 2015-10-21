
$(document).ready(function () {
    select2.iniciar();

    cargarControlador('Curso');

    reporteCursoXDocente(); 
});
      
function respuestaAjax(data)
{
    console.log(data);
    switch (data.nombre)
    {
        case "reporteCursoXDocente":
            onResponseReporteCursoXDocente(data.respuesta);
            break;
        default :
            break;
    }
}


function reporteCursoXDocente()
{
    agregarFuncion("reporteCursoXDocente");
    enviarDataAjax();
}


function onResponseReporteCursoXDocente(data)
{
    if (!isEmpty(data))
    {
        $('#datatable').dataTable({
            "scrollX": true,
            "order": [[0, "desc"]],
            "data": data,
            "columns": [
                {"data": "curso"},
                {"data": "creditos"},
                {"data": "carrera"},
                {"data": "ciclo"},
                {"data": "turno_horario"},
                {"data": "hora_horario"},
                {"data": "anio_academico"}
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




