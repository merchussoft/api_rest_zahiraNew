<?php


class General {

    function __construct() {
    }

    public function encripterPass($password) {
        return hash('sha512', SECURITY . $password);
    }

    public static function validarPassword($password = "", $hash = "") {
        return ($hash == self::encripterPass($password));
    }

    function limpiarString($string = "", $modulo = "") {
        $string = trim($string, " ");

        $string = str_replace(
            array('á', 'à', 'ä', 'â', 'ª', 'Á', 'À', 'Â', 'Ä'), array('a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A'), $string
        );

        $string = str_replace(
            array('é', 'è', 'ë', 'ê', 'É', 'È', 'Ê', 'Ë'), array('e', 'e', 'e', 'e', 'E', 'E', 'E', 'E'), $string
        );

        $string = str_replace(
            array('í', 'ì', 'ï', 'î', 'Í', 'Ì', 'Ï', 'Î'), array('i', 'i', 'i', 'i', 'I', 'I', 'I', 'I'), $string
        );

        $string = str_replace(
            array('ó', 'ò', 'ö', 'ô', 'Ó', 'Ò', 'Ö', 'Ô'), array('o', 'o', 'o', 'o', 'O', 'O', 'O', 'O'), $string
        );

        $string = str_replace(
            array('ú', 'ù', 'ü', 'û', 'Ú', 'Ù', 'Û', 'Ü'), array('u', 'u', 'u', 'u', 'U', 'U', 'U', 'U'), $string
        );

        $string = str_replace(
            array('ñ', 'Ñ', 'ç', 'Ç'), array('n', 'N', 'c', 'C',), $string
        );

        $string = str_replace(
            array("¨", "º", "-", "~", "#", "|", "!", '"', "·", "$", "%", "&", "/", "(", ")", "?", "'", "¡", "¿", "[",
                "^", "]", "+", "}", "{", "¨", "´", ">", "<", ";", ",", ":", ".", "�", "Â»", "Â¼", "Â½", "Â¾", "Â¿",
                "Ã€", "Ã'", "Ã‚", "Ãƒ", "Ã„", "Ã…", "Ã†", "Ã‡", "Ãˆ", "Ã‰", "ÃŠ", "Ã‹", "ÃŒ", "ÃŽ", "Ã‘", "Ã’", "Ã“", "Ã”",
                "Ã•", "Ã–", "Ã˜", "Ã™", "Ãš", "Ã›", "Ãœ", "Ãž", "ÃŸ", "Ã¡", "Ã¢", "Ã£", "Ã¤", "Ã¥", "Ã¦", "Ã§", "Ã¨", "Ã©",
                "Ãª", "Ã«", "Ã®", "Ã¯", "Ã°", "Ã±", "Ã²", "Ã³", "Ã´", "Ãµ", "¡", "¢", "£", "¤", "¥", "¦", "§", "¨", "©", "ª",
                "«", "®", "¯", "°", "±", "²", "³", "´", "µ", "·", "º", "»", "¼", "½", "¾", "À", "Â", "Ä", "Å", "Æ", "Ç", "È",
                "Ê", "Ë", "Ì", "Î", "Ï", "Ð", "Û", "Ù", "Ø", "°", "♦", "Â¡", "<code>", " "), '', $string);

        if ($modulo) {
            $string = preg_replace(array('/[^a-zA-Z0-9\-<>]/', '/[\-]+/', '/<{^>*>/'), " ", $string);
        }

        return $string;
    }


}