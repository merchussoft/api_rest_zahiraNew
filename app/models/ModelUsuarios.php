<?php

class ModelUsuarios extends Database {

    function __construct() {
        $this->_conexion = Database::modelInstance("Usuario");
    }

    function loginModel($data=[]){
        $sql = "SELECT u.nombre, u.apellido, u.documento, u.usuario, u.createAt, "
        ."du.email, du.cumpleanos, du.telefono, du.direccion, du.imagen, CONCAT(e.nombre, ' ', e.regimen) as eps "
        ."FROM usuarios as u "
        ."INNER JOIN data_usuarios as du ON du.cod_usuario = u.cod_usuario "
        ."INNER JOIN eps as e ON e.cod_eps = du.cod_eps "
        ."WHERE u.usuario = ? AND u.password = ? AND u.activo = 1";
        return $this->_conexion->execute_query($sql, $data);
    }
}