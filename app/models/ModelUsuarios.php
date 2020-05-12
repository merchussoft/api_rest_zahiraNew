<?php

class ModelUsuarios extends Database {

    function __construct() {
        $this->_conexion = Database::modelInstance("Usuario");
    }

    function loginModel($data=[]){
        $sql = "SELECT u.cod_usuario as codigo, u.nombre, u.apellido, u.usuario, du.imagen, p.nombre as perfil "
        ."FROM usuarios as u "
        ."INNER JOIN data_usuarios as du ON du.cod_usuario = u.cod_usuario "
        ."INNER JOIN eps as e ON e.cod_eps = du.cod_eps "
        ."INNER JOIN perfiles as p ON p.cod_perfil = du.cod_perfil "
        ."WHERE u.usuario = ? AND u.password = ? AND u.activo = 1";
        return $this->_conexion->execute_query($sql, $data);
    }

    function routers($data=[]){
      $sql = "SELECT nombre "
      ."FROM permisos p "
      ."INNER JOIN modulos m ON m.cod_modulo = p.cod_modulo "
      ."WHERE p.cod_usuario = ?";
      return $this->_conexion->execute_query($sql, $data);
    }
}
