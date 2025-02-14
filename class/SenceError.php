<?php

class SenceError
{
    private static $errores = [
        "200" => "El POST tiene uno o más parámetros mandatorios sin información. Esto también ocurre cuando un parámetro está mal escrito (por ejemplo, RutAlumno en lugar de RunAlumno), o cuando se ingresan sólo espacios en blanco en un parámetro obligatorio.",
        "201" => "La URL de Retoma y/o URL de Error no tienen información. Ambos parámetros son obligatorios en todos los POST.",
        "202" => "La URL de Retoma tiene formato incorrecto.",
        "203" => "La URL de Error tiene formato incorrecto.",
        "204" => "El Código SENCE tiene menos de 10 caracteres y/o no es código válido.",
        "205" => "El Código Curso tiene menos de 7 caracteres y/o no es código válido.",
        "206" => "La línea de capacitación es incorrecta.",
        "207" => "El Run Alumno tiene formato incorrecto, o tiene el dígito verificador incorrecto.",
        "208" => "El Run Alumno no está autorizado para realizar el curso.",
        "209" => "El Rut OTEC tiene formato incorrecto, o tiene el dígito verificador incorrecto.",
        "211" => "El Token no pertenece al OTEC.",
        "212" => "El Token no está vigente.",
        "300" => "Error interno no clasificado, se debe reportar al SENCE con la mayor cantidad de antecedentes disponibles.",
        "301" => "No se pudo registrar el ingreso o cierre de sesión. Esto ocurre cuando la Línea de Capacitación es incorrecta, o el Código de Curso es incorrecto.",
        "302" => "No se pudo validar la información del Organismo, se debe reportar al SENCE con la mayor cantidad de antecedentes disponibles.",
        "303" => "El Token no existe, o su formato es incorrecto.",
        "304" => "No se pudieron verificar los datos enviados, se debe reportar al SENCE con la mayor cantidad de antecedentes disponibles (ej. enviar parámetros de inicio o cierre de sesión según corresponda).",
        "305" => "No se pudo registrar la información, se debe reportar al SENCE con la mayor cantidad de antecedentes disponibles (ej. enviar parámetros de inicio o cierre de sesión según corresponda).",
        "306" => "El Código Curso no corresponde al código SENCE.",
        "307" => "El Código Curso no tiene modalidad E-learning.",
        "308" => "El Código Curso no corresponde al RUT OTEC.",
        "309" => "Las fechas de ejecución comunicadas para el Código Curso no corresponden a la fecha actual.",
        "310" => "El Código Curso está en estado Terminado o Anulado.",
        "311" => "Run ingresado en el Login de Clave Única no corresponde con Run alumno informado por el ejecutor.",
        "312" => "No se pudo completar la autenticación con Clave Única.",
        "313" => "URL de Cierre de sesión Incorrecta."
    ];
    private static function send_error_mail($data)
    {
        $to = get_option('admin_email');
        $subject = 'Error inicio de sesión Sence';
        $data_body = "";
        foreach ($data as $key => $value) {
            $data_body .= "<li>$key:      $value</li>";
        }
        $message = " <h3>Error " . $data["GlosaError"] . ": " . self::$errores[$data["GlosaError"]] . "</h3><ul>" . $data_body . "
        </ul>
        ";
        $headers = array(
            'From: ' . get_option('admin_email'),
            'Content-Type: text/html; charset=UTF-8'
        );
        $send = wp_mail($to, $subject, $message, $headers);
        if (!$send) {
            echo "error Correo";
            var_dump($send);
            echo get_option('admin_email');
        }
    }
    public static function content()
    {
        setcookie("solicitud", "", time() - 3600, "/");

        if (isset($_POST['GlosaError'])) {
            self::send_error_mail($_POST);
            return "<h2>Hubo un error</h2>";
        } else {
            die('<h1>No Access</h1>');
        }
    }
}
