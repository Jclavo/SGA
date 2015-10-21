<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once __DIR__.'/../../modelo/prueba/modelo.php';

class UniversitarioNegocio{
    
    public function insertar($nombre,$apellido) {
        $Universitarios = new Universitarios;
       return $Universitarios->agregar($nombre,$apellido);        
    }
    
    public function modificar($id,$nombre,$apellido) {
        $Universitarios = new Universitarios;
        return $Universitarios->modificar($id,$nombre,$apellido);        
    }
    
     public function eliminar($id) {
        $Universitarios = new Universitarios;
        return $Universitarios->eliminar($id);        
    }
    
}

