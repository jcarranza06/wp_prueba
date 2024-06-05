<?php
/*
Plugin Name: pesaje_residuos
Plugin URI: https://mail.google.com/
Description: Plugin desde el cual se administra el pesaje de residuos
Version: 0.0.1
*/

require_once dirname(__FILE__) . '/class/custom_form_pesaje.class.php';

function activate_pesaje_residuos()
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

    $sqlCrearTablaEnvios = "CREATE TABLE IF NOT EXISTS `{$wpdb->prefix}forms_send` 
                            (`id_envio` INT NOT NULL AUTO_INCREMENT , 
                            `id_formulario` INT NOT NULL , 
                            `puntaje` DOUBLE NOT NULL ,
                            `fecha` DATETIME NOT NULL ,
                             PRIMARY KEY (`id_envio`)) ENGINE = InnoDB;";

    $sqlCrearTablaRespuestas = "CREATE TABLE IF NOT EXISTS `{$wpdb->prefix}forms_respuestas` 
                                (`id_respuesta` INT NOT NULL AUTO_INCREMENT , 
                                `id_envio` INT NOT NULL , 
                                `categoria` VARCHAR(400) NOT NULL , 
                                `subgrupo` VARCHAR(400) NOT NULL , 
                                `pregunta` VARCHAR(400) NOT NULL , 
                                `respuesta` VARCHAR(400) NOT NULL ,
                                `id_elemento` VARCHAR(400) NOT NULL , 
                                `clase` VARCHAR(150) NOT NULL , 
                                PRIMARY KEY (`id_respuesta`)) ENGINE = InnoDB;";

    $sqlCrearTablaREspuestasAFormulario = "CREATE TABLE IF NOT EXISTS `{$wpdb->prefix}forms_responses` 
                                            (`id_envio` INT NOT NULL , `form_attended` INT NOT NULL ) 
                                            ENGINE = InnoDB;";
                            
    $wpdb->query($sqlCrearTablaLaboratorios);
    $wpdb->query($sqlCrearTablaFormularios);
    $wpdb->query($sqlCrearTablaEnvios);
    $wpdb->query($sqlCrearTablaRespuestas);
    $wpdb->query($sqlCrearTablaREspuestasAFormulario);
}

function deactivate_pesaje_residuos()
{
    /*flush_rewrite_rules();*/
}

register_activation_hook(__FILE__, 'activate_pesaje_residuos');
register_deactivation_hook(__FILE__, 'deactivate_pesaje_residuos');

add_action('admin_menu', 'CrearMenuPesajeResiduos');

function CrearMenuPesajeResiduos()
{
    add_menu_page(
        'pesaje residuos',
        //titulo pagina
        'pesaje_residuos',
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
function agregarJsAdminPesajeResiduos($hook)
{
    if ($hook != 'pesaje_residuos/lib/pageAdmin.php') {
        return;
    }
    wp_enqueue_script('JsAdminPesaje', plugins_url('js/admin_Pesaje.js', __FILE__));
    wp_localize_script('JsAdminPesaje', 'SolicitudesBack', [
        'urlBack' => admin_url('admin-ajax.php'),
        'securityToken' => wp_create_nonce('token')
    ]);
}
add_action('admin_enqueue_scripts', 'agregarJsAdminPesajeResiduos');

function agregarCssAdminPesaje($hook)
{
    if ($hook != 'pesaje_residuos/lib/pageAdmin.php') {
        return;
    }
    wp_enqueue_style('CssAdminPesaje', plugins_url('css/admin_pesaje_residuos_style.css', __FILE__));
}
add_action('admin_enqueue_scripts', 'agregarCssAdminPesaje');


//shortcode galeria 
function imprimirFormP($atts)
{
    wp_enqueue_style('CssShortcodePesaje', plugins_url('css/shortcode_pesaje_style.css', __FILE__));
    wp_enqueue_script('JsShortCodePesaje', plugins_url('js/shortcode_pesaje.js', __FILE__));
    
    $funcion = $atts["funcion"];

    $_shortCode = new custom_form_pesaje($funcion);

    
   
    $formularioJSON1 = $_shortCode->getJsonFormulario();//file_get_contents($archivoJSON);
    wp_localize_script('JsShortCodePesaje', 'SolicitudesBack', [
        'formulario' => $formularioJSON1,
        'urlBack' => admin_url('admin-ajax.php'),
        'tipoFormulario' => $funcion
    ]);
    $html = $_shortCode->getHTMLBody();
    //var_dump($funcion);

    return $html; //$html;
}
add_shortcode("FORMULARIO_PESAJE", "imprimirFormP");
