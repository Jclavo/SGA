<?php
require_once __DIR__.'/../core/negocioBase.php';

require_once __DIR__ . '/CarreraNegocio.php';
require_once __DIR__ . '/CicloNegocio.php';

require_once __DIR__ . '/../../modelo/sga/Curso.php';
require_once __DIR__ . '/../../util/util.php';


class CursoNegocio extends negocioBase{
    //put your code here
    
    public function obtenerCursos() {
        $curso = new Curso;
        $respuestaObtenerCursos = $curso->obtenerCursos();
        return $respuestaObtenerCursos;
    }
    
    public function obtenerConfiguracionInicial() {

        $respuesta = new stdClass();

        $carreraNegocio = new CarreraNegocio;
        $respuesta->carreras = $carreraNegocio->obtenerCarreras();
        
        $cicloNegocio = new CicloNegocio;
        $respuesta->ciclos = $cicloNegocio->obtenerCiclos();

        return $respuesta;
    }
    
    public function obtenerCursoXCarrera($carrera) {
        $curso = new Curso;
        $respuestaDatosCurso = $curso->obtenerCursoXCarrera($carrera);
        return $respuestaDatosCurso;
    }


    public function agregarCurso($cursoNombre,$carrera,$prerequisito,$credito,$ciclo,$estado,$usuarioCreacion) {
        $curso = new Curso;
        $respuestaAgregarCurso = $curso->agregarCurso($cursoNombre,$carrera,$prerequisito,$credito,$ciclo,$estado,$usuarioCreacion);
        return $respuestaAgregarCurso;
    }
    
    public function editarCurso($cursoId,$cursoNombre,$carrera,$prerequisito,$credito,$ciclo,$estado) {
        $curso = new Curso;
        $respuestaEditarCurso = $curso->editarCurso($cursoId,$cursoNombre,$carrera,$prerequisito,$credito,$ciclo,$estado);
        return $respuestaEditarCurso;
    }
    
    public function eliminarCurso($cursoId) {
        $curso = new Curso;
        $respuestaEditarCurso = $curso->eliminarCurso($cursoId);
        return $respuestaEditarCurso;
    }
    
    public function obtenerXUsuario($usuarioId) {
        $curso = new Curso;
        $respuestaObtenerXUsuario = $curso->obtenerXUsuario($usuarioId);
        return $respuestaObtenerXUsuario;
    }
    
    public function obtenerCursoXId($cursoId) {
        $curso = new Curso;
        $respuestaObtenerXId = $curso->obtenerCursoXId($cursoId);
        return $respuestaObtenerXId;
    }
    
    public function reporteCursoXDocente($usuarioId){
        $curso = new Curso;
        $respuestaObtenerXId = $curso->reporteCursoXDocente($usuarioId);
        return $respuestaObtenerXId;
    }
    
    public function obtenerCursoXCarreraXDocente($carrera,$usuarioId){
        $curso = new Curso;
        $respuestaObtenerCursoXCarreraXDocente = $curso->obtenerCursoXCarreraXDocente($carrera,$usuarioId);
        return $respuestaObtenerCursoXCarreraXDocente;
    }
    
    
}
