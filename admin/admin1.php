<?php
require_once 'SenceAdminDatabase.php';

//Save OTEC data
if (isset($_POST['save-otec'])) {
    SenceAdminDatabase::insert_otec($_POST);
}
if (isset($_POST['save-course'])) {
    SenceAdminDatabase::insert_course($_POST);
}


?>

<h1>Plugin SENCE</h1>
<hr class="sep">
<h3>Datos OTEC</h3>

<?php

//Get data
$res_otec = SenceAdminDatabase::get_otec();
$courses = SenceAdminDatabase::get_courses();
// var_dump($res_otec);

if (!count($res_otec)) {

?>
    <form method="post">
        <label for="rut_otec">Rut Otec:</label>
        <input type="text" name="rut_otec">
        <label for="nombre_otec">Nombre Otec:</label>
        <input type="text" name="nombre_otec">
        <label for="token">Token:</label>
        <input type="text" name="token">
        <input type="submit" name="save-otec" value="Guardar">
    </form>
<?php
} else {
?>
    <h4>Rut Otec:</h4>
    <p><?php echo $res_otec[0]['rut_otec'] ?></p>
    <h4>Nombre Otec:</h4>
    <p><?php echo $res_otec[0]['nombre_otec'] ?></p>
    <h4>Token:</h4>
    <p><?php echo $res_otec[0]['token'] ?></p>


    <hr class="sep">

    <form method="post">
        <h5>Cursos</h5>
        <label for="cod_sence">Código Sence:</label>
        <input type="text" name="cod_sence">
        <label for="codigo_curso">Cógigo Curso:</label>
        <input type="text" name="codigo_curso">
        <label for="linea_capacitacion">Línea Capacitación:</label>
        <input type="text" name="linea_capacitacion">
        <label for="nombre_curso">Nombre Curso:</label>
        <input type="text" name="nombre_curso">
        <input type="submit" name="save-course" value="Guardar">
    </form>

    <table class="wp-list-table">
        <thead>
            <th>Código Sence</th>
            <th>Código Curso</th>
            <th>Línea Capacitación</th>
            <th>Nombre Curso</th>
        </thead>
        <tbody id="the-list">
            <?php
            foreach ($courses as $key => $value) {
                $cod_sence = $value['cod_sence'];
                $codigo_curso = $value['codigo_curso'];
                $linea_capacitacion = $value['linea_capacitacion'];
                $nombre = $value['nombre'];

                echo "
                                <tr>
                                    <td>$cod_sence</td>
                                    <td>$codigo_curso</td>
                                    <td>$linea_capacitacion</td>
                                    <td>$nombre</td>
                                </tr>
                            ";
            }

            ?>
        </tbody>
    </table>

<?php
}
?>