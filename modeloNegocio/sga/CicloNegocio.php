<?php

require_once __DIR__.'/../core/negocioBase.php';
require_once __DIR__ . '/../../modelo/sga/Ciclo.php';
require_once __DIR__ . '/../../util/util.php';


class CicloNegocio extends negocioBase{
    //put your code here
    public function obtenerCiclos() {
        $ciclo = new Ciclo;
        $respuestaObtenerCiclos = $ciclo->obtenerCiclos();
        return $respuestaObtenerCiclos;
    }
}
