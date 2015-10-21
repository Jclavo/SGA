<?php

require_once __DIR__ . '/../core/negocioBase.php';

require_once __DIR__ . '/AnioAcademicoNegocio.php';
require_once __DIR__ . '/CarreraNegocio.php';
require_once __DIR__ . '/CursoNegocio.php';

require_once __DIR__ . '/../../modelo/sga/Matricula.php';
require_once __DIR__ . '/../../util/util.php';

class MatriculaNegocio extends negocioBase {

    //put your code here
    public function obtenerConfiguracionInicial($usuarioId) {

        $cursoNegocio = new CursoNegocio();
        $respuestaCursosXUsuario = $cursoNegocio->obtenerXUsuario($usuarioId);
        return $respuestaCursosXUsuario;
    }

    public function validarCursoPrerequisito($cursoId, $usuarioId) {

        $matricula = new Matricula();
        $respuestaCursosXUsuario = $matricula->validarCursoPrerequisito($cursoId, $usuarioId);

        if ($respuestaCursosXUsuario[0]['vout_resultado'] == 1) {
            $cursoNegocio = new CursoNegocio();
            $respuestaObtenerCursoXId = $cursoNegocio->obtenerCursoXId($cursoId);
            return $respuestaObtenerCursoXId;
        }
        return $respuestaCursosXUsuario;
    }

    public function matricular($cursosIdCadena, $usuarioId) {

        $respuestaMatricula = $this->realizarMatricula($usuarioId);

        if ($respuestaMatricula[0]['vout_resultado'] == 1) {
            $matriculaId = $respuestaMatricula[0]['matricula_id'];
            $cursosIdArray = explode(',', $cursosIdCadena);
            $this->guardarMatriculaCurso($matriculaId, $cursosIdArray);
        }
        return $respuestaMatricula;
    }

    public function realizarMatricula($usuarioId) {
        $anioAcademico = new AnioAcademico();
        $respuestaAnioAcademico = $anioAcademico->obtenerAnioAcademicoActual();

        if (!empty($respuestaAnioAcademico[0]['id'])) {
            $matricula = new Matricula();
            $respuestaMatricula = $matricula->matricular($usuarioId, $respuestaAnioAcademico[0]['id']);
        }

        return $respuestaMatricula;
    }

    public function guardarMatriculaCurso($matriculaId, $cursosIdArray) {

        $matricula = new Matricula();
        foreach ($cursosIdArray as $curso) {
            $matricula->guardarMatriculaCurso($matriculaId, $curso);
        }
    }
    
     public function obtenerEstadoMatricula($usuarioId) {
        $anioAcademico = new AnioAcademico();
        $respuestaAnioAcademico = $anioAcademico->obtenerAnioAcademicoActual();

        if (!empty($respuestaAnioAcademico[0]['id'])) {
            $matricula = new Matricula();
            $respuestaMatricula = $matricula->existeXUsuario($usuarioId, $respuestaAnioAcademico[0]['id']);
        }

        return $respuestaMatricula;
    }
    
    public function obtenerNotasXUsuario($usuarioId) {

        $matricula = new Matricula();
        $respuestaMatriculaXUsuario = $matricula->obtenerXUsuario($usuarioId);
        return $respuestaMatriculaXUsuario;
    }
    
    public function obtenerAlumnosXCurso($cursoId) {

        $matricula = new Matricula();
        $respuestaObtenerAlumnosXCurso = $matricula->obtenerAlumnosXCurso($cursoId);
        return $respuestaObtenerAlumnosXCurso;
    }
    
    public function guardarNota($id, $nota, $indice) {

        $matricula = new Matricula();
        $respuestaGuardarNota = $matricula->guardarNota($id, $nota, $indice);
        return $respuestaGuardarNota;
    }
    
    public function obtenerPromedio($id) {

        $matricula = new Matricula();
        $respuestaObtenerPromedio = $matricula->obtenerPromedio($id);
        return $respuestaObtenerPromedio;
    }

}
