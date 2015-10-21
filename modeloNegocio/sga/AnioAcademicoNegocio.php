<?php

require_once __DIR__.'/../core/negocioBase.php';
require_once __DIR__ . '/../../modelo/sga/AnioAcademico.php';
require_once __DIR__ . '/../../util/util.php';


class AnioAcademicoNegocio extends negocioBase{
    //put your code here
    public function obtenerAnioAcademicoActual() {
        $anioAcademico = new AnioAcademico;
        $respuestaObtenerAnioAcademicoActual = $anioAcademico->obtenerAnioAcademicoActual();
        return $respuestaObtenerAnioAcademicoActual;
    }
    
    
    
}
