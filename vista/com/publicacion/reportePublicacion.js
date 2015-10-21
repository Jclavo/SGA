
$(document).ready(function () {
    select2.iniciar();

    cargarControlador('Publicacion');

    obtenerPublicacionesActivas(); 
});
      
function respuestaAjax(data)
{
    console.log(data);
    switch (data.nombre)
    {
        case "obtenerPublicacionesActivas":
            onResponseObtenerPublicaciones(data.respuesta);
            break;
        default :
            break;
    }
}


function obtenerPublicacionesActivas()
{
    agregarFuncion("obtenerPublicacionesActivas");
    enviarDataAjax();
}


function onResponseObtenerPublicaciones(data)
{
    var html;
    if (!isEmpty(data))
    {
        $('#contenedorPublicaciones').empty();
        $.each(data, function (index, item) {
            
            html = "";
            html += "<section class='panel'>";
            html += "<div class='panel panel-default'>";
            html += "<div class='panel-heading'>";
            html += "<h3 class='panel-title'>Titulo: "+item.titulo+"</h3>";
            html += "</div>";
            html += "<div class='panel panel-body'>";
            html += "<div class='col-md-12 col-sm-12 col-xs-12'>";
//            html += "<textarea style='width: 100%;heigth:auto;' readonly='true'>"+item.mensaje+"</textarea>";
            html += item.mensaje;
            html += "</div>"; 
            html += "</div>"; 
            html += "</div>"; 
            html += "</section>"; 
            
            $('#contenedorPublicaciones').append(html);
        });
    }
    
}




