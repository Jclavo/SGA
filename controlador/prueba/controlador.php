<?php

//   esto es para  q se demore  en llegar aca    al php 
//include "../modelo/modelo.php";
require_once __DIR__.'/../core/controladorBase.php';
require_once __DIR__.'/../../modeloNegocio/prueba/negocio.php';

$Universitarios = new UniversitarioNegocio;
//  nuevo objeto de mi  clase unievrsitarios
$nombreFuncion = obtenerParametro("funcion");
switch ($nombreFuncion) {
    case "agregar":
        $nombre = obtenerParametro("nombre");
        $apellido = obtenerParametro("apellido");
        $respuesta = $Universitarios->insertar($nombre,$apellido);
        retornarVista($respuesta);
        break;
    default:
    case "modificar":
        $id = obtenerParametro("id");
        $nombre = obtenerParametro("nombre");
        $apellido = obtenerParametro("apellido");
        $respuesta = $Universitarios->modificar($id,$nombre,$apellido);
        retornarVista($respuesta);
        break;
    case "eliminar":
        $id = obtenerParametro("id");
        $respuesta = $Universitarios->eliminar($id);
        retornarVista($respuesta);
        break;
    default:
        break;
}

