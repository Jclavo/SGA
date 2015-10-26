<?php

require_once __DIR__ . '/../core/Conexion.php';

class Matricula extends Conexion {

//    //put your code here
//    public function obtenerCursoXCarrera($carrera) {
//        $this->conectar();
//        $this->consultaSP("sp_curso_obtenerXcarrera(?)");
//        $this->cargarDatosSP($carrera);
//        $query = $this->ejecutarSP();
//        $this->desconectar();
//        return $query;
//    }
//    
    public function validarCursoPrerequisito($cursoId, $usuarioId) {
        $this->conectar();
        $this->consultaSP("sp_curso_validarPrerequisito(?,?)");
        $this->cargarDatosSP($cursoId);
        $this->cargarDatosSP($usuarioId);
        $query = $this->ejecutarSP();
        $this->desconectar();
        return $query;
    }
    
    public function matricular($usuarioId,$anioAcademicoId){
        $this->conectar();
        $this->consultaSP("sp_matricula_matricular(?,?)");
        $this->cargarDatosSP($usuarioId);
        $this->cargarDatosSP($anioAcademicoId);
        $query = $this->ejecutarSP();
        $this->desconectar();
        return $query;
    }
    
    public function guardarMatriculaCurso($matriculaId,$cursoId){
        $this->conectar();
        $this->consultaSP("sp_matricula_cursoGuardar(?,?)");
        $this->cargarDatosSP($matriculaId);
        $this->cargarDatosSP($cursoId);
        $query = $this->ejecutarSP();
        $this->desconectar();
//        return $query;
    }
    
    public function existeXUsuario($usuarioId,$anioAcademicoId){
        $this->conectar();
        $this->consultaSP("sp_matricula_existeXUsuario(?,?)");
        $this->cargarDatosSP($usuarioId);
        $this->cargarDatosSP($anioAcademicoId);
        $query = $this->ejecutarSP();
        $this->desconectar();
        return $query;
    }

    public function obtenerXUsuario($usuarioId){
        $this->conectar();
        $this->consultaSP("sp_matricula_curso_obtenerNotas(?)");
        $this->cargarDatosSP($usuarioId);
        $query = $this->ejecutarSP();
        $this->desconectar();
        return $query;
    }
    
    public function obtenerAlumnosXCurso($cursoId){
        $this->conectar();
        $this->consultaSP("sp_matricula_curso_obtenerNotasXCurso(?)");
        $this->cargarDatosSP($cursoId);
        $query = $this->ejecutarSP();
        $this->desconectar();
        return $query;
    }
    
    public function guardarNota($id, $nota, $indice){
        $this->conectar();
        $this->consultaSP("sp_matricula_curso_guardarNota(?,?,?)");
        $this->cargarDatosSP($id);
        $this->cargarDatosSP($nota);
        $this->cargarDatosSP($indice);
        $query = $this->ejecutarSP();
        $this->desconectar();
        return $query;
    }
    
    public function obtenerPromedio($id){
        $this->conectar();
        $this->consultaSP("sp_matricula_curso_obtenerPromedio(?)");
        $this->cargarDatosSP($id);
        $query = $this->ejecutarSP();
        $this->desconectar();
        return $query;
    }
    
    public function obtenerReporteMatricula($usuarioId, $anioAcademicoId){
        $this->conectar();
        $this->consultaSP("sp_matricula_obtener(?,?)");
        $this->cargarDatosSP($usuarioId);
        $this->cargarDatosSP($anioAcademicoId);
        $query = $this->ejecutarSP();
        $this->desconectar();
        return $query;
    }
}
