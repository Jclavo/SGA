<?php

require_once __DIR__.'/../core/Conexion.php';

//nuestro modelo   q    almacena  todos  los    o las funciones q  van la  base  de adtso 
//   aca  la  clase    universitarios      que  hereda  los parametros de la conexion 
class Usuario extends Conexion {

    public function iniciarSesion($codigo,$perfil, $clave) {

        $this->conectar();
        $this->consultaSP("sp_usuario_iniciarSesion(?,?,?)");
        $this->cargarDatosSP($codigo);
        $this->cargarDatosSP($perfil);
        $this->cargarDatosSP($clave);
        $query = $this->ejecutarSP();
        $this->desconectar();
        return $query;
    } 
    
    public function obtenerURL($usuarioID) {

        $this->conectar();
        $this->consultaSP("sp_usuario_obtenerMenu(?)");
        $this->cargarDatosSP($usuarioID);
        $query = $this->ejecutarSP();
        $this->desconectar();
        return $query;
    } 
    
    public function obtenerPerfiles() {
        
        $this->conectar();
        $this->consultaSP("sp_perfil_obtenerActivos()");
        $query = $this->ejecutarSP();
        $this->desconectar();
        return $query;
    }
    
    public function obtenerUsuarios() {
        $this->conectar();
        $this->consultaSP("sp_usuario_obtener()");
        $query = $this->ejecutarSP();
        $this->desconectar();
        return $query;
    }
    
    public function validarDNI($usuarioId,$dni,$perfil) {
        $this->conectar();
        $this->consultaSP("sp_usuario_validarDNI(?,?,?)");
        $this->cargarDatosSP($usuarioId);
        $this->cargarDatosSP($dni);
        $this->cargarDatosSP($perfil);
        $query = $this->ejecutarSP();
        $this->desconectar();
        return $query;
    } 
    
    public function agregarUsuario($dni,$perfil,$estado,$usuarioCreacion){
        $this->conectar();
        $this->consultaSP("sp_usuario_agregar(?,?,?,?)");
        $this->cargarDatosSP($dni);
        $this->cargarDatosSP($perfil);
        $this->cargarDatosSP($estado);
        $this->cargarDatosSP($usuarioCreacion);
        $query = $this->ejecutarSP();
        $this->desconectar();
        return $query;
    }   
    
    public function agregarUsuarioDatos($usuarioId,$nombre,$apellidoPaterno,$apellidoMaterno,$edad,
                                   $sexo,$celular,$fechaNacimiento,$estado,$usuarioCreacion){
        $this->conectar();
        $this->consultaSP("sp_usuario_info_agregar(?,?,?,?,?,?,?,?,?,?)");
        $this->cargarDatosSP($usuarioId);
        $this->cargarDatosSP($nombre);
        $this->cargarDatosSP($apellidoPaterno);
        $this->cargarDatosSP($apellidoMaterno);
        $this->cargarDatosSP($edad);
        $this->cargarDatosSP($sexo);
        $this->cargarDatosSP($celular);
        $this->cargarDatosSP($fechaNacimiento);
        $this->cargarDatosSP($estado);
        $this->cargarDatosSP($usuarioCreacion);
        $query = $this->ejecutarSP();
        $this->desconectar();
        return $query;
    }
    
    public function editarUsuario($usuarioId,$dni,$perfil,$estado){
        $this->conectar();
        $this->consultaSP("sp_usuario_editar(?,?,?,?)");
        $this->cargarDatosSP($usuarioId);
        $this->cargarDatosSP($dni);
        $this->cargarDatosSP($perfil);
        $this->cargarDatosSP($estado);
        $query = $this->ejecutarSP();
        $this->desconectar();
        return $query;
    }
    
    public function editarUsuarioDatos($usuarioId,$nombre,$apellidoPaterno,$apellidoMaterno,$edad,
                                   $sexo,$celular,$fechaNacimiento,$estado){
        $this->conectar();
        $this->consultaSP("sp_usuario_info_editar(?,?,?,?,?,?,?,?,?)");
        $this->cargarDatosSP($usuarioId);
        $this->cargarDatosSP($nombre);
        $this->cargarDatosSP($apellidoPaterno);
        $this->cargarDatosSP($apellidoMaterno);
        $this->cargarDatosSP($edad);
        $this->cargarDatosSP($sexo);
        $this->cargarDatosSP($celular);
        $this->cargarDatosSP($fechaNacimiento);
        $this->cargarDatosSP($estado);
        $query = $this->ejecutarSP();
        $this->desconectar();
        return $query;
    }
    
    public function eliminarUsuario($usuarioId,$usuarioCreacion) {
        $this->conectar();
        $this->consultaSP("sp_usuario_eliminar(?,?)");
        $this->cargarDatosSP($usuarioId);
        $this->cargarDatosSP($usuarioCreacion);
        $query = $this->ejecutarSP();
        $this->desconectar();
        return $query;
    }
    
    public function obtenerUsuarioXPerfil($perfil){
        $this->conectar();
        $this->consultaSP("sp_usuario_obtenerXPerfil(?)");
        $this->cargarDatosSP($perfil);
        $query = $this->ejecutarSP();
        $this->desconectar();
        return $query;
    }

    public function cambiarContrashena($usuarioId, $contrasenhaAnterior, $contrasenhaNueva1, $contrasenhaNueva2){
        $this->conectar();
        $this->consultaSP("sp_usuario_cambiarContrasenha(?,?,?,?)");
        $this->cargarDatosSP($usuarioId);
        $this->cargarDatosSP($contrasenhaAnterior);
        $this->cargarDatosSP($contrasenhaNueva1);
        $this->cargarDatosSP($contrasenhaNueva2);
        $query = $this->ejecutarSP();
        $this->desconectar();
        return $query;
    }
    
    public function obtenerXId($id){
        $this->conectar();
        $this->consultaSP("sp_usuario_obtenerInfoXId(?)");
        $this->cargarDatosSP($id);
        $query = $this->ejecutarSP();
        $this->desconectar();
        return $query;
    }
    
    public function guardarUsuarioCurso($usuarioId,$carrera,$usuarioCreacion){
        $this->conectar();
        $this->consultaSP("sp_usuario_carrera_guardar(?,?,?)");
        $this->cargarDatosSP($usuarioId);
        $this->cargarDatosSP($carrera);
        $this->cargarDatosSP($usuarioCreacion);
        $query = $this->ejecutarSP();
        $this->desconectar();
        return $query;
    }
}

