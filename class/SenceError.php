<?php

class SenceError
{
    public static function content()
    {
        setcookie("solicitud", "", time() - 3600, "/");
        var_dump($_POST);
        return "<h2>Hubo un error</h2>";
    }
}
