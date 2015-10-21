<?php

require_once __DIR__.'/../core/negocioBase.php';

require_once __DIR__ . '/AnioAcademicoNegocio.php';
require_once __DIR__ . '/CarreraNegocio.php';
require_once __DIR__ . '/HorarioNegocio.php';
require_once __DIR__ . '/CursoNegocio.php';

require_once __DIR__ . '/../../modelo/sga/CursoHorario.php';
require_once __DIR__ . '/../../util/util.php';


class CursoHorarioNegocio extends negocioBase{
    //put your code here
    public function obtenerConfiguracionInicial() {

        $respuesta = new stdClass();

        $carreraNegocio = new CarreraNegocio();
        $respuesta->carreras = $carreraNegocio->obtenerCarreras();

        $horarioNegocio = new HorarioNegocio();
        $respuesta->horario = $horarioNegocio->obtener();
        
        $anioAcademicoNegocio = new AnioAcademicoNegocio();
        $respuesta->anio_academico = $anioAcademicoNegocio->obtenerAnioAcademicoActual();
        return $respuesta;
    }
    
    public function obtenerCursoXCarrera($carrera) {
        $cursoNegocio = new CursoNegocio();
        $respuestaDatosCurso = $cursoNegocio->obtenerCursoXCarrera($carrera);
        return $respuestaDatosCurso;
    }
    
    public function obtenerCursoHorario() {
        $CursoHorarioNegocio = new CursoHorario();
        $respuestaObtenerCursoHorario = $CursoHorarioNegocio->obtenerCursoHorario();
        return $respuestaObtenerCursoHorario;
    }
    
    public function agregarCursoHorario($horario,$curso,$anioAcademico,$estado,$usuarioCreacion){
        $CursoHorarioNegocio = new CursoHorario();
        $respuestaAgregarCursoHorario = $CursoHorarioNegocio->agregarCursoHorario($horario,$curso,$anioAcademico,$estado,$usuarioCreacion);
        return $respuestaAgregarCursoHorario;
    }
    
    public function editarCursoHorario($CursoHorarioId,$horario,$curso,$anioAcademico,$estado){
        $CursoHorarioNegocio = new CursoHorario();
        $respuestaEditarCursoHorario = $CursoHorarioNegocio->editarCursoHorario($CursoHorarioId,$horario,$curso,$anioAcademico,$estado);
        return $respuestaEditarCursoHorario;
    }
    
    public function eliminarCursoHorario($CursoHorarioId){
        $CursoHorarioNegocio = new CursoHorario();
        $respuestaEliminarCursoHorario = $CursoHorarioNegocio->eliminarCursoHorario($CursoHorarioId);
        return $respuestaEliminarCursoHorario;
    }
}
