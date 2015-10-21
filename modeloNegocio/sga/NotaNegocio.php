<?php

require_once __DIR__ . '/../core/negocioBase.php';
require_once __DIR__ . '/CarreraNegocio.php';
require_once __DIR__ . '/CursoNegocio.php';
require_once __DIR__ . '/MatriculaNegocio.php';
require_once __DIR__ . '/../../util/util.php';

class NotaNegocio extends negocioBase {

    //put your code here
    public function obtenerCarreraXDocente($usuarioId) {
        $carrera = new CarreraNegocio();
        $respuestaObtenerCarreraXDocente = $carrera->obtenerXDocente($usuarioId);
        return $respuestaObtenerCarreraXDocente;
    }

    public function obtenerCursoXCarreraXDocente($carrera, $usuarioId) {
        $curso = new CursoNegocio();
        $respuestaObtenerCursoXCarreraXDocente = $curso->obtenerCursoXCarreraXDocente($carrera, $usuarioId);
        return $respuestaObtenerCursoXCarreraXDocente;
    }

    public function obtenerAlumnosXCurso($cursoId) {
        $matricula = new MatriculaNegocio();
        $respuestaObtenerAlumnosXCurso = $matricula->obtenerAlumnosXCurso($cursoId);
        return $respuestaObtenerAlumnosXCurso;
    }

    public function guardarNota($cadenaId, $cadenaNota1, $cadenaNota2, $cadenaNota3) {
        $matricula = new MatriculaNegocio();

        $arrayId = explode(",", $cadenaId);
        $arrayNota1 = explode(",", $cadenaNota1);
        $arrayNota2 = explode(",", $cadenaNota2);
        $arrayNota3 = explode(",", $cadenaNota3);

        $tamanho = count($arrayId);

        for ($index = 0; $index < $tamanho; $index++) {

            $matricula->guardarNota($arrayId[$index], $arrayNota1[$index], 1);
            $matricula->guardarNota($arrayId[$index], $arrayNota2[$index], 2);
            $matricula->guardarNota($arrayId[$index], $arrayNota3[$index], 3);
        }

        return $this->retornarOK(1,"Notas guardada correctamente");
    }
    
    public function obtenerPromedio($cadenaId){
        $matricula = new MatriculaNegocio();

        $arrayId = explode(",", $cadenaId);

        foreach ($arrayId as $id) {
            $matricula->obtenerPromedio($id);
        }

        return $this->retornarOK(1,"Notas guardada correctamente");
    }

}
