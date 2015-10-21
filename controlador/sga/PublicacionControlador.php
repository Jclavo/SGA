<?php

require_once __DIR__ . '/../core/controladorBase.php';
require_once __DIR__ . '/IndexControlador.php';
require_once __DIR__ . '/../../modeloNegocio/sga/PublicacionNegocio.php';

$publicacion = new PublicacionNegocio;
//  nuevo objeto de mi  clase unievrsitarios
$nombreFuncion = obtenerParametro("funcion");

switch ($nombreFuncion) {
    case "obtenerPublicaciones":
        $respuesta = $publicacion->obtenerPublicaciones();
        retornarVista($respuesta);
        break;
    case "agregarPublicacion":
        $titulo = obtenerParametro("titulo");
        $mensaje = obtenerParametro("mensaje");
        $estado = obtenerParametro("estado");
        $usuarioCreacion = obtenerUsuarioSesion();
        $respuesta = $publicacion->agregarPublicacion($titulo,$mensaje,$estado,$usuarioCreacion);
        retornarVista($respuesta);
        break;
    case "obtenerPublicacionXId":
        $publicacionId = obtenerParametro("publicacion_id");
        $respuesta = $publicacion->obtenerPublicacionXId($publicacionId);
        retornarVista($respuesta);
        break;
    
    case "editarPublicacion":
        $publicacionId = obtenerParametro("publicacion_id");
        $titulo = obtenerParametro("titulo");
        $mensaje = obtenerParametro("mensaje");
        $publicacionNombre = obtenerParametro("publicacion");
        $estado = obtenerParametro("estado");
        
        $respuesta = $publicacion->editarPublicacion($publicacionId,$titulo,$mensaje,$estado);
        retornarVista($respuesta);
        break;
    case "eliminarPublicacion":
        $publicacionId = obtenerParametro("publicacion_id");
        $respuesta = $publicacion->eliminarPublicacion($publicacionId);
        retornarVista($respuesta);
        break;
    case "obtenerPublicacionesActivas":
        $respuesta = $publicacion->obtenerPublicacionesActivas();
        retornarVista($respuesta);
        break;
    default:
        break;
}

