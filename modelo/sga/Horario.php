<?php

require_once __DIR__.'/../core/Conexion.php';

class Horario extends Conexion {
    //put your code here
    public function obtener() {
        $this->conectar();
        $this->consultaSP("sp_horario_obtener()");
        $query = $this->ejecutarSP();
        $this->desconectar();
        return $query;
    }

    //put your code here
}
