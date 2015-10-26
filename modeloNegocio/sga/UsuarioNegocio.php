<?php

require_once __DIR__ . '/../core/negocioBase.php';
require_once __DIR__ . '/../../modelo/sga/usuario.php';
require_once __DIR__ . '/CarreraNegocio.php';
require_once __DIR__ . '/../../util/util.php';

class UsuarioNegocio extends negocioBase {

    const PERFIL_DOCENTE = 2;
    const PERFIL_AlUMNO = 3;

    public function iniciarSesion($codigo, $perfil, $clave) {
        $usuario = new Usuario;
        $respuestaIniciarSesion = $usuario->iniciarSesion($codigo, $perfil, $clave);

        if ($respuestaIniciarSesion[0]['vout_resultado'] == 1) {
            $_SESSION['usuario_id'] = $respuestaIniciarSesion[0]['id'];
        }

        return $respuestaIniciarSesion;
    }

    public function verificarSesion($usuarioID) {
        $data = array();
        if (empty($usuarioID)) {
            $respuesta = new stdClass();
            array_push($data, $this->getVerificarSesion(0));
            $respuesta->menu = $data;        
        } else {
            $usuario = new Usuario;

            $respuesta = new stdClass();
            $respuesta->info = $this->obtenerDataBasicaXId($usuarioID);
            $respuesta->menu = $usuario->ObtenerURL($usuarioID);
        }
        return $respuesta;
    }
    
    public function obtenerDataBasicaXId($usuarioID)
    {
        $usuario = new Usuario;
        return $usuario->obtenerDataBasicaXId($usuarioID);
    }

    private function getVerificarSesion($resultado, $usuarioID = 0) {
        $data = new stdClass();
        $data->vout_resultado = $resultado;
        $data->id = $usuarioID;

        return $data;
    }

    public function cerrarSesion() {
        session_destroy();
        $data = array();
        array_push($data, $this->getVerificarSesion(0));
        return $data;
    }

    public function obtenerPerfiles() {
        $usuario = new Usuario;
        $respuestaObtenerPerfiles = $usuario->obtenerPerfiles();
        return $respuestaObtenerPerfiles;
    }
    
    public function obtenerConfiguracionInicial()
    {
        $respuesta = new stdClass();
        $respuesta->perfiles = $this->obtenerPerfiles();
        $respuesta->carreras = $this->obtenerCarreras();
        return $respuesta;
    }
    
    public function obtenerCarreras()
    {
        $carrera = new CarreraNegocio;
        $respuestaObtenerCarreras = $carrera->obtenerCarreras();
        return $respuestaObtenerCarreras;
    }

    public function obtenerUsuarios() {
        $usuario = new Usuario;
        $respuestaObtenerUsuarios = $usuario->obtenerUsuarios();
        return $respuestaObtenerUsuarios;
    }

    public function validarDNI($usuarioId, $dni, $perfil) {
        $usuario = new Usuario;
        $respuestaValidarDNI = $usuario->validarDNI($usuarioId, $dni, $perfil);
        return $respuestaValidarDNI;
    }

    public function agregarUsuario($dni, $perfil, $nombre, $apellidoPaterno, $apellidoMaterno, $edad, $sexo, $celular, $fechaNacimiento, $estado, $usuarioCreacion, $carrera) {
        $usuario = new Usuario;
        $respuestaAgregarUsuario = $usuario->agregarUsuario($dni, $perfil, $estado, $usuarioCreacion);

        if ($respuestaAgregarUsuario[0]['vout_exito'] == 1) {
            $usuarioId = $respuestaAgregarUsuario[0]['usuario_id'];
            $respuestaAgregarUsuarioDatos = $usuario->agregarUsuarioDatos($usuarioId, $nombre, $apellidoPaterno, $apellidoMaterno, $edad, $sexo, $celular, $fechaNacimiento, $estado, $usuarioCreacion);

            $this->guardarUsuarioCurso($perfil, $usuarioId, $carrera, $usuarioCreacion);
            return $respuestaAgregarUsuarioDatos;
        } else {
            return $respuestaAgregarUsuario;
        }
    }

    public function editarUsuario($usuarioId, $dni, $perfil, $nombre, $apellidoPaterno, $apellidoMaterno, $edad, $sexo, $celular, $fechaNacimiento, $estado, $carrera) {
        $usuario = new Usuario;
        $respuestaEditarUsuario = $usuario->editarUsuario($usuarioId, $dni, $perfil, $estado);

        if ($respuestaEditarUsuario[0]['vout_resultado'] == 1) {
//            $respuestaEditarUsuarioDatos = $usuario->editarUsuarioDatos($usuarioId, $nombre, $apellidoPaterno, $apellidoMaterno, $edad, $sexo, $celular, Util::formatearCadenaACadenaBD($fechaNacimiento), $estado);
            $respuestaEditarUsuarioDatos = $usuario->editarUsuarioDatos($usuarioId, $nombre, $apellidoPaterno, $apellidoMaterno, $edad, $sexo, $celular, $fechaNacimiento, $estado);
             $this->guardarUsuarioCurso($perfil, $usuarioId, $carrera, $usuarioCreacion = 0);
            return $respuestaEditarUsuarioDatos;
        } else {
            return $respuestaEditarUsuario;
        }
    }

    private function guardarUsuarioCurso($perfil, $usuarioId, $carrera, $usuarioCreacion) {
        if ($perfil==UsuarioNegocio::PERFIL_AlUMNO) {
            $usuario = new Usuario;
            $usuario->guardarUsuarioCurso($usuarioId, $carrera, $usuarioCreacion);
        }
    }

    public function eliminarUsuario($usuarioId, $usuarioCreacion) {
        $usuario = new Usuario;
        $respuestaEliminarUsuario = $usuario->eliminarUsuario($usuarioId, $usuarioCreacion);
        return $respuestaEliminarUsuario;
    }

    public function obtenerDocentes() {
        return $this->obtenerUsuarioXPerfil(UsuarioNegocio::PERFIL_DOCENTE);
    }

    public function obtenerUsuarioXPerfil($perfil) {
        $usuario = new Usuario;
        $respuestaObtenerUsuarioXPerfil = $usuario->obtenerUsuarioXPerfil($perfil);
        return $respuestaObtenerUsuarioXPerfil;
    }

    public function cambiarContrashena($usuarioId, $contrasenhaAnterior, $contrasenhaNueva1, $contrasenhaNueva2) {
        $usuario = new Usuario;
        $respuestaCambiarContrasenha = $usuario->cambiarContrashena($usuarioId, $contrasenhaAnterior, $contrasenhaNueva1, $contrasenhaNueva2);
        return $respuestaCambiarContrasenha;
    }

}
