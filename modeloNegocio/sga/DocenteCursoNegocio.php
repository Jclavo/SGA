<?php

require_once __DIR__.'/../core/negocioBase.php';

require_once __DIR__ . '/UsuarioNegocio.php';
require_once __DIR__ . '/CarreraNegocio.php';
require_once __DIR__ . '/AnioAcademicoNegocio.php';
require_once __DIR__ . '/CursoNegocio.php';

require_once __DIR__ . '/../../modelo/sga/DocenteCurso.php';
require_once __DIR__ . '/../../util/util.php';


class DocenteCursoNegocio extends negocioBase{
    //put your code here
    public function obtenerConfiguracionInicial() {

        $respuesta = new stdClass();

        $usuarioNegocio = new UsuarioNegocio();
        $respuesta->docentes = $usuarioNegocio->obtenerDocentes();
        
        $carreraNegocio = new CarreraNegocio();
        $respuesta->carreras = $carreraNegocio->obtenerCarreras();

        $anioAcademicoNegocio = new AnioAcademicoNegocio();
        $respuesta->anio_academico = $anioAcademicoNegocio->obtenerAnioAcademicoActual();
        return $respuesta;
    }
    
    public function obtenerCursoXCarrera($carrera) {
        $cursoNegocio = new CursoNegocio();
        $respuestaDatosCurso = $cursoNegocio->obtenerCursoXCarrera($carrera);
        return $respuestaDatosCurso;
    }
    
    public function obtenerDocenteCurso() {
        $docenteCursoNegocio = new DocenteCurso();
        $respuestaObtenerDocenteCurso = $docenteCursoNegocio->obtenerDocenteCurso();
        return $respuestaObtenerDocenteCurso;
    }
    
    public function agregarDocenteCurso($docente,$curso,$carrera,$anioAcademico,$estado,$usuarioCreacion){
        $docenteCursoNegocio = new DocenteCurso();
        $respuestaAgregarDocenteCurso = $docenteCursoNegocio->agregarDocenteCurso($docente,$curso,$carrera,$anioAcademico,$estado,$usuarioCreacion);
        return $respuestaAgregarDocenteCurso;
    }
    
    public function editarDocentecurso($docenteCursoId,$docente,$curso,$anioAcademico,$estado){
        $docenteCursoNegocio = new DocenteCurso();
        $respuestaEditarDocenteCurso = $docenteCursoNegocio->editarDocentecurso($docenteCursoId,$docente,$curso,$anioAcademico,$estado);
        return $respuestaEditarDocenteCurso;
    }
    
    public function eliminarDocenteCurso($docenteCursoId){
        $docenteCursoNegocio = new DocenteCurso();
        $respuestaEliminarDocenteCurso = $docenteCursoNegocio->eliminarDocenteCurso($docenteCursoId);
        return $respuestaEliminarDocenteCurso;
    }
}
