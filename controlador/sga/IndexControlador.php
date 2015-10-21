<?php
require_once __DIR__ . '/../../modeloNegocio/sga/UsuarioNegocio.php';

$usuario = new UsuarioNegocio;
//  nuevo objeto de mi  clase unievrsitarios
$nombreFuncion = obtenerParametro("funcion");

switch ($nombreFuncion) {

    case "cerrarSesion":
        $respuesta = $usuario->cerrarSesion();
        retornarVista($respuesta);
        break;
     case "cambiarContrasenha":
        $contrasenhaAnterior = obtenerParametro("contrasenha_anterior");
        $contrasenhaNueva1 = obtenerParametro("contrasenha_nueva_1");
        $contrasenhaNueva2 = obtenerParametro("contrasenha_nueva_2");
        $usuarioId = obtenerUsuarioSesion();
        $respuesta = $usuario->cambiarContrashena($usuarioId,$contrasenhaAnterior,$contrasenhaNueva1,$contrasenhaNueva2);
        retornarVista($respuesta);
        break;
    default:
        break;
}

