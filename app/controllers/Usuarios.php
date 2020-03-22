<?php


class Usuarios {
    private $model_usuario;
    private $general;

    function __construct() {
        $this->model_usuario = new ModelUsuarios();
        $this->general = new General();
    }

    function login($data = []) {
        $return = ["message" => "Usuario o password incorrectos", "validate" => 0];
        $data["usuario"] = $this->general->limpiarString($data["usuario"]);
        $data["password"] = $this->general->encripterPass($this->general->limpiarString($data["password"], true));
        $result_login = $this->model_usuario->loginModel($data)[0];
        if (count($result_login)) {
            foreach ($result_login as $key => $value) {
                $_SESSION[$key] = $value;
            }
            $return = ["data" => $_SESSION, "validate" => 1];
        }
//        $data["ip_remote"] = $_SERVER['REMOTE_ADDR'];
        return $return;
    }
}