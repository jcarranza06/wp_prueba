<?php
/*
Plugin Name: galeria_fotos
Plugin URI: https://mail.google.com/
Description: Plugin desde el cual se administra la galeria de fotos general de la pagina
Version: 0.0.1
*/

require_once dirname(__FILE__) . '/class/galeria.class.php';

function Activar()
{
    global $wpdb;

    //al activar el plugin automaticamente se crea la tabla de albumes y de fotos
    $sqlCrearTablaAlbumes = "CREATE TABLE IF NOT EXISTS `{$wpdb->prefix}ALBUMES` 
                            (`id` INT NOT NULL AUTO_INCREMENT ,
                            `ID_GALERIA` INT NOT NULL ,
                            `nombre` VARCHAR(100) NOT NULL ,
                            `orden` VARCHAR(600) NOT NULL ,
                            `visible` BOOLEAN NOT NULL ,
                             PRIMARY KEY (`id`)) ENGINE = InnoDB;";
    $sqlCrearTablaFotos = "CREATE TABLE IF NOT EXISTS `{$wpdb->prefix}FOTOS_ALBUM` 
                            (`ID_FOTO_ALBUM` INT NOT NULL AUTO_INCREMENT , 
                            `ID_ALBUM` INT NOT NULL , `DIRECCION_FOTO` VARCHAR(2000) NOT NULL , 
                            `DESCRIPCION_FOTO` VARCHAR(600) NOT NULL ,
                            PRIMARY KEY (`ID_FOTO_ALBUM`)) ENGINE = InnoDB;";
    $sqlCrearTablaOrden = "CREATE TABLE IF NOT EXISTS `{$wpdb->prefix}ORDEN_GENERAL_GALERIA` 
                            (`ID_GALERIA` INT NOT NULL AUTO_INCREMENT ,
                            `ORDEN` VARCHAR(2000) NOT NULL ,
                            PRIMARY KEY (`ID_GALERIA`)) ENGINE = InnoDB;";
    $sqlInsertarOrdenAlbumPorDefecto = "INSERT INTO `{$wpdb->prefix}ORDEN_GENERAL_GALERIA` 
                                        (`ID_GALERIA`, `ORDEN`) VALUES (NULL, '[]')";
    $wpdb->query($sqlCrearTablaAlbumes);
    $wpdb->query($sqlCrearTablaFotos);
    $wpdb->query($sqlCrearTablaOrden);
    $wpdb->query($sqlInsertarOrdenAlbumPorDefecto);
}

function Desactivar()
{
    /*flush_rewrite_rules();*/
}

register_activation_hook(__FILE__, 'Activar');
register_deactivation_hook(__FILE__, 'Desactivar');

add_action('admin_menu', 'CrearMenuGaleria');

function CrearMenuGaleria()
{
    add_menu_page(
        'Galeria General',
        //titulo pagina
        'Galeria General',
        //titulo menu
        'manage_options', //capbility
        plugin_dir_path(__FILE__) . 'lib/pageAdmin.php',
        //slug
        null, //'MostrarAdminGaleria', // llamada al contenido 
        plugin_dir_url(__FILE__) . 'img/iconoGaleria.png',
        // imagen/icono barra
        '5' //posicion menu 
    );
}
//se agrega el script js a la pagina
function agregarJs($hook)
{
    if ($hook != 'galeria_fotos/lib/pageAdmin.php') {
        return;
    }
    wp_enqueue_script('JsAdminGaleria', plugins_url('js/admin_galeria.js', __FILE__));
    wp_localize_script('JsAdminGaleria', 'SolicitudesBack', [
        'urlBack' => admin_url('admin-ajax.php'),
        'securityToken' => wp_create_nonce('token')
    ]);
}
add_action('admin_enqueue_scripts', 'agregarJs');

function agregarCss($hook)
{
    if ($hook != 'galeria_fotos/lib/pageAdmin.php') {
        return;
    }
    wp_enqueue_style('CssAdminGaleria', plugins_url('css/admin_galeria_style.css', __FILE__));
}
add_action('admin_enqueue_scripts', 'agregarCss');

function eliminar_album_BD()
{
    $nonce = $_POST['nonce'];
    if (!wp_verify_nonce($nonce, 'token')) {
        die();
    }
    $id_album = $_POST['id_album'];
    global $wpdb;
    $wpdb->delete("{$wpdb->prefix}FOTOS_ALBUM", array('ID_ALBUM' => $id_album));
    $wpdb->delete("{$wpdb->prefix}ALBUMES", array('id' => $id_album));
    return true;
}
add_action('wp_ajax_peticionEliminarAlbum', 'eliminar_album_BD');

function getFotos_Album()
{
    $id_album = $_POST['id_album'];
    global $wpdb;
    $sqlObtenerFotosAlbum = $wpdb->prepare("SELECT `ID_FOTO_ALBUM`,`DIRECCION_FOTO`,`ID_ALBUM`,`DESCRIPCION_FOTO` FROM `{$wpdb->prefix}FOTOS_ALBUM` WHERE `ID_ALBUM` = %d", $id_album);
    $fotos = $wpdb->get_results($sqlObtenerFotosAlbum, ARRAY_A);
    header('Content-Type: application/json');
    echo json_encode($fotos);
    // Detener la ejecución de WordPress
    wp_die();
}
add_action('wp_ajax_nopriv_peticionFotosAlbum', 'getFotos_Album');
add_action('wp_ajax_peticionFotosAlbum', 'getFotos_Album');

function get_Albumes_DB()
{
    global $wpdb;
    $sqlObtenerAlbumes = "SELECT `id`,`nombre`,`orden`,`visible` FROM `{$wpdb->prefix}ALBUMES`";
    $albumes = $wpdb->get_results($sqlObtenerAlbumes, ARRAY_A);
    if (empty($albumes)) {
        $albumes = array();
    }
    header('Content-Type: application/json');
    echo json_encode($albumes);
    // Detener la ejecución de WordPress
    wp_die();
}
add_action('wp_ajax_peticionAlbumes', 'get_Albumes_DB');

function add_Fotos_Album()
{
    $id_album = $_POST['id_album'];
    $direccion_foto = $_POST['direccion_foto'];
    $orden_fotos = json_decode($_POST['orden_fotos']);
    global $wpdb;
    $datos = [
        'ID_FOTO_ALBUM' => null,
        'ID_ALBUM' => $id_album,
        'DIRECCION_FOTO' => $direccion_foto,
        'DESCRIPCION_FOTO' => ''
    ];
    $resultadoInsertFoto = $wpdb->insert("{$wpdb->prefix}FOTOS_ALBUM", $datos);

    if ($resultadoInsertFoto) {
        $inserted_foto_id = $wpdb->insert_id;
        array_push($orden_fotos, $inserted_foto_id);
        $datos_actualizacion = [
            'orden' => json_encode($orden_fotos),
        ];
        $condiciones = [
            'id' => $id_album
        ];
        $wpdb->update("{$wpdb->prefix}ALBUMES", $datos_actualizacion, $condiciones);
        header('Content-Type: application/json');
        echo json_encode($orden_fotos);
    } else {
        header('Content-Type: application/json');
        echo json_encode([0, $id_album, $direccion_foto, $orden_fotos]);
    }
    wp_die();
    return;
}
add_action('wp_ajax_peticionAddFotosAlbum', 'add_Fotos_Album');

function delete_Foto_Album()
{
    $id_album = $_POST['id_album'];
    $id_foto = $_POST['id_foto'];
    $orden_fotos = json_decode($_POST['orden_fotos']);
    global $wpdb;

    $resultadoInsertFoto = $wpdb->delete("{$wpdb->prefix}FOTOS_ALBUM", array('ID_FOTO_ALBUM' => $id_foto));

    if ($resultadoInsertFoto) {
        $indiceAEliminar = array_search($id_foto, $orden_fotos); // Buscar el índice del número en el arreglo
        if ($indiceAEliminar !== false) {
            unset($orden_fotos[$indiceAEliminar]); // Eliminar el número del arreglo
            $orden_fotos = array_values($orden_fotos);
        }
        $datos_actualizacion = [
            'orden' => json_encode($orden_fotos),
        ];
        $condiciones = [
            'id' => $id_album
        ];
        $wpdb->update("{$wpdb->prefix}ALBUMES", $datos_actualizacion, $condiciones);
    }
    return true;
}
add_action('wp_ajax_peticionDeleteFotoAlbum', 'delete_Foto_Album');

function update_foto()
{
    $id_foto = $_POST['id_foto'];
    $nueva_direccion_foto = $_POST['nueva_direccion_foto'];
    $nueva_descripcion_foto = $_POST['nueva_descripcion_foto'];
    global $wpdb;
    $datos_actualizacion = [
        'DIRECCION_FOTO' => $nueva_direccion_foto,
        'DESCRIPCION_FOTO' => $nueva_descripcion_foto
    ];
    $condiciones = [
        'ID_FOTO_ALBUM' => $id_foto
    ];
    $wpdb->update("{$wpdb->prefix}FOTOS_ALBUM", $datos_actualizacion, $condiciones);
    return true;
}
add_action('wp_ajax_updateFotoAlbum', 'update_foto');

function update_orden_album()
{
    $id_album = $_POST['id_album'];
    $nuevo_orden = $_POST['nuevo_orden'];
    global $wpdb;
    $datos_actualizacion = [
        'orden' => $nuevo_orden,
    ];
    $condiciones = [
        'id' => $id_album
    ];
    $wpdb->update("{$wpdb->prefix}ALBUMES", $datos_actualizacion, $condiciones);
    return true;
}
add_action('wp_ajax_updateOrdenAlbum', 'update_orden_album');

function update_orden_galeria()
{
    $stringJsonOrden = $_POST['ordenGeneralAnterior'];
    global $wpdb;
    $datos_actualizacion = [
        'ORDEN' => $stringJsonOrden
    ];
    $condiciones = [
        'ID_GALERIA' => 1
    ];
    $wpdb->update("{$wpdb->prefix}ORDEN_GENERAL_GALERIA", $datos_actualizacion, $condiciones);
    return true;
}
add_action('wp_ajax_updateOrdenGaleria', 'update_orden_galeria');

function update_visibilidad_album()
{
    $ID_ALBUM = $_POST['ID_ALBUM'];
    $visibilidad = $_POST['visibilidad'];
    $bool = $visibilidad === 'true' ? true : false;
    global $wpdb;
    $datos_actualizacion = [
        'visible' => $bool
    ];
    $condiciones = [
        'id' => $ID_ALBUM
    ];
    $wpdb->update("{$wpdb->prefix}ALBUMES", $datos_actualizacion, $condiciones);
    return true;
}
add_action('wp_ajax_updateVisibilidadAlbum', 'update_visibilidad_album');

//shortcode galeria 
function imprimirGaleria($atts)
{
    wp_enqueue_style('CssShortcodeGaleria', plugins_url('css/shortcode_galeria_style.css', __FILE__));
    wp_enqueue_script('JsShortCodeGaleria', plugins_url('js/shortcode_galeria.js', __FILE__));
    $_shortCode = new galeria;
    $albumes = $_shortCode->getAlbumes();
    $ordenGeneral = $_shortCode->getOrdenGeneral();
    wp_localize_script('JsShortCodeGaleria', 'SolicitudesBack', [
        'albumes' => $albumes,
        'orden_general' => $ordenGeneral,
        'urlBack' => admin_url('admin-ajax.php')
    ]);
    $html = $_shortCode->getHTMLBody();
    return $html;
}
add_shortcode("GALERIAGENERAL", "imprimirGaleria");