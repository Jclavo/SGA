<?php

require_once __DIR__ . '/../core/controladorBase.php';
require_once __DIR__ . '/IndexControlador.php';
require_once __DIR__ . '/../../modeloNegocio/sga/DocenteCursoNegocio.php';

$DocenteCurso = new DocenteCursoNegocio;
//  nuevo objeto de mi  clase unievrsitarios
$nombreFuncion = obtenerParametro("funcion");

switch ($nombreFuncion) {

    case "obtenerConfiguracionInicial":
        $respuesta = $DocenteCurso->obtenerConfiguracionInicial();
        retornarVista($respuesta);
        break;

    case "obtenerCursoXCarrera":
        $carrera = obtenerParametro("carrera");
        $respuesta = $DocenteCurso->obtenerCursoXCarrera($carrera);
        retornarVista($respuesta);
        break;

    case "obtnerDocenteCurso":
        $respuesta = $DocenteCurso->obtenerDocenteCurso();
        retornarVista($respuesta);
        break;
    
    case "agregarDocenteCurso":
        
        $docente = obtenerParametro("docente");
        $curso = obtenerParametro("curso");
        $carrera = obtenerParametro("carrera");
        $anioAcademico = obtenerParametro("anio_academico");
        $estado = obtenerParametro("estado");
        $usuarioCreacion = obtenerUsuarioSesion();
                
        $respuesta = $DocenteCurso->agregarDocenteCurso($docente,$curso,$carrera,$anioAcademico,$estado,$usuarioCreacion);
        retornarVista($respuesta);
        break;
    
    case "editarDocentecurso":
        $docenteCursoId = obtenerParametro("docente_curso_id");
        $docente = obtenerParametro("docente");
        $curso = obtenerParametro("curso");
        $anioAcademico = obtenerParametro("anio_academico");
        $estado = obtenerParametro("estado");
        
        $respuesta = $DocenteCurso->editarDocentecurso($docenteCursoId,$docente,$curso,$anioAcademico,$estado);
        retornarVista($respuesta);
        break;
    
    case "eliminarDocenteCurso":
        $docenteCursoId = obtenerParametro("docente_curso_id");
        $respuesta = $DocenteCurso->eliminarDocenteCurso($docenteCursoId);
        retornarVista($respuesta);
        break;
    default:
        break;
}


