<?php
require_once 'SencePublicDatabase.php';

class SenceExito
{
  private static function get_user_data()
  {
    $current_user = wp_get_current_user();
    if ($current_user->ID) {
      $data = SencePublicDatabase::get_form_sence_data($current_user->user_email);
    } else {
      $data = [];
    }
    return $data;
  }
  private static function login_sence()
  {
    $form_data = self::get_user_data();
    if (!$form_data) {
      echo '<h1>No hay usuario autenticado.</h1>';
      return;
    }

    $url = 'https://sistemas.sence.cl/rcetest/Registro/IniciarSesion';

    $RutOtec = $form_data['rut_otec'];
    $token = $form_data['token'];
    $CodigoSence = $form_data['cod_sence'];
    $CodigoCurso = $form_data['codigo_curso'];
    $LineaCapacitacion = $form_data['linea_capacitacion'];
    $RunAlumno = $form_data['run_alumno'];
    $IdSesionAlumno = $form_data['id_sesion_alumno'];
    $URLExito = $form_data['url_exito'];
    $URLError = $form_data['url_error'];

    $html = " 
        <form
      name='formPost'
      method='post'
      action='{$url}'
    >
      <input type='hidden' name='RutOtec' value='{$RutOtec}' />
      <input
        type='hidden'
        name='Token'
        value='{$token}'
      />
      <input type='hidden' name='CodSence' value='{$CodigoSence}' />
      <input type='hidden' name='CodigoCurso' value='{$CodigoCurso}' />
      <input type='hidden' name='LineaCapacitacion' value='{$LineaCapacitacion}' />
      <input type='hidden' name='RunAlumno' value='{$RunAlumno}' />
      <input type='hidden' name='IdSesionAlumno' value='{$IdSesionAlumno}' />
      <input
        type='hidden'
        name='UrlRetoma'
        value='{$URLExito}'
      />
      <input
        type='hidden'
        name='UrlError'
        value='{$URLError}'
      />
      <input type='submit' title='Iniciar sesión Sence' id='btn-sence' value=''/>
    </form>
    ";

    return $html;
  }
  private static function exit_sence($IdSesionSence = null)
  {
    $form_data = self::get_user_data();
    if (!$form_data) {
      echo '<h1>No hay usuario autenticado.</h1>';
      return;
    }

    $url = 'https://sistemas.sence.cl/rcetest/Registro/CerrarSesion';

    $RutOtec = $form_data['rut_otec'];
    $token = $form_data['token'];
    $CodigoSence = $form_data['cod_sence'];
    $CodigoCurso = $form_data['codigo_curso'];
    $LineaCapacitacion = $form_data['linea_capacitacion'];
    $RunAlumno = $form_data['run_alumno'];
    $IdSesionAlumno = $form_data['id_sesion_alumno'];
    $URLExito = $form_data['url_exito'];
    $URLError = $form_data['url_error'];

    $IdSesionSence = $IdSesionSence == null ? $_COOKIE["IdSesionSence"] : $IdSesionSence;

    $html = " 
            <form
          id='salir-sence'
          name='formPost'
          method='post'
          action='{$url}'
        >
          <input type='hidden' name='RutOtec' value='{$RutOtec}' />
          <input
            type='hidden'
            name='Token'
            value='{$token}'
          />
          <input type='hidden' name='CodSence' value='{$CodigoSence}' />
          <input type='hidden' name='CodigoCurso' value='{$CodigoCurso}' />
          <input type='hidden' name='LineaCapacitacion' value='{$LineaCapacitacion}' />
          <input type='hidden' name='RunAlumno' value='{$RunAlumno}' />
          <input type='hidden' name='IdSesionAlumno' value='{$IdSesionAlumno}' />
          <input type='hidden' name='IdSesionSence' value='{$IdSesionSence}' /></br>
          <input
            type='hidden'
            name='UrlRetoma'
            value='{$URLExito}'
          />
          <input
            type='hidden'
            name='UrlError'
            value='{$URLError}'
          />
          <input type='submit' title='Cerrar sesión Sence' id='btn-sence' value=''/>
        </form>
        <script>
          document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('salir-sence').addEventListener('submit', function(event){
              event.preventDefault();
              document.cookie='solicitud=salir-sence; path=/; max-age=300';
              this.submit();
            });
          });
        </script>
      
        ";

    return $html;
  }
  public static function content()
  {
    if (isset($_COOKIE["solicitud"])) { //Ya salió del sence, mostrar btn iniciar
      SencePublicDatabase::set_session_duration($_COOKIE["IdSesionAlumno"], $_COOKIE["IdSesionSence"]);
      setcookie("solicitud", "", time() - 3600, "/");
      setcookie("IdSesionSence", "", time() - 3600, "/");
      setcookie("IdSesionAlumno", "", time() - 3600, "/");
      setcookie("inicio_temporizador", "", time() - 3600, "/");
      return self::login_sence();
    } elseif (isset($_POST['IdSesionSence'])) { //Recién ingresó sence
      $current_user = wp_get_current_user();
      $form_data = SencePublicDatabase::get_form_sence_data($current_user->user_email);
      $RutOtec = $form_data['rut_otec'];
      $data = array_merge(['rut_otec' => $RutOtec], $_POST);
      SencePublicDatabase::insert_session($data);
      setcookie('inicio_temporizador', time(), time() + 3600, "/");
      setcookie("IdSesionSence", $_POST['IdSesionSence'], time() + 3600, "/");
      setcookie("IdSesionAlumno", $_POST['IdSesionAlumno'], time() + 3600, "/");
      return self::exit_sence($_POST['IdSesionSence']);
    } elseif (isset($_COOKIE["IdSesionSence"])) { //Ya había ingresado sence
      return self::exit_sence();
    } else { //Aún no ingresa sence
      return self::login_sence();
    }
  }
}
