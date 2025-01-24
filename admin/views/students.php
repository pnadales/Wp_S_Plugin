<?php
require_once __DIR__ . '/../SenceAdminDatabase.php';
if ((!isset($_GET['rut_otec']) or !isset($_GET['codigo_curso']))
    and (!isset($_POST['rut_otec']) or !isset($_POST['codigo_curso']))
) {
    die("No access");
}

$rut_otec = isset($_GET['rut_otec']) ? $_GET['rut_otec'] : $_POST['rut_otec'];
$codigo_curso = isset($_GET['codigo_curso']) ? $_GET['codigo_curso'] : $_POST['codigo_curso'];

if (isset($_POST['save-student'])) {
    SenceAdminDatabase::insert_user($_POST);
    SenceAdminDatabase::insert_user_course($_POST);
}
// elseif (isset($_POST['update-course'])) {
//     SenceAdminDatabase::update_course($_POST);
//     $courses = SenceAdminDatabase::get_courses_by_otec($_POST['rut_otec']);
// } 

$students = SenceAdminDatabase::get_users_by_course($rut_otec, $codigo_curso);

?>
<script>
    const page = 'student';
    const modal_data = {};
</script>

<div class="wrap">

    <h1><strong>Alumnos</strong></h1>
    <h2>CURSO:</h2>
    <h3>Rut OTEC: <?php echo $rut_otec ?></h3>
    <h3>Código curos: <?php echo $codigo_curso ?></h3>
    <button id='btn-add' class='button-primary'>Agregar Alumno</button>


    <table class="wp-list-table widefat fixed striped pages">
        <thead>
            <th>RUN</th>
            <th>Correo</th>
            <th>Apellidos</th>
            <th>Nombres</th>
        </thead>
        <tbody id="the-list">
            <?php
            foreach ($students as $key => $value) {
                $run = $value['run_alumno'];
                $correo = $value['correo_alumno'];
                $apellidos = $value['apellidos'];
                $nombres = $value['nombres'];


                echo "
                <script>
                modal_data['$run']={
                    run_alumno: $run ,
                    correo_alumno :$correo ,
                    apellidos:$apellidos,
                    nombres: $nombres
                    };
                </script>  
                                <tr>
                                    <td>$run</td>
                                    <td>$correo</td>
                                    <td>$apellidos</td>
                                    <td>$nombres</td>
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
                <input type="hidden" name="rut_otec" value="<?php echo $rut_otec ?>">
                <input type="hidden" name="codigo_curso" value="<?php echo $codigo_curso ?>">
                <table class="form-table">
                    <tr>
                        <th scope="row">
                            <label for="rut_otec">Run:</label>
                        </th>
                        <td>
                            <input type="text" name="run_alumno" class="regular-text aux-input">

                        </td>

                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="codigo_curso">Correo:</label>
                        </th>
                        <td>
                            <input type="email" name="correo_alumno" class="regular-text">
                        </td>

                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="nombre_curso">Nombres:</label>
                        </th>
                        <td>
                            <input type="text" name="nombres" class="regular-text">
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="cod_sence">Apellidos:</label>
                        </th>
                        <td>
                            <input type="text" name="apellidos" class="regular-text">
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