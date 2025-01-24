<?php
require_once __DIR__ . '/../SenceAdminDatabase.php';

//Save OTEC data
if (isset($_POST['save-otec'])) {
    SenceAdminDatabase::insert_otec($_POST);
    SenceAdminDatabase::insert_url($_POST['rut_otec']);
} elseif (isset($_POST['update-otec'])) {
    SenceAdminDatabase::update_otec($_POST);
}
$res_otec = SenceAdminDatabase::get_otec();
?>
<script>
    const page = 'otec';
    const modal_data = {};
</script>


<div class="wrap">

    <h1>Administrar OTECs</h1>
    <button id='btn-add' class='button-primary'>Agregar OTEC</button>

    <hr>

    <table class="wp-list-table widefat fixed striped pages">
        <thead>
            <th>Rut OTEC</th>
            <th>Nombre OTEC</th>
            <th>Token</th>
            <th></th>
        </thead>
        <tbody id="the-list">
            <?php
            foreach ($res_otec as $key => $value) {
                $rut_otec = $value['rut_otec'];
                $nombre_otec = $value['nombre_otec'];
                $token = $value['token'];


                echo "
            <script>
            modal_data['$rut_otec']={rut_otec:'$rut_otec', nombre_otec:'$nombre_otec',token:'$token'};
            </script>       
            <tr>
            <td>$rut_otec</td>
            <td>$nombre_otec</td>
            <td>$token</td>
            <td>
            <button class='btn-edit button-primary' data-id='$rut_otec'>Editar</button>
            <button class='btn-delete-otec button-secondary' data-id='$rut_otec'>Eliminar</button>
            </td>
            </tr>
            ";
            }

            ?>
        </tbody>
    </table>

    <!-- MODAL -->


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
                            <input id="rut_otec" type="text" name="rut_otec" class="regular-text my-inputs">
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="nombre_otec">Nombre OTEC:</label>
                        </th>
                        <td>
                            <input id="nombre_otec" type="text" name="nombre_otec" class="regular-text my-inputs">
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="token">Token:</label>
                        </th>
                        <td>
                            <input id="token" type="text" name="token" class="regular-text my-inputs">
                        </td>

                    </tr>
                    <tr>
                        <th scope="row">
                        </th>
                        <td>
                            <button id="closeM" class="button">Salir</button>
                            <input id="submit-modal" type="submit" name="save-otec" value="Guardar" class="button-primary">

                        </td>
                    </tr>

                </table>
            </form>
        </div>
    </div>
</div>