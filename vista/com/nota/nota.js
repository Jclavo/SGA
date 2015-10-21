
$(document).ready(function () {
    select2.iniciar();

    cargarControlador('Matricula');

    obtenerNotasXUsuario(); 
});
      
function respuestaAjax(data)
{
    console.log(data);
    switch (data.nombre)
    {
        case "obtenerNotasXUsuario":
            onResponseObtenerNotasXUsuario(data.respuesta);
            break;
        default :
            break;
    }
}


function obtenerNotasXUsuario()
{
    agregarFuncion("obtenerNotasXUsuario");
    enviarDataAjax();
}


function onResponseObtenerNotasXUsuario(data)
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
                {"data": "ciclo"},
                {"data": "promedio"}
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




