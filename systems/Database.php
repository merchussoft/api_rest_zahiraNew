<?php

class Database {

    static private $_model;
    static private $_conexion;
    private static $_instance;
    private $_cursor;
    private $_host;
    private $_user;
    private $_pass;
    private $_dbName;
    private $_debugdb = false;
    private $_debug = false;
    public $_errores;
    private $_user;

    function __construct($model) {
        $this->_host = DB_HOST;
        $this->_user = DB_USER;
        $this->_pass = DB_PASS;
        $this->_dbName = DB_NAME;
        $this->_debug = DEBUG;
        $this->_model = $model;
        $this->ConexionAdodb();
        $this->_user = isset($_SESSION['usuario']) ? $_SESSION['usuario'] : "Servidor_inicio";
    }

    public function ConexionAdodb() {
        self::$_conexion = ADONewConnection('mysqli');
        self::$_conexion->Connect($this->_host, $this->_user, $this->_pass, $this->_dbName);
        self::$_conexion->setFetchMode(ADODB_FETCH_ASSOC);
        self::$_conexion->Execute("SET NAMES 'utf8'");
    }

    function execute_query($sql = "", $params = []) {
        $this->_cursor = self::$_conexion->Execute($sql, $params);
        $this->estatusConexion($sql, $params);
        return $this->_cursor->GetArray();
    }

    function insertQuery($tabla = "", $record = []) {
        $this->_cursor = self::$_conexion->autoExecute($tabla, $record, "INSERT");
        $this->estatusConexion($this->_cursor->sql, $record);
        return $this->_cursor->insert_Id();
    }

    function updateInsert($tabla = "", $record = [], $where = []) {
        $this->_cursor = self::$_conexion->autoExecute($tabla, $record, "UPDATE", $where);
        $this->estatusConexion($this->_cursor->sql, ["data_update" => $record, "data_where" => $where]);
        return $this->_cursor->Affected_Rows();
    }

    function simplequerySelect($query = array()) {
        $arreglo_campos = "*";
        if (array_key_exists('arreglo_campos', $query)) {
            $arreglo_campos = implode(", ", $query['arreglo_campos']);
        }
        $arreglo_where = "1 = 1";
        if (array_key_exists('arreglo_where', $query)) {
            $arreglo_where .= " AND " . $query['arreglo_where'];
        }
        if (array_key_exists('arreglo_adiccional', $query)) {
            $query['arreglo_adiccional'];
        }
        $query = "SELECT " . $arreglo_campos . " FROM " . $query['table'] . " WHERE " . $arreglo_where . " " . $query['arreglo_adiccional'];
        return $this->execute_query($query);
    }

    function habilita_debug($debug = true) {
        $this->_debugdb = $debug;
        self::$_conexion->debug = $this->_debugdb;
    }

    static public function modelInstance($model) {
        if (!self::$_instance instanceof self) {
            self::$_instance = new self($model);
        }
        return self::$_instance;
    }

    function estatusConexion($sql = "", $parametros = []) {
        $this->_errores = array();
        $tiempo_inicial = microtime(true);
        $tiempo_final = microtime(true);
        $tiempo = $tiempo_inicial . "-" . $tiempo_final;
        $Hora_Inicio = date("H:i:s");
        $hora_termina = date("H:i:s");

        if (!$this->_cursor) {
            $this->_errores['numero'] = self::$_conexion->ErrorNo();
            $this->_errores['mensaje'] = self::$_conexion->ErrorMsg();
            $this->logDatabase("Error Hora inicio:$Hora_Inicio|Hora Final:$hora_termina | No error  " . $this->_errores['numero'] . " | usuario " . $this->_user . "| :" . $this->_errores['numero'] . "y mensaje " . $this->_errores['mensaje'] . "\r\n En la consulta : " . $sql . " data " . json_encode($parametros), "error");
        } else {
            if ($this->_debug === true) {
                $sql_temp = "";
                if (isset($this->_cursorsql))
                    $sql_temp = $this->_cursor->sql;
                if ($sql_temp == "")
                    $sql_temp = $sql;
                if (floatval($tiempo) >= 0.1) {
                    $this->logDatabase("Error Hora inicio:#-$Hora_Inicio|#-Hora Final:$hora_termina  | usuario " . $this->_user . " | Duracion :" . $tiempo . "| :" . self::$_conexion->ErrorMsg() . "\r\n En la consulta : " . $sql_temp . " data " . json_encode($parametros). " \n ", "slow");
                } else {
                    $this->logDatabase("Consulta Realizada Hora inicio:$Hora_Inicio|Hora Final:$hora_termina |Total " . $this->getTotal() . " | usuario " . $this->_user . "| Duracion :" . $tiempo . "| \n Consulta :" . $sql_temp . " data " . json_encode($parametros). " \n ");
                }

            }
        }
    }

    function logDatabase($str, $type="") {
        $archivo = LOGS . "log_" . $this->_model;
        if($type != ""){
          $archivo .= "_". $type;
        }
        $archivo .= ".txt";
        $fp = fopen($archivo, 'a');
        fputs($fp, "IP " . self::$_conexion->host . ". Fecha " . date("d-m-Y h:i:s A ") . $str . "\n");
        fclose($fp);
    }


    function getTotal() {
        $total_registros = 0;
        if ($this->_cursor) {
            $total_registros = $this->_cursor->Recordcount();
        }
        return $total_registros;
    }

}
