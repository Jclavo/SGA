<?php

require_once __DIR__ . '/../core/Conexion.php';

class Publicacion extends Conexion {

    //put your code here
    public function obtenerPublicaciones() {
        $this->conectar();
        $this->consultaSP("sp_publicacion_obtener()");
        $query = $this->ejecutarSP();
        $this->desconectar();
        return $query;
    }

    public function agregarPublicacion($titulo, $mensaje, $estado, $usuarioCreacion) {
        $this->conectar();
        $this->consultaSP("sp_publicacion_agregar(?,?,?,?)");
        $this->cargarDatosSP($titulo);
        $this->cargarDatosSP($mensaje);
        $this->cargarDatosSP($estado);
        $this->cargarDatosSP($usuarioCreacion);
        $query = $this->ejecutarSP();
        $this->desconectar();
        return $query;
    }

    public function obtenerPublicacionXId($publicacionId) {
        $this->conectar();
        $this->consultaSP("sp_publicacion_obtenerXId(?)");
        $this->cargarDatosSP($publicacionId);
        $query = $this->ejecutarSP();
        $this->desconectar();
        return $query;
    }

    public function editarPublicacion($publicacionId, $titulo, $mensaje, $estado) {
        $this->conectar();
        $this->consultaSP("sp_publicacion_editar(?,?,?,?)");
        $this->cargarDatosSP($publicacionId);
        $this->cargarDatosSP($titulo);
        $this->cargarDatosSP($mensaje);
        $this->cargarDatosSP($estado);
        $query = $this->ejecutarSP();
        $this->desconectar();
        return $query;
    }

    public function eliminarPublicacion($publicacionId) {
        $this->conectar();
        $this->consultaSP("sp_publicacion_eliminar(?)");
        $this->cargarDatosSP($publicacionId);
        $query = $this->ejecutarSP();
        $this->desconectar();
        return $query;
    }
    
     public function obtenerPublicacionesActivas() {
        $this->conectar();
        $this->consultaSP("sp_publicacion_obtenerActivos()");
        $query = $this->ejecutarSP();
        $this->desconectar();
        return $query;
    }

}
