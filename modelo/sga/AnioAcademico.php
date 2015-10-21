<?php

require_once __DIR__.'/../core/Conexion.php';

class AnioAcademico extends Conexion {
    //put your code here
    public function obtenerAnioAcademicoActual() {
        $this->conectar();
        $this->consultaSP("sp_anio_academico_obtenerActual()");
        $query = $this->ejecutarSP();
        $this->desconectar();
        return $query;
    }

    //put your code here
}
