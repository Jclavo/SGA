<?php

require_once __DIR__ . '/../core/Conexion.php';

class DocenteCurso extends Conexion {

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
    public function obtenerDocenteCurso() {
        $this->conectar();
        $this->consultaSP("sp_usuario_curso_obtener()");
        $query = $this->ejecutarSP();
        $this->desconectar();
        return $query;
    }

    public function agregarDocenteCurso($docente, $curso, $carrera, $anioAcademico, $estado, $usuarioCreacion) {
        $this->conectar();
        $this->consultaSP("sp_usuario_curso_agregar(?,?,?,?,?)");
        $this->cargarDatosSP($docente);
        $this->cargarDatosSP($curso);
        $this->cargarDatosSP($anioAcademico);
        $this->cargarDatosSP($estado);
        $this->cargarDatosSP($usuarioCreacion);
        $query = $this->ejecutarSP();
        $this->desconectar();
        return $query;
    }

    public function editarDocentecurso($docenteCursoId, $docente, $curso, $anioAcademico, $estado) {
        $this->conectar();
        $this->consultaSP("sp_usuario_curso_editar(?,?,?,?,?)");
        $this->cargarDatosSP($docenteCursoId);
        $this->cargarDatosSP($docente);
        $this->cargarDatosSP($curso);
        $this->cargarDatosSP($anioAcademico);
        $this->cargarDatosSP($estado);
        $query = $this->ejecutarSP();
        $this->desconectar();
        return $query;
    }
    
    public function eliminarDocenteCurso($docenteCursoId) {
        $this->conectar();
        $this->consultaSP("sp_usuario_curso_eliminar(?)");
        $this->cargarDatosSP($docenteCursoId);
        $query = $this->ejecutarSP();
        $this->desconectar();
        return $query;
    }

}
