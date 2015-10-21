<?php

require_once __DIR__.'/../core/negocioBase.php';
require_once __DIR__ . '/../../modelo/sga/Publicacion.php';
require_once __DIR__ . '/../../util/util.php';


class PublicacionNegocio extends negocioBase{
    //put your code here
    public function obtenerPublicaciones() {
        $publicacion = new Publicacion;
        $respuestaObtenerPublicaciones = $publicacion->obtenerPublicaciones();
        return $respuestaObtenerPublicaciones;
    }
    
    public function agregarPublicacion($titulo,$mensaje,$estado,$usuarioCreacion) {
        $publicacion = new Publicacion;
        $respuestaAgregarPublicacion = $publicacion->agregarPublicacion($titulo,$mensaje,$estado,$usuarioCreacion);
        return $respuestaAgregarPublicacion;
    }
    
    public function obtenerPublicacionXId($publicacionId){
        $publicacion = new Publicacion;
        $respuestaAgregarPublicacion = $publicacion->obtenerPublicacionXId($publicacionId);
        return $respuestaAgregarPublicacion;
    }
    
    public function editarPublicacion($publicacionId,$titulo,$mensaje,$estado) {
        $publicacion = new Publicacion;
        $respuestaEditarPublicacion = $publicacion->editarPublicacion($publicacionId,$titulo,$mensaje,$estado);
        return $respuestaEditarPublicacion;
    }
    
    public function eliminarPublicacion($publicacionId) {
        $publicacion = new Publicacion;
        $respuestaEditarPublicacion = $publicacion->eliminarPublicacion($publicacionId);
        return $respuestaEditarPublicacion;
    }  
    
     public function obtenerPublicacionesActivas() {
        $publicacion = new Publicacion;
        $respuestaObtenerPublicaciones = $publicacion->obtenerPublicacionesActivas();
        return $respuestaObtenerPublicaciones;
    }
}
