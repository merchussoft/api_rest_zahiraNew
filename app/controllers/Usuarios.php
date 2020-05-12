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
        $result_login = $this->model_usuario->loginModel($data);
        if (count($result_login)) {
            foreach ($result_login[0] as $key => $value) {
                $_SESSION[$key] = $value;
            }
            $_SESSION["token"] = $this->general->encripterPass($this->general->generarCodigoSeguridad());
            $return = [$_SESSION, "validate" => 1];
            $_SESSION["base"] = "zahyra_salon";
        }
        return $return;
    }

    function cerrarSession(){
      $jsondata = ["mensaje" => "Error al cerrar sesion"];
      if (isset($_SESSION['usuario'])) {
        session_destroy();
        $jsondata = ["mensaje" => "Sesion cerrada exitosamente"];
      }
      return $jsondata;
    }
}
