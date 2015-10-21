<?php

class Conexion {

    private $conexion = "";
    public $servidor = "localhost";
    public $user = "root";
    private $bd = "sga";
    private $pass = "";
    private $conexionMYSQLi = "";
    
    private $arrayDataSP = array();
    private $arrayTipoDataSP = array();

// un constructor     para la  conexion 
//    public function conectar() {
//
//        $this->conexion = mysql_connect($this->servidor, $this->user) or die("nose  conecto");
//
//
//        $dbP = mysql_select_db($this->bd, $this->conexion);
//    }

    public function conectar() {
        $this->conexionMYSQLi = new mysqli($this->servidor, $this->user, $this->pass, $this->bd);

        if ($this->conexionMYSQLi->connect_errno) { //comprobamos que no haya errores de conexión
            die('Error al conectar'); //mensaje de error
        }
    }

    public function desconectar() {
        $this->conexionMYSQLi->close();
//        mysql_close();
    }

    /**
     * Metodo para obtener la cantidad de registros que se obtiene de una consulta 
     * @param $result 
     */
    function numero_de_filas($result) {
        if (!is_resource($result))
            return false;
        return mysql_num_rows($result);
    }

    /**
     * Devuelve un array asociativo que corresponde a la fila recuperada 
     * y mueve el puntero de datos interno hacia adelante
     */
    function fetch_assoc($result) {
        if (!is_resource($result))
            return false;
        return mysql_fetch_assoc($result);
    }

    /**
     * Metodo para realizar una consulta
     * @param $sql Consulta SQL Ej. 'SELECT * FROM tabla'
     */
    public function consulta($sql) {
        $resultado = mysql_query($sql, $this->conexion);
        if (!$resultado) {
            echo 'MySQL Error: ' . mysql_error();
            exit;
        }
        return $resultado;
    }

    //consulta de un procedimiento almacenado
//    public function consultaSPExtra($sql) {
//        $resultado = $this->conexionMYSQLi->query($sql);
//        if (!$resultado) {
//            echo 'MySQL Error: ' . mysql_error();
//            exit;
//        }
//        return $resultado;
//    }

    private $prepared_st = null;

    public function consultaSP($sql) {

        $this->limpiarArrayDatosSP();
        
        $this->prepared_st = $this->conexionMYSQLi->prepare("call ".$sql);
        if (!$this->prepared_st) {
            echo 'MySQL Error: ' . die("Error");
            exit;
        }
    }
    
    function limpiarArrayDatosSP()
    {
        unset($this->arrayDataSP);
        unset($this->arrayTipoDataSP);
          $this->arrayDataSP = array();
          $this->arrayTipoDataSP = array();
    }

    public function cargarDatosSP($valor) {
        
        array_push($this->arrayTipoDataSP,'s');
        if(empty($valor) && $valor!="0")
        {
            array_push($this->arrayDataSP, "-1");
        }
        else
        {
            array_push($this->arrayDataSP, $valor);
        }
        
    }
    
    public function ejecutarSP() {
        
        $refs=array();
        if(!empty($this->arrayDataSP))
        {
            $arr = &$this->arrayDataSP;
            foreach($arr as $key => $value) 
            {
                $refs[$key] = &$arr[$key];
            }

            $bind=array_merge(array(implode('',$this->arrayTipoDataSP)),$refs);

            call_user_func_array(array($this->prepared_st,'bind_param'),$bind);
        }
        if (!$this->prepared_st->execute()) {//ejecutamos la consulta
            die("Fallo en la ejecución");
            exit;
        }

        $meta = $this->prepared_st->result_metadata();
        while ($field = $meta->fetch_field()) {
            $params[] = &$row[$field->name];
        }

        call_user_func_array(array($this->prepared_st, 'bind_result'), $params);
        
        $result = null;
        while ($this->prepared_st->fetch()) {
            foreach ($row as $key => $val) {
                $c[$key] = $val;
            }
            $result[] = $c;
        }

        $this->prepared_st->close(); //cerramos el prepare

        return $result;
    }

}
