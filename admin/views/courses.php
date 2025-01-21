<?php
require_once __DIR__ . '/../SenceAdminDatabase.php';
if (isset($_POST['save-course'])) {
    SenceAdminDatabase::insert_course($_POST);
}
$courses = SenceAdminDatabase::get_courses();


?>


<div class="wrap">
    <h1>CURSOS</h1>
    <button id='btn-add-otec' class='button-primary'>Agregar Curso</button>
    <form method="post">
        <label for="otec">OTEC: </label>
        <select name="otec" id=""></select>
        <input type="submit" value="" class="button-primary">
    </form>
    <!-- 
    <form method="post">
        <table class="form-table">
            <tr>
                <th scope="row">
                    <label for="nombre_curso">Nombre Curso:</label>
                </th>
                <td>
                    <input type="text" name="nombre_curso" class="regular-text">
                </td>
                <th scope="row">
                    <label for="cod_sence">Código Sence:</label>
                </th>
                <td>
                    <input type="text" name="cod_sence" class="regular-text">
                </td>
            </tr>
            <tr>
                <th scope="row">
                    <label for="codigo_curso">Código Curso:</label>
                </th>
                <td>
                    <input type="text" name="codigo_curso" class="regular-text">
                </td>
                <th scope="row">
                    <label for="linea_capacitacion">Línea Capacitación:</label>
                </th>
                <td>
                    <input type="text" name="linea_capacitacion" class="small-text">
                </td>

            </tr>
            <tr>
                <th scope="row">
                    <label for="rut_otec">Rut OTEC:</label>
                </th>
                <td>
                    <input type="text" name="rut_otec" class="regular-text">
                </td>


            </tr>
            <tr>
                <th scope="row">

                </th>
                <td>
                    <input type="submit" name="save-course" value="Guardar" class="button-primary">

                </td>
            </tr>

        </table>
    </form> -->

    <table class="wp-list-table widefat fixed striped pages">
        <thead>
            <th>Rut OTEC</th>
            <th>Código Curso</th>
            <th>Código Sence</th>
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
                $otec = $value['rut_otec'];


                echo "
                                <tr>
                                    <td>$otec</td>
                                    <td>$codigo_curso</td>
                                    <td>$cod_sence</td>
                                    <td>$linea_capacitacion</td>
                                    <td>$nombre</td>
                                </tr>
                            ";
            }

            ?>
        </tbody>
    </table>





    <!--  -->
    <div id="modal-background">
    </div>
    <div id="modal-otec" class="wrap">

        <div id="otec-card">

            <form method="post">
                <table class="form-table">
                    <tr>
                        <th scope="row">
                            <label for="nombre_curso">Nombre Curso:</label>
                        </th>
                        <td>
                            <input type="text" name="nombre_curso" class="regular-text">
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="cod_sence">Código Sence:</label>
                        </th>
                        <td>
                            <input type="text" name="cod_sence" class="regular-text">
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="codigo_curso">Código Curso:</label>
                        </th>
                        <td>
                            <input type="text" name="codigo_curso" class="regular-text">
                        </td>

                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="linea_capacitacion">Línea Capacitación:</label>
                        </th>
                        <td>
                            <input type="text" name="linea_capacitacion" class="small-text">
                        </td>

                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="rut_otec">Rut OTEC:</label>
                        </th>
                        <td>
                            <input type="text" name="rut_otec" class="regular-text">
                        </td>

                    </tr>
                    <tr>
                        <th scope="row">
                        </th>
                        <td>
                            <button id="closeM" class="button">Salir</button>
                            <input type="submit" name="save-course" value="Guardar" class="button-primary">

                        </td>
                    </tr>

                </table>
            </form>
        </div>
    </div>
</div>