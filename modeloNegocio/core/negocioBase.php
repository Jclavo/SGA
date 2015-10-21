<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of negocioBase
 *
 * @author JClavo
 */
class negocioBase {
    //put your code here
    public function retornarOK($resultado,$mensaje) {
        $arrayEnvio = array();
        $data = new stdClass();
        $data->vout_resultado = $resultado;
        $data->vout_mensaje = $mensaje;
        
        array_push($arrayEnvio, $data);
        return $arrayEnvio;
    }
}
