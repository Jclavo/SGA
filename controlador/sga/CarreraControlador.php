<?php

require_once __DIR__ . '/../core/controladorBase.php';
require_once __DIR__ . '/IndexControlador.php';
require_once __DIR__ . '/../../modeloNegocio/sga/CarreraNegocio.php';

$carrera = new CarreraNegocio;
//  nuevo objeto de mi  clase unievrsitarios
$nombreFuncion = obtenerParametro("funcion");

switch ($nombreFuncion) {
    case "obtenerCarreras":
        $respuesta = $carrera->obtenerCarreras();
        retornarVista($respuesta);
        break;
    case "agregarCarrera":
        $carreraNombre = obtenerParametro("carrera");
        $precio = obtenerParametro("precio");
        $estado = obtenerParametro("estado");
        $usuarioCreacion = obtenerUsuarioSesion();
        
        $respuesta = $carrera->agregarCarrera($carreraNombre,$precio,$estado,$usuarioCreacion);
        retornarVista($respuesta);
        break;
    
    case "editarCarrera":
        $carreraId = obtenerParametro("carrera_id");
        $carreraNombre = obtenerParametro("carrera");
        $precio = obtenerParametro("precio");
        $estado = obtenerParametro("estado");
        
        $respuesta = $carrera->editarCarrera($carreraId,$carreraNombre,$precio,$estado);
        retornarVista($respuesta);
        break;
    case "eliminarCarrera":
        $carreraId = obtenerParametro("carrera_id");
        $respuesta = $carrera->eliminarCarrera($carreraId);
        retornarVista($respuesta);
        break;
    default:
        break;
}

