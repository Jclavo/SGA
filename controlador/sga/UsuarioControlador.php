<?php

require_once __DIR__ . '/../core/controladorBase.php';
require_once __DIR__ . '/IndexControlador.php';
require_once __DIR__ . '/../../modeloNegocio/sga/UsuarioNegocio.php';

$usuario = new UsuarioNegocio;
//  nuevo objeto de mi  clase unievrsitarios
$nombreFuncion = obtenerParametro("funcion");

switch ($nombreFuncion) {
    case "iniciarSesion":
        $codigo = obtenerParametro("codigo");
        $perfil = obtenerParametro("perfil");
        $clave = obtenerParametro("clave");
        $respuesta = $usuario->iniciarSesion($codigo,$perfil, $clave);
        retornarVista($respuesta);
        break;
    case "verificarSesion":
        $usuarioID = obtenerUsuarioSesion();
        $respuesta = $usuario->verificarSesion($usuarioID);
        retornarVista($respuesta);
        break;
//    case "cerrarSesion":
//        $respuesta = $usuario->cerrarSesion();
//        retornarVista($respuesta);
//        break;
    case "obtenerPerfiles":
        $respuesta = $usuario->obtenerPerfiles();
        retornarVista($respuesta);
        break;
    case "obtenerConfiguracionInicial":
        $respuesta = $usuario->obtenerConfiguracionInicial();
        retornarVista($respuesta);
        break;
    case "obtenerUsuarios":
        $respuesta = $usuario->obtenerUsuarios();
        retornarVista($respuesta);
        break;
    case "validarDNI":
        $usuarioId = obtenerParametro("usuario_id");
        $dni = obtenerParametro("dni");
        $perfil = obtenerParametro("perfil");
        $respuesta = $usuario->validarDNI($usuarioId,$dni,$perfil);
        retornarVista($respuesta);
        break;
    case "agregarUsuario":
        $dni = obtenerParametro("dni");
        $perfil = obtenerParametro("perfil");
        $nombre = obtenerParametro("nombre");
        $apellidoPaterno = obtenerParametro("apellido_paterno");
        $apellidoMaterno = obtenerParametro("apellido_materno");
        $edad = obtenerParametro("edad");
        $sexo = obtenerParametro("sexo");
        $celular = obtenerParametro("celular");
        $fechaNacimiento = obtenerParametro("fecha_nacimiento");
        $estado = obtenerParametro("estado");
        $carrera = obtenerParametro("carrera");
        $usuarioCreacion = obtenerUsuarioSesion();
        
        $respuesta = $usuario->agregarUsuario($dni,$perfil,$nombre,$apellidoPaterno,$apellidoMaterno,$edad,$sexo,$celular,$fechaNacimiento,$estado,$usuarioCreacion,$carrera);
        retornarVista($respuesta);
        break;
    
    case "editarUsuario":
        $usuarioId = obtenerParametro("usuario_id");
        $dni = obtenerParametro("dni");
        $perfil = obtenerParametro("perfil");
        $nombre = obtenerParametro("nombre");
        $apellidoPaterno = obtenerParametro("apellido_paterno");
        $apellidoMaterno = obtenerParametro("apellido_materno");
        $edad = obtenerParametro("edad");
        $sexo = obtenerParametro("sexo");
        $celular = obtenerParametro("celular");
        $fechaNacimiento = obtenerParametro("fecha_nacimiento");
        $estado = obtenerParametro("estado");
        $carrera = obtenerParametro("carrera");
        
        $respuesta = $usuario->editarUsuario($usuarioId,$dni,$perfil,$nombre,$apellidoPaterno,$apellidoMaterno,$edad,$sexo,$celular,$fechaNacimiento,$estado,$carrera);
        retornarVista($respuesta);
        break;
    case "eliminarUsuario":
        $usuarioId = obtenerParametro("usuario_id");
        $usuarioCreacion = obtenerUsuarioSesion();
        $respuesta = $usuario->eliminarUsuario($usuarioId,$usuarioCreacion);
        retornarVista($respuesta);
        break;
//     case "cambiarContrasenha":
//        $contrasenhaAnterior = obtenerParametro("contrasenha_anterior");
//        $contrasenhaNueva1 = obtenerParametro("contrasenha_nueva_1");
//        $contrasenhaNueva2 = obtenerParametro("contrasenha_nueva_2");
//        $usuarioId = obtenerUsuarioSesion();
//        $respuesta = $usuario->cambiarContrashena($usuarioId,$contrasenhaAnterior,$contrasenhaNueva1,$contrasenhaNueva2);
//        retornarVista($respuesta);
//        break;
    default:
        break;
}

