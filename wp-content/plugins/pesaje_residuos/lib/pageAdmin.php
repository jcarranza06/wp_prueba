<?php
global $wpdb;

$sqlObtenerFormularios = "SELECT s.id_envio, s.fecha, q.correo_electronico, q.unidad_generadora, q.edificio,q.numero_celular FROM `{$wpdb->prefix}forms_send` s JOIN `{$wpdb->prefix}forms_responses` r on s.id_envio=r.id_envio 
JOIN (SELECT 
    r.id_envio,
    MAX(CASE WHEN r.id_elemento = 'formulario-respuesta-0-1-0-0' THEN respuesta END) AS correo_electronico,
    MAX(CASE WHEN r.id_elemento = 'formulario-respuesta-0-1-1-0' THEN respuesta END) AS unidad_generadora,
    MAX(CASE WHEN r.id_elemento = 'formulario-respuesta-0-1-2-0' THEN respuesta END) AS edificio,
    MAX(CASE WHEN r.id_elemento = 'formulario-respuesta-0-1-3-0' THEN respuesta END) AS numero_celular,
    MAX(CASE WHEN r.id_elemento = 'formulario-respuesta-1-0-0-0' THEN respuesta END) AS bolsas_pequenas,
    MAX(CASE WHEN r.id_elemento = 'formulario-respuesta-1-0-1-0' THEN respuesta END) AS bolsas_medianas,
    MAX(CASE WHEN r.id_elemento = 'formulario-respuesta-1-0-2-0' THEN respuesta END) AS bolsas_grandes,
    MAX(CASE WHEN r.id_elemento = 'formulario-respuesta-1-1-0-0' THEN respuesta END) AS cantidad_bidones,
    MAX(CASE WHEN r.id_elemento = 'formulario-respuesta-1-2-0-0' THEN respuesta END) AS detalles_bidones
FROM `{$wpdb->prefix}forms_respuestas` r JOIN `{$wpdb->prefix}forms_send` s ON r.id_envio = s.id_envio
WHERE s.`id_formulario`= 3
GROUP BY id_envio) q ON s.id_envio = q.id_envio
WHERE s.`id_formulario`= 3 and r.form_attended = 0;";

$msgFormato="";
if (isset($_POST['btnIniciarRuta'])) {
    
    $json = str_replace('\\', '', $_POST['valoresAMostrarPesaje']);
    //echo ($json);
    $json = escapeshellarg(str_replace('"', '##8#8##8###', $json));

    $pythonScript = 'C:\\Users\\juane\\OneDrive\\Escritorio\\recoleccion insumos\\docRutaRecoleccion.py';
    // Construye el comando asegurándote de escapar la ruta del script de Python
    $command = escapeshellcmd("python \"$pythonScript\" $json 2>&1");
    //echo $command;
    // Ejecuta el comando
    $output = shell_exec($command);
    //echo $output;
    $output = json_decode($output);
    //echo $output;
    $msgFormato = "";
    if ($output->tipe == "success") {
        $url = $output->url;
        $msgFormato = "<a href='$url'>Ver documento</a>";

        $resultados = $wpdb->get_results( "UPDATE {$wpdb->prefix}forms_responses
        SET form_attended = 1
        WHERE id_envio IN (SELECT r.id_envio FROM `{$wpdb->prefix}forms_responses` r JOIN `{$wpdb->prefix}forms_send` s ON r.id_envio=s.id_envio WHERE s.id_formulario=3 AND r.form_attended=0);" );


    } else if ($output->tipe == "error") {
        $msgFormato = "Ha habido un error creando el archivo";
    }
}

$formularios = $wpdb->get_results($sqlObtenerFormularios, ARRAY_A);
if (empty($formularios)) {
    $formularios = array();
}
//var_dump($formularios);

?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<div class="wrap">
    <?php
    echo '<h1 class="wp-heading-inline">' . get_admin_page_title() . '</h1>';
    ?>
    <!--<form method="post">-->
    <!--<input type="text" name="nombreNuevoAlbum">-->
    <!--<input type="text" id="inputOrdenAnterior" class="visibility-none" style="display:none;"
            name="ordenGeneralAnterior"
            value="<?php // echo htmlspecialchars(substr($ordenJson, 1, (strlen($ordenJson) - 2))); ?>">-->
    <form method="post">
        <input type="text" id="valoresAMostrarPesaje" class="visibility-none" style="display:none;"
            name="valoresAMostrarPesaje" value="<?php echo htmlspecialchars(json_encode($formularios)); ?>">
        <button name="btnIniciarRuta" class="page-title-action" onclick="iniciarRuta()">Inicio ruta</button>
    </form>
    <?php echo $msgFormato; ?>

    <!--</form>-->

    <br><br><br>

    <table class="wp-list-table widefat fixed striped pages">
        <thead>
            <th>Id</th>
            <th>Fecha</th>
            <th>Unidad</th>
            <th>Edificio</th>
        </thead>
        <tbody id="contenido_tabla_albumes">
            <?php
            foreach ($formularios as $key => $value) {
                $id = $value["id_envio"];
                $fecha = $value["fecha"];
                $correo = $value["correo_electronico"];
                $unidad = $value["unidad_generadora"];
                $edificio = $value["edificio"];
                $celular = $value["numero_celular"];
                $date = new DateTime($fecha, new DateTimeZone('UTC'));

                // Establecer la zona horaria de destino (Colombia)
                $date->setTimezone(new DateTimeZone('America/Bogota'));

                // Formatear la fecha para mostrarla
                $formattedDate = $date->format('Y-m-d H:i:s');
                echo "
            <tr>
                <td>$id</td>
                <td>$formattedDate</td>
                <td>$unidad</td>
                <td>$edificio</td>
            </tr>
                    ";
            }
            ?>
        </tbody>
    </table>

</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
    crossorigin="anonymous"></script>