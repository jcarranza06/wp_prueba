<?php

class galeria
{
    public function getOrdenGeneral()
    {
        global $wpdb;
        $sqlObtenerOrdenGeneral = "SELECT ORDEN FROM `{$wpdb->prefix}orden_general_galeria` WHERE ID_GALERIA=1;";
        $ordenGeneral = $wpdb->get_results($sqlObtenerOrdenGeneral, ARRAY_A);
        if (empty($ordenGeneral)) {
            $ordenGeneral = array();
        }
        return $ordenGeneral;
    }
    public function getAlbumes()
    {
        global $wpdb;
        $sqlObtenerAlbumes = "SELECT id, nombre, orden, f.ID_FOTO_ALBUM ,f.DIRECCION_FOTO AS ID_IMG_PORTADA FROM `{$wpdb->prefix}albumes` JOIN `{$wpdb->prefix}fotos_album` as f on CAST(SUBSTRING_INDEX(SUBSTRING_INDEX(orden, ',', 1), '[', -1) AS INT) = f.ID_FOTO_ALBUM where visible;";
        $albumes = $wpdb->get_results($sqlObtenerAlbumes, ARRAY_A);
        if (empty($albumes)) {
            $albumes = array();
        }
        return $albumes;
    }

    public function getHTMLBody()
    {
        $svgClose = "
            <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-x-lg' viewBox='0 0 16 16'>
                <path d='M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8 2.146 2.854Z'/>
            </svg>
        ";
        $modal = "
            <div id='dark-layer' onclick='closeModal()'></div>
            <dialog class='' id='modalAlbumGaleria' tabindex='-1' aria-labelledby='modalAlbumGaleriaLabel' aria-hidden='true'>
                <div class=''>
                    <div class='modalContent'>
                        <div class='modalHeader'>
                            <h1 class='modal-title fs-5' id='modalAlbumGaleriaLabel'></h1>
                            <button type='button' class='btn-close-modal' data-bs-dismiss='modal' aria-label='Close' onclick='closeModal()'>$svgClose</button>
                        </div>
                        <div class='modalBody' id='modalContentAlbumGaleria'>
                        </div>
                        <div class='modalFooter' id='modal_footer_galeria'>
                            <button type='button' class='btn btn-secondary' data-bs-dismiss='modal' onclick='closeModal()'>Cerrar</button>
                        </div>
                    </div>
                </div>
            </dialog>
        ";

        $HTMLContainer = "
            <div class='galeria-HTMLContainer horizontal-row'>
                <div class='row-images vertical-row row-1' id='album_row_1'>
                </div>
                <div class='row-images vertical-row row-2' id='album_row_2'>
                </div>
                <div class='row-images vertical-row row-3' id='album_row_3'>
                </div>
            </div>
        ";

        $HTMLBodyStructure = "
            
            <div class='galeria-BodyStructure'>
                $HTMLContainer
                $modal
            </div>
            
        ";

        return $HTMLBodyStructure;
    }
}

?>

