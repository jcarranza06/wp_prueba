<?php
global $wpdb;

$sqlObtenerFormularios = "SELECT `id_formulario`,`json_formulario` FROM `{$wpdb->prefix}custom_forms`";
$formularios = $wpdb->get_results($sqlObtenerFormularios, ARRAY_A);
if (empty($formularios)) {
    $formularios = array();
}
var_dump($formularios);

?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<div class="wrap">
    <?php
    echo '<h1 class="wp-heading-inline">' . get_admin_page_title() . '</h1>';
    ?>
    <!--<form method="post">-->
        <input type="text" name="nombreNuevoAlbum">
        <!--<input type="text" id="inputOrdenAnterior" class="visibility-none" style="display:none;"
            name="ordenGeneralAnterior"
            value="<?php // echo htmlspecialchars(substr($ordenJson, 1, (strlen($ordenJson) - 2))); ?>">-->
        <button name="btnCrearAlbum" class="page-title-action" onclick="insertForm()">nuevo formulario</button>
    <!--</form>-->

    <br><br><br>
    <div>

        <?php
        foreach ($formularios as $key => $value) {
            $id = $value["id_formulario"];
            $json_formulario = $value["json_formulario"];
            
            echo "
            <div>
            <h2> formulario $id</h2>
        </div>
        <textarea class='form-control' id='inputFormularioJson-$id' rows='25' >$json_formulario</textarea>
        <br>
        <div>
            <button onclick='modifyForm($id)'>Modificar</button>
            <button onclick='deleteForm($id)'>Borrar</button>
        </div>
                    ";
        }
        ?>

    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
    crossorigin="anonymous"></script>