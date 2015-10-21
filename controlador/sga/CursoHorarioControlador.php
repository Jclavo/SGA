<?php

require_once __DIR__ . '/../core/controladorBase.php';
require_once __DIR__ . '/IndexControlador.php';
require_once __DIR__ . '/../../modeloNegocio/sga/CursoHorarioNegocio.php';

$CursoHorario = new CursoHorarioNegocio;
//  nuevo objeto de mi  clase unievrsitarios
$nombreFuncion = obtenerParametro("funcion");

switch ($nombreFuncion) {

    case "obtenerConfiguracionInicial":
        $respuesta = $CursoHorario->obtenerConfiguracionInicial();
        retornarVista($respuesta);
        break;

    case "obtenerCursoXCarrera":
        $carrera = obtenerParametro("carrera");
        $respuesta = $CursoHorario->obtenerCursoXCarrera($carrera);
        retornarVista($respuesta);
        break;

    case "obtenerCursoHorario":
        $respuesta = $CursoHorario->obtenerCursoHorario();
        retornarVista($respuesta);
        break;
    
    case "agregarCursoHorario":
        
        $horario = obtenerParametro("horario");
        $curso = obtenerParametro("curso");
        $anioAcademico = obtenerParametro("anio_academico");
        $estado = obtenerParametro("estado");
        $usuarioCreacion = obtenerUsuarioSesion();
                
        $respuesta = $CursoHorario->agregarCursoHorario($horario,$curso,$anioAcademico,$estado,$usuarioCreacion);
        retornarVista($respuesta);
        break;
    
    case "editarCursoHorario":
        $CursoHorarioId = obtenerParametro("curso_horario_id");
        $horario = obtenerParametro("horario");
        $curso = obtenerParametro("curso");
        $anioAcademico = obtenerParametro("anio_academico");
        $estado = obtenerParametro("estado");
        
        $respuesta = $CursoHorario->editarCursoHorario($CursoHorarioId,$horario,$curso,$anioAcademico,$estado);
        retornarVista($respuesta);
        break;
    
    case "eliminarCursoHorario":
        $CursoHorarioId = obtenerParametro("curso_horario_id");
        $respuesta = $CursoHorario->eliminarCursoHorario($CursoHorarioId);
        retornarVista($respuesta);
        break;
    default:
        break;
}


