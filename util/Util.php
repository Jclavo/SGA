<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of util
 *
 * @author JClavo
 */
class Util {
    //put your code here
    
    static public function formatearCadenaACadenaBD($cadena){
        
        $fecha = DateTime::createFromFormat('d-m-Y', $cadena);
        return $fecha->format('Y-m-d');
    }
}
