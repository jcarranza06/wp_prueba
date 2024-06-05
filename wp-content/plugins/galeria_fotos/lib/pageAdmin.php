<?php
global $wpdb;

/*function update_visibilidad_album()
{
    $ID_ALBUM = 3;
    $visibilidad = false;
    global $wpdb;
    $datos_actualizacion = [
        'visible' => $visibilidad
    ];
    $condiciones = [
        'id' => $ID_ALBUM
    ];
    $wpdb->update("{$wpdb->prefix}ALBUMES", $datos_actualizacion, $condiciones);
    return true;
}update_visibilidad_album();*/

if (isset($_POST['btnCrearAlbum'])) {
    $substring = "\"";
    $stringJsonOrden = $_POST['ordenGeneralAnterior'];
    $ordenGeneralAnterior = json_decode($stringJsonOrden);
    $nombreNuevoAlbum = $_POST['nombreNuevoAlbum'];
    if (!empty($nombreNuevoAlbum)) {
        $datos = [
            'id' => null,
            'nombre' => $nombreNuevoAlbum,
            'orden' => '[]',
            'visible' => 1
        ];
        $insertado = $wpdb->insert("{$wpdb->prefix}ALBUMES", $datos);
        if($insertado){
            $inserted_galeria_id = $wpdb->insert_id;
            array_push($ordenGeneralAnterior, $inserted_galeria_id);
            $datos_actualizacion = [
                'ORDEN' => json_encode($ordenGeneralAnterior),
            ];
            $condiciones = [
                'ID_GALERIA' => 1
            ];
            $wpdb->update("{$wpdb->prefix}ORDEN_GENERAL_GALERIA", $datos_actualizacion, $condiciones);
        }
    }
}

$sqlObtenerOrden = "SELECT `ID_GALERIA`,`ORDEN` FROM `{$wpdb->prefix}ORDEN_GENERAL_GALERIA` LIMIT 1";
$orden = $wpdb->get_results($sqlObtenerOrden, ARRAY_A);
if (empty($orden)) {
    $orden = array();
}else{
    $orden = $orden[0];
    $ordenJson = json_encode($orden['ORDEN']);
}

$sqlObtenerAlbumes = "SELECT `id`,`nombre`,`orden`,`visible` FROM `{$wpdb->prefix}ALBUMES`";
$albumes = $wpdb->get_results($sqlObtenerAlbumes, ARRAY_A);
if (empty($albumes)) {
    $albumes = array();
}
//print_r();
$orden_array = json_decode($orden['ORDEN']);
// Función de comparación personalizada
function comparar($a, $b) {
    global $orden_array;
    $posA = array_search($a["id"], $orden_array);
    $posB = array_search($b["id"], $orden_array);
    return $posA - $posB;
}

// Ordenar los objetos usando la función de comparación personalizada
usort($albumes, 'comparar');

?>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<div class="wrap">
    <?php
    echo '<h1 class="wp-heading-inline">' . get_admin_page_title() . '</h1>';
    ?>
    <form method="post">
        <input type="text" name="nombreNuevoAlbum">
        <input type="text" id="inputOrdenAnterior" class="visibility-none" style="display:none;" name="ordenGeneralAnterior" value="<?php echo htmlspecialchars(substr($ordenJson,1,(strlen($ordenJson)-2))); ?>">
        <button type="submit" name="btnCrearAlbum" class="page-title-action">nuevo album</button>
    </form>

    <br><br><br>

    <!-- Modal -->
    <div class="modal fade" id="ModalFotosGaleria" tabindex="-1" aria-labelledby="modalTittle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTittle"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="text" id="inputNuevaFoto">
                    <button type="button" class="page-title-action" id="btnNuevaFoto"
                        onclick="agregarFotoAAlbum()">Agregar Foto</button>
                    <table class="table" id="tabla_fotos_modal">
                        <tr>
                            <td scope="col">
                                <img class="imageForGaleryModalCell"
                                    src="https://www.ecestaticos.com/imagestatic/clipping/cdb/fc2/cdbfc2ba5bcab684850932a1b5d71330/la-nasa-escoge-una-foto-espanola-como-su-imagen-del-dia.jpg?mtime=1432586964"
                                    alt="">
                            </td>
                            <td scope="col">
                                <textarea class="form-control" aria-label="With textarea"></textarea>
                            </td>
                            <td scope="col">
                                <button class="btn-primary">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                        class="bi bi-arrow-return-right" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd"
                                            d="M1.5 1.5A.5.5 0 0 0 1 2v4.8a2.5 2.5 0 0 0 2.5 2.5h9.793l-3.347 3.346a.5.5 0 0 0 .708.708l4.2-4.2a.5.5 0 0 0 0-.708l-4-4a.5.5 0 0 0-.708.708L13.293 8.3H3.5A1.5 1.5 0 0 1 2 6.8V2a.5.5 0 0 0-.5-.5z" />
                                    </svg>
                                </button>
                                <button class="btn-primary arrow-movement arrow-down">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                        class="bi bi-arrow-up" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd"
                                            d="M8 15a.5.5 0 0 0 .5-.5V2.707l3.146 3.147a.5.5 0 0 0 .708-.708l-4-4a.5.5 0 0 0-.708 0l-4 4a.5.5 0 1 0 .708.708L7.5 2.707V14.5a.5.5 0 0 0 .5.5z" />
                                    </svg>
                                </button>
                                <button class="btn-primary arrow-movement arrow-up">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                        class="bi bi-arrow-up" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd"
                                            d="M8 15a.5.5 0 0 0 .5-.5V2.707l3.146 3.147a.5.5 0 0 0 .708-.708l-4-4a.5.5 0 0 0-.708 0l-4 4a.5.5 0 1 0 .708.708L7.5 2.707V14.5a.5.5 0 0 0 .5.5z" />
                                    </svg>
                                </button>
                                <button class="btn-primary arrow-movement arrow-down">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                        class="bi bi-trash" viewBox="0 0 16 16">
                                        <path
                                            d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6Z" />
                                        <path
                                            d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1ZM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118ZM2.5 3h11V2h-11v1Z" />
                                    </svg>
                                </button>
                            </td>
                        </tr>
                    </table>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <table class="wp-list-table widefat fixed striped pages">
        <thead>
            <th>Id</th>
            <th>Nombre</th>
            <th></th>
        </thead>
        <tbody id="contenido_tabla_albumes">
            <?php
            foreach ($albumes as $key => $value) {
                $id = $value["id"];
                $nombre = $value['nombre'];
                $orden = $value['orden'];
                $visible = $value['visible'];
                $textVisible = $visible ? 'visible':'no visible';
                echo "
            <tr>
                <td>$id</td>
                <td>$nombre</td>
                <td>
                    <button class='page-title-action' type='button' data-bs-toggle='modal' data-bs-target='#ModalFotosGaleria'
                        onclick='setModal($id,\"$nombre\", \"$orden\", $visible)'>Editar</button>
                    <button class='page-title-action' onclick='deleteAlbum($id)'>Eliminar</button>
                    <button class='page-title-action' onclick='moveAlbumPosition($id,true)'>Bajar</button>
                    <button class='page-title-action' onclick='moveAlbumPosition($id,false)'>Subir</button>
                    <button class='page-title-action' onclick='changeAlbumVisibility($id,$visible)'>$textVisible</button>
                </td>
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