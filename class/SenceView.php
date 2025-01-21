<?php

require_once 'SencePublicDatabase.php';

class SenceView
{

  public function Obtener($user_id)
  {
    global $wpdb;
    $tabla = "{$wpdb->prefix}usuarios";
    $query = "SELECT * FROM $tabla WHERE user_id='$user_id'";
    $datos = $wpdb->get_results($query, ARRAY_A);
    if (empty($datos)) {
      $datos = array();
    }
    return $datos[0];
  }

  public function content()
  {

    $current_user = wp_get_current_user();

    if ($current_user->ID) {
      //   echo 'ID de usuario: ' . $current_user->ID . '<br>';
      //   echo 'Nombre: ' . $current_user->display_name . '<br>';
      //   echo 'Correo electrónico: ' . $current_user->user_email . '<br>';

      // var_dump(SencePublicDatabase::get_form_sence_data($current_user->user_email));
      $form_data = SencePublicDatabase::get_form_sence_data($current_user->user_email);
    } else {
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
    $IdSesionAlumno = $form_data['run_alumno'];
    $URLExito = 'https://www.google.com/';
    $URLError = 'https://www.youtube.com/';

    $html = " 
        <style>
  #btn-sence {
    border: none;
    background-color: #113b6a;
    background-image: url(https://www.arcgis.com/sharing/rest/content/items/7ed49902db8344289c86924179818846/resources/Logo_sence_blanco-02%205000x2289.png);
    background-size: contain;
    background-repeat: no-repeat;
    background-position: center;
    width: 11rem;
    height: 3rem;
  }
</style>
        <form
      name='formPost'
      method='post'
      action='{$url}'
    >
      <!-- <label>RutOtec</label> -->
      <input type='hidden' name='RutOtec' value='{$RutOtec}' />
      <!-- <label>Token</label> -->
      <input
        type='hidden'
        name='Token'
        value='{$token}'
      />
      <!-- <label>CodSence</label> -->
      <input type='hidden' name='CodSence' value='{$CodigoSence}' />
      <!-- <label>CodigoCurso</label> -->
      <input type='hidden' name='CodigoCurso' value='{$CodigoCurso}' />
      <!-- <label>LineaCapacitacion</label> -->
      <input type='hidden' name='LineaCapacitacion' value='{$LineaCapacitacion}' />
      <!-- <label>RunAlumno</label> -->
      <input type='hidden' name='RunAlumno' value='{$RunAlumno}' />
      <!-- <label>IdSesionAlumno</label> -->
      <input type='hidden' name='IdSesionAlumno' value='{$IdSesionAlumno}}' />
      <!-- <label>UrlRetoma</label> -->
      <input
        type='hidden'
        name='UrlRetoma'
        value='{$URLExito}'
      />
      <!-- <label>UrlError</label> -->
      <input
        type='hidden'
        name='UrlError'
        value='{$URLError}'
      />
      <input type='submit' id='btn-sence' value=''/>
    </form>";

    return $html;
  }
}
