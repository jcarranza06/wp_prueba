<?php
/*
Plugin Name: custom_form
Plugin URI: https://mail.google.com/
Description: Plugin desde el cual se administran los formularios personalizados de la pagina
Version: 0.0.1
*/

require_once dirname(__FILE__) . '/class/custom_form.class.php';

function activate_custom_form()
{
    global $wpdb;

    //al activate_custom_form el plugin automaticamente se crea la tabla de albumes y de fotos
    $sqlCrearTablaLaboratorios = "CREATE TABLE IF NOT EXISTS `{$wpdb->prefix}laboratorios` 
                                (`ID_LABORATORIO` INT NOT NULL AUTO_INCREMENT , 
                                `ID_HERMES` INT NOT NULL , `LABORATORIO` VARCHAR(400) NOT NULL , 
                                `SEDE` VARCHAR(400) NOT NULL , `ACTIVO` VARCHAR(400) NOT NULL , 
                                `FACULTAD` VARCHAR(400) NOT NULL , 
                                `DEPARTAMENTO` VARCHAR(400) NOT NULL , 
                                PRIMARY KEY (`ID_LABORATORIO`)) ENGINE = InnoDB;";

    $sqlCrearTablaFormularios = "CREATE TABLE IF NOT EXISTS `{$wpdb->prefix}custom_forms` 
                            (`id_formulario` INT NOT NULL AUTO_INCREMENT , 
                            `json_formulario` VARCHAR(5000000) NOT NULL ,
                             PRIMARY KEY (`id_formulario`)) ENGINE = InnoDB;";

    $sqlCrearTablaEnvios = "CREATE TABLE `{$wpdb->prefix}forms_send` 
                            (`id_envio` INT NOT NULL AUTO_INCREMENT , 
                            `id_formulario` INT NOT NULL , 
                            `puntaje` DOUBLE NOT NULL ,
                            `fecha` DATETIME NOT NULL ,
                             PRIMARY KEY (`id_envio`)) ENGINE = InnoDB;";

    $sqlCrearTablaRespuestas = "CREATE TABLE `{$wpdb->prefix}forms_respuestas` 
                                (`id_respuesta` INT NOT NULL AUTO_INCREMENT , 
                                `id_envio` INT NOT NULL , 
                                `categoria` VARCHAR(400) NOT NULL , 
                                `subgrupo` VARCHAR(400) NOT NULL , 
                                `pregunta` VARCHAR(400) NOT NULL , 
                                `respuesta` VARCHAR(400) NOT NULL ,
                                `id_elemento` VARCHAR(400) NOT NULL , 
                                `clase` VARCHAR(150) NOT NULL , 
                                PRIMARY KEY (`id_respuesta`)) ENGINE = InnoDB;";
                            
    $wpdb->query($sqlCrearTablaLaboratorios);
    $wpdb->query($sqlCrearTablaFormularios);
    $wpdb->query($sqlCrearTablaEnvios);
    $wpdb->query($sqlCrearTablaRespuestas);
}

function deactivate_custom_form()
{
    /*flush_rewrite_rules();*/
}

register_activation_hook(__FILE__, 'activate_custom_form');
register_deactivation_hook(__FILE__, 'deactivate_custom_form');

add_action('admin_menu', 'CrearMenuCustomForm');

function CrearMenuCustomForm()
{
    add_menu_page(
        'Formularios',
        //titulo pagina
        'custom_forms',
        //titulo menu
        'manage_options',
        //capbility
        plugin_dir_path(__FILE__) . 'lib/pageAdmin.php',
        //slug
        null,
        //'MostrarAdminGaleria', // llamada al contenido 
        plugin_dir_url(__FILE__) . 'img/iconoGaleria.png',
        // imagen/icono barra
        '5' //posicion menu 
    );
}
//se agrega el script js a la pagina
function agregarJsAdminCustomForms($hook)
{
    if ($hook != 'custom_form/lib/pageAdmin.php') {
        return;
    }
    wp_enqueue_script('JsAdminForms', plugins_url('js/admin_forms.js', __FILE__));
    wp_localize_script('JsAdminForms', 'SolicitudesBack', [
        'urlBack' => admin_url('admin-ajax.php'),
        'securityToken' => wp_create_nonce('token')
    ]);
}
add_action('admin_enqueue_scripts', 'agregarJsAdminCustomForms');

function agregarCssAdminCustomForms($hook)
{
    if ($hook != 'custom_form/lib/pageAdmin.php') {
        return;
    }
    wp_enqueue_style('CssAdminForms', plugins_url('css/admin_forms_style.css', __FILE__));
}
add_action('admin_enqueue_scripts', 'agregarCssAdminCustomForms');


//shortcode galeria 
function imprimirForm($atts)
{
    wp_enqueue_style('CssShortcodeForm', plugins_url('css/shortcode_form_style.css', __FILE__));
    wp_enqueue_script('JsShortCodeForm', plugins_url('js/shortcode_form.js', __FILE__));
    
    $funcion = $atts["funcion"];

    $_shortCode = new custom_form($funcion);

    
   
    $formularioJSON1 = $_shortCode->getJsonFormulario();//file_get_contents($archivoJSON);
    wp_localize_script('JsShortCodeForm', 'SolicitudesBack', [
        'formulario' => $formularioJSON1,
        'urlBack' => admin_url('admin-ajax.php'),
        'tipoFormulario' => $funcion
    ]);
    $html = $_shortCode->getHTMLBody();
    //var_dump($funcion);

    

    return $html; //$html;
}
add_shortcode("FORMULARIO", "imprimirForm");

function getLaboratorio()
{
    $id_hermes = $_POST['id_hermes'];
    global $wpdb;
    $sqlObtenerFotoshermes = $wpdb->prepare("SELECT `ID_LABORATORIO`,`ID_HERMES`,`LABORATORIO`,`SEDE`,`ACTIVO`,`FACULTAD`,`DEPARTAMENTO` FROM `{$wpdb->prefix}laboratorios` WHERE `ID_HERMES` = %d", $id_hermes);
    $laboratorio = $wpdb->get_results($sqlObtenerFotoshermes, ARRAY_A);

    header('Content-Type: application/json');
    echo json_encode($laboratorio);
    // Detener la ejecución de WordPress
    wp_die();
}
add_action('wp_ajax_peticionLaboratorio', 'getLaboratorio');
add_action('wp_ajax_nopriv_peticionLaboratorio', 'getLaboratorio');
function insertCustomForm()
{
    global $wpdb;
    $datos = [
        'id_formulario' => null,
        'json_formulario' => ""
    ];
    $resultadoInsertFoto = $wpdb->insert("{$wpdb->prefix}custom_forms", $datos);

    // Detener la ejecución de WordPress
    wp_die();
}
add_action('wp_ajax_insertarCustomForm', 'insertCustomForm');

function eliminar_form_BD()
{
    $id_form = $_POST['id_form'];
    $nonce = $_POST['nonce'];
    if (!wp_verify_nonce($nonce, 'token')) {
        die();
    }
    global $wpdb;
    $wpdb->delete("{$wpdb->prefix}custom_forms", array('id_formulario' => $id_form));
    return true;
}
add_action('wp_ajax_eliminar_form_BD', 'eliminar_form_BD');

function update_form_BD()
{
    $id_form = $_POST['id_form'];
    $json_form = $_POST['json_form'];
    $nonce = $_POST['nonce'];
    if (!wp_verify_nonce($nonce, 'token')) {
        die();
    }
    global $wpdb;
    $datos_actualizacion = [
        'json_formulario' => $json_form,
    ];
    $condiciones = [
        'id_formulario' => $id_form
    ];
    $wpdb->update("{$wpdb->prefix}custom_forms", $datos_actualizacion, $condiciones);
    return true;
}
add_action('wp_ajax_updateCustomFormJson', 'update_form_BD');
