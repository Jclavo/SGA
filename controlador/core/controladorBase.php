<?php

/**
 * Description of controladorBase
 *
 * @author JClavo
 */
$nombreFuncion = "";
if (!isset($_SESSION)) {
//    echo "se creo la sesion";
    session_start();
//    $_SESSION['usuario_id'] = null;
}

else {
    session_destroy();
    session_start();
}


function retornarVista($value) {
    global $nombreFuncion;
    $dataRetornar = new stdClass();
    $dataRetornar->nombre = $nombreFuncion;   
    $dataRetornar->respuesta = $value;
    echo json_encode($dataRetornar);
}

function obtenerParametro($nombreParametro) {
    $valor =  filter_input(INPUT_POST, $nombreParametro);
    
    if(!empty($valor))
    {
        return trim($valor);
    }
    return $valor;
}

function obtenerUsuarioSesion() {

//    echo isset($_SESSION["usuario_id"]);
    if (!isset($_SESSION["usuario_id"])) {
        return null;
    } else {
         return $_SESSION['usuario_id'];
    }
}
