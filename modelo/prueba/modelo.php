<?php

require_once __DIR__.'/../core/Conexion.php';

//nuestro modelo   q    almacena  todos  los    o las funciones q  van la  base  de adtso 
//   aca  la  clase    universitarios      que  hereda  los parametros de la conexion 
class Universitarios extends Conexion {

    public function agregar($nombre,$apellido) {

        $this->conectar();
        $this->consultaSP("sp_insertar(?,?)");
        $this->cargarDatosSP($nombre);
        $this->cargarDatosSP($apellido);
        $query = $this->ejecutarSP();
        $this->desconectar();
        return $query;

    }

    public function modificar($id,$nombre,$apellido) {
        
        $this->conectar();
        $this->consultaSP("sp_modificar(?,?,?)");
        $this->cargarDatosSP($id);
        $this->cargarDatosSP($nombre);
        $this->cargarDatosSP($apellido);
        $query = $this->ejecutarSP();
        $this->desconectar();
        return $query;
    }
    
    public function eliminar($id) {
        
        $this->conectar();
        $this->consultaSP("sp_eliminar(?)");
        $this->cargarDatosSP($id);
        $query = $this->ejecutarSP();
        $this->desconectar();
        return $query;
    }
    
    
}

