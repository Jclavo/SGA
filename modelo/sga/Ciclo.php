<?php

require_once __DIR__.'/../core/Conexion.php';

class Ciclo extends Conexion {
    //put your code here
    public function obtenerCiclos() {
        $this->conectar();
        $this->consultaSP("sp_ciclo_obtener()");
        $query = $this->ejecutarSP();
        $this->desconectar();
        return $query;
    }

    //put your code here
}
