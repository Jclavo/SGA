<?php

require_once __DIR__.'/../core/Conexion.php';

class Curso extends Conexion {
    //put your code here
    public function obtenerCursos() {
        $this->conectar();
        $this->consultaSP("sp_curso_obtener()");
        $query = $this->ejecutarSP();
        $this->desconectar();
        return $query;
    }
    
    public function obtenerCursoXCarrera($carrera) {
        $this->conectar();
        $this->consultaSP("sp_curso_obtenerXcarrera(?)");
        $this->cargarDatosSP($carrera);
        $query = $this->ejecutarSP();
        $this->desconectar();
        return $query;
    }
    
    public function agregarCurso($cursoNombre,$carrera,$prerequisito,$credito,$ciclo,$estado,$usuarioCreacion){
        $this->conectar();
        $this->consultaSP("sp_curso_agregar(?,?,?,?,?,?,?)");
        $this->cargarDatosSP($cursoNombre);
        $this->cargarDatosSP($prerequisito);
        $this->cargarDatosSP($credito);
        $this->cargarDatosSP($carrera);
        $this->cargarDatosSP($ciclo);
        $this->cargarDatosSP($estado);
        $this->cargarDatosSP($usuarioCreacion);
        $query = $this->ejecutarSP();
        $this->desconectar();
        return $query;
    }
    
    public function editarCurso($cursoId,$cursoNombre,$carrera,$prerequisito,$credito,$ciclo,$estado){
        $this->conectar();
        $this->consultaSP("sp_curso_editar(?,?,?,?,?,?,?)");
        $this->cargarDatosSP($cursoId);
        $this->cargarDatosSP($cursoNombre);
        $this->cargarDatosSP($prerequisito);
        $this->cargarDatosSP($credito);
        $this->cargarDatosSP($carrera);
        $this->cargarDatosSP($ciclo);
        $this->cargarDatosSP($estado);
        $query = $this->ejecutarSP();
        $this->desconectar();
        return $query;
    }
    
    public function eliminarCurso($cursoId){
        $this->conectar();
        $this->consultaSP("sp_curso_eliminar(?)");
        $this->cargarDatosSP($cursoId);
        $query = $this->ejecutarSP();
        $this->desconectar();
        return $query;
    }
    
    public function obtenerXUsuario($usuarioId){
        $this->conectar();
        $this->consultaSP("sp_curso_obtenerXUsuario(?)");
        $this->cargarDatosSP($usuarioId);
        $query = $this->ejecutarSP();
        $this->desconectar();
        return $query;
    }
    
    public function obtenerCursoXId($cursoId) {
        $this->conectar();
        $this->consultaSP("sp_curso_obteneXId(?)");
        $this->cargarDatosSP($cursoId);
        $query = $this->ejecutarSP();
        $this->desconectar();
        return $query;
    }
    
    public function reporteCursoXDocente($usuarioId) {
        $this->conectar();
        $this->consultaSP("sp_curso_reporteXDocente(?)");
        $this->cargarDatosSP($usuarioId);
        $query = $this->ejecutarSP();
        $this->desconectar();
        return $query;
    }
    
    public function obtenerCursoXCarreraXDocente($carrera,$usuarioId) {
        $this->conectar();
        $this->consultaSP("sp_curso_obtenerXCarreraXDocente(?,?)");
        $this->cargarDatosSP($carrera);
        $this->cargarDatosSP($usuarioId);
        $query = $this->ejecutarSP();
        $this->desconectar();
        return $query;
    }
}
