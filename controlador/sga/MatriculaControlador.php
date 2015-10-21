<?php

require_once __DIR__ . '/../core/controladorBase.php';
require_once __DIR__ . '/IndexControlador.php';
require_once __DIR__ . '/../../modeloNegocio/sga/MatriculaNegocio.php';

$matricula = new MatriculaNegocio;
//  nuevo objeto de mi  clase unievrsitarios
$nombreFuncion = obtenerParametro("funcion");

switch ($nombreFuncion) {

    case "obtenerConfiguracionInicial":
        $usuarioId = obtenerUsuarioSesion();
        $respuesta = $matricula->obtenerConfiguracionInicial($usuarioId);

        retornarVista($respuesta);
        break;
    
    case "validarCursoAMatricular":
        $cursoId = obtenerParametro("curso_id");
        $usuarioId = obtenerUsuarioSesion();
        $respuesta = $matricula->validarCursoPrerequisito($cursoId,$usuarioId);
        retornarVista($respuesta);
        break;
    
    case "matricular":
        $cursosIdCadena = obtenerParametro("cursos_id");
        $usuarioId = obtenerUsuarioSesion();
        $respuesta = $matricula->matricular($cursosIdCadena,$usuarioId);
        retornarVista($respuesta);
        break;
    
    case "obtenerEstadoMatricula":
        $usuarioId = obtenerUsuarioSesion();
        $respuesta = $matricula->obtenerEstadoMatricula($usuarioId);
        retornarVista($respuesta);
        break;
    case "obtenerNotasXUsuario":
        $usuarioId = obtenerUsuarioSesion();
        $respuesta = $matricula->obtenerNotasXUsuario($usuarioId);
        retornarVista($respuesta);
        break;

    default:
        break;
}


