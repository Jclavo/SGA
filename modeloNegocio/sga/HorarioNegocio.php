<?php

require_once __DIR__.'/../core/negocioBase.php';
require_once __DIR__ . '/../../modelo/sga/Horario.php';
require_once __DIR__ . '/../../util/util.php';


class HorarioNegocio extends negocioBase{
    //put your code here
    public function obtener() {
        $horario = new Horario;
        $respuestaObtenerHorario = $horario->obtener();
        return $respuestaObtenerHorario;
    }
    
}
