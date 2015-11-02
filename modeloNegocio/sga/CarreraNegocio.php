<?php

require_once __DIR__.'/../core/negocioBase.php';
require_once __DIR__ . '/../../modelo/sga/carrera.php';
require_once __DIR__ . '/../../util/util.php';


class CarreraNegocio extends negocioBase{
    //put your code here
    public function obtenerCarreras() {
        $carrera = new Carrera;
        $respuestaObtenerCarreras = $carrera->obtenerCarreras();
        return $respuestaObtenerCarreras;
    }
    
    public function agregarCarrera($carreraNombre,$precio,$estado,$usuarioCreacion) {
        $carrera = new Carrera;
        $respuestaAgregarCarrera = $carrera->agregarCarrera($carreraNombre,$precio,$estado,$usuarioCreacion);
        return $respuestaAgregarCarrera;
    }
    
    public function editarCarrera($carreraId,$carreraNombre,$precio,$estado) {
        $carrera = new Carrera;
        $respuestaEditarCarrera = $carrera->editarCarrera($carreraId,$carreraNombre,$precio,$estado);
        return $respuestaEditarCarrera;
    }
    
    public function eliminarCarrera($carreraId) {
        $carrera = new Carrera;
        $respuestaEditarCarrera = $carrera->eliminarCarrera($carreraId);
        return $respuestaEditarCarrera;
    }
    
    public function obtenerXDocente($usuarioId) {
        $carrera = new Carrera;
        $respuestaObtenerCarreraXDocente = $carrera->obtenerXDocente($usuarioId);
        return $respuestaObtenerCarreraXDocente;
    }
    
    public function obtenerPrecioXUsuario($usuarioId) {
        $carrera = new Carrera;
        $respuestaObtenerPrecioXUsuario = $carrera->obtenerPrecioXUsuario($usuarioId);
        return $respuestaObtenerPrecioXUsuario;
    }
    
}
