<?php

require_once __DIR__ . '/../core/Conexion.php';

class CursoHorario extends Conexion {

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
    public function obtenerCursoHorario() {
        $this->conectar();
        $this->consultaSP("sp_curso_horario_obtener()");
        $query = $this->ejecutarSP();
        $this->desconectar();
        return $query;
    }

    public function agregarCursoHorario($horario, $curso, $anioAcademico, $estado, $usuarioCreacion) {
        $this->conectar();
        $this->consultaSP("sp_curso_horario_agregar(?,?,?,?,?)");
        $this->cargarDatosSP($horario);
        $this->cargarDatosSP($curso);
        $this->cargarDatosSP($anioAcademico);
        $this->cargarDatosSP($estado);
        $this->cargarDatosSP($usuarioCreacion);
        $query = $this->ejecutarSP();
        $this->desconectar();
        return $query;
    }

    public function editarCursoHorario($cursoHorarioId, $horario, $curso, $anioAcademico, $estado) {
        $this->conectar();
        $this->consultaSP("sp_curso_horario_editar(?,?,?,?,?)");
        $this->cargarDatosSP($cursoHorarioId);
        $this->cargarDatosSP($horario);
        $this->cargarDatosSP($curso);
        $this->cargarDatosSP($anioAcademico);
        $this->cargarDatosSP($estado);
        $query = $this->ejecutarSP();
        $this->desconectar();
        return $query;
    }
    
    public function eliminarCursoHorario($cursoHorarioId) {
        $this->conectar();
        $this->consultaSP("sp_curso_horario_eliminar(?)");
        $this->cargarDatosSP($cursoHorarioId);
        $query = $this->ejecutarSP();
        $this->desconectar();
        return $query;
    }

}
