<?php

class Database {

    static private $_connection;
    private $_cursor;

    function __construct() {
    }

    public function ConexionAdodb() {
        $_conexion = ADONewConnection('mysqli');
        $_conexion->Connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        $_conexion->setFetchMode(ADODB_FETCH_ASSOC);
        $_conexion->Execute("SET NAMES 'utf8'");
        $_conexion->debug = true;
        return $_conexion;
    }

    function execute_query($sql = "", $params = []) {
        $_cursor = $this->ConexionAdodb()->Execute($sql, $params);
        return $_cursor->GetArray();
    }

    function insertQuery($tabla = "", $record = [], $where = []) {
        $cursor = $this->ConexionAdodb()->autoExecute($tabla, $record, "INSERT", $where);
        return $cursor->insert_Id();
    }

    function updateInsert($tabla = "", $record = [], $where = []) {
        $cursor = $this->ConexionAdodb()->autoExecute($tabla, $record, "UPDATE", $where);
        return $cursor->Affected_Rows();
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

}