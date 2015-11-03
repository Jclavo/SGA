<?php

require_once __DIR__ . '/../core/controladorBase.php';
require_once __DIR__ . '/IndexControlador.php';
require_once __DIR__ . '/../../modeloNegocio/sga/NotaNegocio.php';

$nota = new NotaNegocio;
//  nuevo objeto de mi  clase unievrsitarios
$nombreFuncion = obtenerParametro("funcion");

switch ($nombreFuncion) {
    
    case "obtenerCarreraXDocente":
        $usuarioId = obtenerUsuarioSesion();
        $respuesta = $nota->obtenerCarreraXDocente($usuarioId);
        retornarVista($respuesta);
        break;
    case "obtenerCursoXCarreraXDocente":
        $carrera = obtenerParametro("carrera");
        $usuarioId = obtenerUsuarioSesion();
        $respuesta = $nota->obtenerCursoXCarreraXDocente($carrera,$usuarioId);
        retornarVista($respuesta);
        break;
    case "obtenerAlumnosXCurso":
        $cursoId = obtenerParametro("curso");
        $respuesta = $nota->obtenerAlumnosXCurso($cursoId);
        retornarVista($respuesta);
        break;
    case "guardarNota":
        $cadenaId = obtenerParametro("array_id");
        $cadenaNota1 = obtenerParametro("array_nota_1");
        $cadenaNota2 = obtenerParametro("array_nota_2");
        $cadenaNota3 = obtenerParametro("array_nota_3");
        $respuesta = $nota->guardarNota($cadenaId,$cadenaNota1,$cadenaNota2,$cadenaNota3);
        retornarVista($respuesta);
        break;
    case "obtenerPromedio":     
        $cadenaId = obtenerParametro("array_id");
        $respuesta = $nota->obtenerPromedio($cadenaId);
        retornarVista($respuesta);
        break;
    default:
        break;
}


