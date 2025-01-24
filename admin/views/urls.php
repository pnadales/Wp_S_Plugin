<?php
require_once __DIR__ . '/../SenceAdminDatabase.php';
if (isset($_POST['save-urls'])) {
    SenceAdminDatabase::insert_url($_POST);
} elseif (isset($_POST['update-urls'])) {
    SenceAdminDatabase::update_url($_POST);
}
// elseif (isset($_POST['search-otec'])) {
//     $urls = SenceAdminDatabase::get_url_by_otec($_POST['otec']);
// }
// if (!isset($urls)) {
//     $urls = array();
// }
$urls = SenceAdminDatabase::get_urls();
$otec = SenceAdminDatabase::get_otec();


?>
<script>
    const page = 'urls';
    const modal_data = {};
</script>

<div class="wrap">
    <h1>URLs</h1>
    <table class="wp-list-table widefat fixed striped pages">
        <thead>
            <th>Rut OTEC</th>
            <th>URL Éxito</th>
            <th>URL Error</th>
            <th></th>
        </thead>
        <tbody id="the-list">
            <?php
            foreach ($urls as $key => $value) {
                $rut_otec = $value['rut_otec'];
                $url_exito = $value['url_exito'];
                $url_error = $value['url_error'];



                echo "
                <script>
                modal_data['$rut_otec']={
                    rut_otec:'$rut_otec',
                    url_exito:'$url_exito',
                    url_error:'$url_error'
                    };
                </script>  
                                <tr>
                                    <td>$rut_otec</td>
                                    <td><a href='$url_exito' target='_blank' rel='noopener noreferrer'>$url_exito</a></td>
                                    <td><a href='$url_error' target='_blank' rel='noopener noreferrer'>$url_error</a></td>
                                    <td>
                                    <button class='btn-edit button-primary' data-id='$rut_otec'>Editar</button>
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
                            <input type="text" name="rut_otec" class="regular-text my-inputs">

                        </td>

                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="codigo_curso">URL Éxito:</label>
                        </th>
                        <td>
                            <input type="url" name="url_exito" class="regular-text my-inputs">
                        </td>

                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="nombre_curso">URL Error:</label>
                        </th>
                        <td>
                            <input type="url" name="url_error" class="regular-text my-inputs">
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