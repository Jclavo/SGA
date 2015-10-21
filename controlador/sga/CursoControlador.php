<?php

require_once __DIR__ . '/../core/controladorBase.php';
require_once __DIR__ . '/IndexControlador.php';
require_once __DIR__ . '/../../modeloNegocio/sga/CursoNegocio.php';

$curso = new CursoNegocio;
//  nuevo objeto de mi  clase unievrsitarios
$nombreFuncion = obtenerParametro("funcion");

switch ($nombreFuncion) {
    
    case "obtenerCursos":
        $respuesta = $curso->obtenerCursos();
        retornarVista($respuesta);
        break;
    
    case "obtenerCursoXCarrera":
        $carrera = obtenerParametro("carrera");
        $respuesta = $curso->obtenerCursoXCarrera($carrera);
        retornarVista($respuesta);
        break;
    
    case "obtenerConfiguracionInicial":
        $respuesta = $curso->obtenerConfiguracionInicial();
        retornarVista($respuesta);
        break;
    
    case "agregarCurso":
        
        $cursoNombre = obtenerParametro("curso");
        $carrera = obtenerParametro("carrera");
        $prerequisito = obtenerParametro("prerequisito");
        $credito = obtenerParametro("credito");
        $ciclo = obtenerParametro("ciclo");
        $estado = obtenerParametro("estado");
        $usuarioCreacion = obtenerUsuarioSesion();
        
        $respuesta = $curso->agregarCurso($cursoNombre,$carrera,$prerequisito,$credito,$ciclo,$estado,$usuarioCreacion);
        retornarVista($respuesta);
        break;
    
    case "editarCurso":
        $cursoId = obtenerParametro("curso_id");
        $cursoNombre = obtenerParametro("curso");
        $carrera = obtenerParametro("carrera");
        $prerequisito = obtenerParametro("prerequisito");
        $credito = obtenerParametro("credito");
        $ciclo = obtenerParametro("ciclo");
        $estado = obtenerParametro("estado");
        
        $respuesta = $curso->editarCurso($cursoId,$cursoNombre,$carrera,$prerequisito,$credito,$ciclo,$estado);
        retornarVista($respuesta);
        break;
    case "eliminarCurso":
        $cursoId = obtenerParametro("curso_id");
        $respuesta = $curso->eliminarCurso($cursoId);
        retornarVista($respuesta);
        break;
    case "reporteCursoXDocente":
        $usuarioId = obtenerUsuarioSesion();
        $respuesta = $curso->reporteCursoXDocente($usuarioId);
        retornarVista($respuesta);
        break;
    default:
        break;
}


