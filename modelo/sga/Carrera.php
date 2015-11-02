<?php

require_once __DIR__.'/../core/Conexion.php';

class Carrera extends Conexion {
    //put your code here
    public function obtenerCarreras() {
        $this->conectar();
        $this->consultaSP("sp_carrera_obtener()");
        $query = $this->ejecutarSP();
        $this->desconectar();
        return $query;
    }
    
    public function agregarCarrera($carreraNombre,$precio,$estado,$usuarioCreacion){
        $this->conectar();
        $this->consultaSP("sp_carrera_agregar(?,?,?,?)");
        $this->cargarDatosSP($carreraNombre);
        $this->cargarDatosSP($precio);
        $this->cargarDatosSP($estado);
        $this->cargarDatosSP($usuarioCreacion);
        $query = $this->ejecutarSP();
        $this->desconectar();
        return $query;
    }
    
    public function editarCarrera($carreraId,$carreraNombre,$precio,$estado){
        $this->conectar();
        $this->consultaSP("sp_carrera_editar(?,?,?,?)");
        $this->cargarDatosSP($carreraId);
        $this->cargarDatosSP($carreraNombre);
        $this->cargarDatosSP($precio);
        $this->cargarDatosSP($estado);
        $query = $this->ejecutarSP();
        $this->desconectar();
        return $query;
    }
    
    public function eliminarCarrera($carreraId){
        $this->conectar();
        $this->consultaSP("sp_carrera_eliminar(?)");
        $this->cargarDatosSP($carreraId);
        $query = $this->ejecutarSP();
        $this->desconectar();
        return $query;
    }
    
    public function obtenerXDocente($usuarioId){
        $this->conectar();
        $this->consultaSP("sp_carrera_obtenerXDocente(?)");
        $this->cargarDatosSP($usuarioId);
        $query = $this->ejecutarSP();
        $this->desconectar();
        return $query;
    }
    
    public function obtenerPrecioXUsuario($usuarioId){
        $this->conectar();
        $this->consultaSP("sp_carrera_obtenerPrecioXUsuario(?)");
        $this->cargarDatosSP($usuarioId);
        $query = $this->ejecutarSP();
        $this->desconectar();
        return $query;
    }
}
