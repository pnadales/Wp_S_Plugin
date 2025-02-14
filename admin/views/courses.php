<?php
require_once __DIR__ . '/../SenceAdminDatabase.php';
if (isset($_POST['save-course'])) {
    SenceAdminDatabase::insert_course($_POST);
    $courses = SenceAdminDatabase::get_courses_by_otec($_POST['rut_otec']);
    $current_otec = $_POST['rut_otec'];
} elseif (isset($_POST['update-course'])) {
    SenceAdminDatabase::update_course($_POST);
    $courses = SenceAdminDatabase::get_courses_by_otec($_POST['rut_otec']);
    $current_otec = $_POST['rut_otec'];
} elseif (isset($_POST['search-otec'])) {
    $courses = SenceAdminDatabase::get_courses_by_otec($_POST['otec']);
    $current_otec = $_POST['otec'];
}
if (!isset($courses)) {
    $courses = array();
}
$otec = SenceAdminDatabase::get_otec();


?>
<script>
    const page = 'course';
    const modal_data = {};
</script>

<div class="wrap">
    <h1>CURSOS</h1>
    <button id='btn-add' class='button-primary'>Agregar Curso</button>
    <form method="post">
        <label for="otec">OTEC: </label>
        <select name="otec">
            <option value="" selected disabled>Selecciona OETC</option>
            <?php
            foreach ($otec as $key => $value) {
                $rut_otec = $value['rut_otec'];
                $selected = isset($current_otec) ? ($current_otec == $rut_otec ? 'selected' : '') : '';
                echo "<option value='$rut_otec' $selected>$rut_otec</option>";
            }
            ?>
        </select>
        <input type="submit" value="Listar" name="search-otec" class="button-primary">
    </form>

    <table class="wp-list-table widefat fixed striped pages">
        <thead>
            <th>Rut OTEC</th>
            <th>Código Curso</th>
            <th>Código Sence</th>
            <th>Línea Capacitación</th>
            <th>Nombre Curso</th>
            <th></th>
            <th></th>
            <th></th>
        </thead>
        <tbody id="the-list">
            <?php
            foreach ($courses as $key => $value) {
                $rut_otec = $value['rut_otec'];
                $codigo_curso = $value['codigo_curso'];
                $cod_sence = $value['cod_sence'];
                $linea_capacitacion = $value['linea_capacitacion'];
                $nombre = $value['nombre'];
                $studentsUrl = admin_url('admin.php?page=registro-asistencia-sence-bn%2Fadmin%2Fviews%2Fstudents.php');


                echo "
                <script>
                modal_data['$rut_otec/$codigo_curso']={
                    rut_otec:'$rut_otec',
                    codigo_curso:'$codigo_curso',
                    cod_sence:'$cod_sence',
                    linea_capacitacion:'$linea_capacitacion',
                    nombre:'$nombre'
                    };
                </script>  
                                <tr>
                                    <td>$rut_otec</td>
                                    <td>$codigo_curso</td>
                                    <td>$cod_sence</td>
                                    <td>$linea_capacitacion</td>
                                    <td>$nombre</td>
                                    <td>
                                    <button class='btn-edit button-primary' data-id='$rut_otec/$codigo_curso'>Editar</button>
                                    </td>
                                    <td>
                                    <a href='$studentsUrl&rut_otec=$rut_otec&codigo_curso=$codigo_curso' class='button-primary'>Alumnmos</a>
                                    </td>
                                    <td>
                                    <button class='btn-delete button-secondary' data-id='$rut_otec/$codigo_curso'>Eliminar</button>
                                    </td>
                                </tr>
                            ";
            }

            ?>
        </tbody>
    </table>





    <!--  -->
    <div id="modal-background">
    </div>
    <div id="modal" class="wrap">

        <div id="modal-card">

            <form method="post">
                <table class="form-table">
                    <tr>
                        <th scope="row">
                            <label for="rut_otec">Rut OTEC:</label>
                        </th>
                        <td>
                            <input type="text" name="rut_otec" class="regular-text aux-input my-inputs">
                            <select class="modal-select" name="rut_otec">
                                <?php
                                foreach ($otec as $key => $value) {
                                    $rut_otec = $value['rut_otec'];
                                    echo "<option value='$rut_otec'>$rut_otec</option>";
                                }
                                ?>
                            </select>
                        </td>

                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="codigo_curso">Código Curso:</label>
                        </th>
                        <td>
                            <input type="text" name="codigo_curso" class="regular-text my-inputs">
                        </td>

                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="nombre_curso">Nombre Curso:</label>
                        </th>
                        <td>
                            <input type="text" name="nombre" class="regular-text my-inputs">
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="cod_sence">Código Sence:</label>
                        </th>
                        <td>
                            <input type="text" name="cod_sence" class="regular-text my-inputs">
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="linea_capacitacion">Línea Capacitación:</label>
                        </th>
                        <td>
                            <select class="modal-select" name="linea_capacitacion">
                                <option value="1">1</option>
                                <option value="3">3</option>
                                <option value="6">6</option>
                            </select>
                        </td>

                    </tr>
                    <tr>
                        <th scope="row">
                        </th>
                        <td>
                            <button id="closeM" class="button">Salir</button>
                            <input id="submit-modal" type="submit" name="save-course" value="Guardar" class="button-primary">

                        </td>
                    </tr>

                </table>
            </form>
        </div>
    </div>
</div>