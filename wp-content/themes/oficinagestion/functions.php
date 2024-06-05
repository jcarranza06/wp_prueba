<?php
//Einscube Code

//Create post_type boletin
function posttype_boletin() {
 
    register_post_type( 'Boletines',    
        array(
            'labels' => array(
                'name' => __( 'Boletines Ambientales' ),
                'singular_name' => __( 'Boletin' ),
                'description' => ('Boletines Ambientales'),
                'add_new'     => __( 'Agregar Boletín'),
                'add_new_item'=> __( 'Nuevo Boletín' ),                
                'edit_item'             => __( 'Editar Boletín Ambiental' ),
                'view_item'             => __( 'Ver Boletín Ambiental' ),
                'all_items'             => __( 'Todos los Boletines Ambientales' ),
                'search_items'          => __( 'Buscar boletín' ),
            ),
            'public' => true,
            'has_archive' => true,
            'rewrite' => array('slug' => 'boletines'),
            'show_in_rest' => true,
 
        )
    );
}
/*******************CHANGE TITLE TO POSTYPE************************/
add_filter('enter_title_here', 'nombre_boletines_ambientales' , 20 , 2 );

function nombre_boletines_ambientales($title , $post){

    if( $post->post_type == 'boletines' ){
        $my_title = "Nombre del Boletín";
        return $my_title;
    }

    return $title;

}


/********** ACF PRO ****************/

// 1. customize ACF path
add_filter('acf/settings/path', 'my_acf_settings_path');
function my_acf_settings_path( $path ) {
    $path = get_stylesheet_directory() . '/acf/';
    return $path;
}
 
// 2. customize ACF dir
add_filter('acf/settings/dir', 'my_acf_settings_dir');
function my_acf_settings_dir( $dir ) {
    $dir = get_stylesheet_directory_uri() . '/acf/';
    return $dir;
}
 
// 3. Hide ACF field group menu item
add_filter('acf/settings/show_admin', '__return_false');

// 4. Include ACF
include_once( get_stylesheet_directory() . '/acf/acf.php' );

// load json
add_filter('acf/settings/load_json', 'my_acf_json_load_point');

function my_acf_json_load_point( $paths ) {
    // remove original path (optional)
    //unset($paths[0]);
    
    // append path
    $paths[] = get_stylesheet_directory() . '/acf-json';
    
    // return
    return $paths;
}


// Hooking up our function to theme setup
add_action( 'init', 'posttype_boletin' );

//Disable Gutenberg 
// disable for posts
add_filter('use_block_editor_for_post', '__return_false', 10);
// disable for post types
add_filter('use_block_editor_for_post_type', '__return_false', 10);

add_theme_support( 'post-thumbnails' );


function crear_breadcrumbs() {
    if (!is_front_page()) {
        echo '<a href="/">Inicio</a> » ';
        if (is_category() || is_single() || is_page()) {
            if(is_category()){
                $category = get_the_category();
                echo $category[0]->cat_name;
            }else{
                the_category(' - ');
            }if(is_page()) {
                echo the_title();
            }if (is_single()) {
                echo " » ";
                the_title();
            }
        }
    }
}
add_filter( '[HOOK_DE_TU_THEME]', 'crear_breadcrumbs' );

//slick and listdocs
function slick_enqueue() {    
	wp_register_script( 'jquery-slick-min-js', get_stylesheet_directory_uri() . '/slick/slick.min.js',array('jquery'),'', true);
	wp_enqueue_script( 'jquery-slick-min-js');
    wp_register_script( 'slickbrands', get_stylesheet_directory_uri() . '/js/slickbrands.js',array('jquery'),'', true);       
    wp_enqueue_script( 'slickbrands');
    wp_register_script( 'listjs', get_stylesheet_directory_uri() . '/js/list.min.js',array('jquery'),'', true);
    wp_enqueue_script( 'listjs');
    wp_register_script( 'listdocs', get_stylesheet_directory_uri() . '/js/listdocs.js',array('jquery'),'', true);       
    wp_enqueue_script( 'listdocs');
    wp_register_script( 'quicksand', get_stylesheet_directory_uri() . '/js/jquery.quicksand.js',array('jquery'),'', true);       
    wp_enqueue_script( 'quicksand');
    wp_register_script( 'listboletins', get_stylesheet_directory_uri() . '/js/listboletins.js',array('jquery'),'', true);       
    wp_enqueue_script( 'listboletins');
	wp_enqueue_style( 'slick-css', get_stylesheet_directory_uri() . '/slick/slick.css');            
}

add_action( 'wp_enqueue_scripts', 'slick_enqueue' );

//List.Js

    
/***************Sidebars*****************/

function my_custom_sidebar() {
    register_sidebar(
        array (
            'name' => __( 'Custom', 'oficinagestion' ),
            'id' => 'custom-side-bar',
            'description' => __( 'Custom Sidebar', 'oficinagestion' ),
            'before_widget' => '<div class="widget-content">',
            'after_widget' => "</div>",
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        )
    );
}
add_action( 'widgets_init', 'my_custom_sidebar' );
//Cobertura y Uso del Suelo sidebar
function cobertura_suelo_sidebar() {
    register_sidebar(
        array (
            'name' => __( 'Cobertura y uso del suelo', 'oficinagestion' ),
            'id' => 'cobertura-suelo-side-bar',
            'description' => __( 'Cobertura Suelo Sidebar', 'oficinagestion' ),
            'before_widget' => '<div class="widget-content">',
            'after_widget' => "</div>",
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        )
    );
}
add_action( 'widgets_init', 'cobertura_suelo_sidebar' );

//Hidrología sidebar
function hidrologia_sidebar() {
    register_sidebar(
        array (
            'name' => __( 'Hidrología', 'oficinagestion' ),
            'id' => 'hidrologia-side-bar',
            'description' => __( 'Hidrologia Sidebar', 'oficinagestion' ),
            'before_widget' => '<div class="widget-content">',
            'after_widget' => "</div>",
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        )
    );
}
add_action( 'widgets_init', 'hidrologia_sidebar' );

//Flora sidebar
function flora_sidebar() {
    register_sidebar(
        array (
            'name' => __( 'Flora', 'oficinagestion' ),
            'id' => 'flora-side-bar',
            'description' => __( 'Flora Sidebar', 'oficinagestion' ),
            'before_widget' => '<div class="widget-content">',
            'after_widget' => "</div>",
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        )
    );
}
add_action( 'widgets_init', 'flora_sidebar' );
//Predios sidebar
function predios_sidebar() {
    register_sidebar(
        array (
            'name' => __( 'Predios', 'oficinagestion' ),
            'id' => 'predios-side-bar',
            'description' => __( 'Predios Sidebar', 'oficinagestion' ),
            'before_widget' => '<div class="widget-content">',
            'after_widget' => "</div>",
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        )
    );
}
add_action( 'widgets_init', 'predios_sidebar' );

//Atmosfera sidebar
function atmosfera_sidebar() {
    register_sidebar(
        array (
            'name' => __( 'atmosfera', 'oficinagestion' ),
            'id' => 'atmosfera-side-bar',
            'description' => __( 'Atmosfera Sidebar', 'oficinagestion' ),
            'before_widget' => '<div class="widget-content">',
            'after_widget' => "</div>",
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        )
    );
}
add_action( 'widgets_init', 'atmosfera_sidebar' );

//Calidad del aire sidebar
function calidad_del_aire_sidebar() {
    register_sidebar(
        array (
            'name' => __( 'calidad del aire', 'oficinagestion' ),
            'id' => 'calidad-aire-side-bar',
            'description' => __( 'Calidad Aire Sidebar', 'oficinagestion' ),
            'before_widget' => '<div class="widget-content">',
            'after_widget' => "</div>",
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        )
    );
}
add_action( 'widgets_init', 'calidad_del_aire_sidebar' );
//Calidad del aire sidebar
function ruido_sidebar() {
    register_sidebar(
        array (
            'name' => __( 'Ruido', 'oficinagestion' ),
            'id' => 'ruido-side-bar',
            'description' => __( 'Ruido Sidebar', 'oficinagestion' ),
            'before_widget' => '<div class="widget-content">',
            'after_widget' => "</div>",
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        )
    );
}
add_action( 'widgets_init', 'ruido_sidebar' );

//Geosfera sidebar
function geosfera_sidebar() {
    register_sidebar(
        array (
            'name' => __( 'Geosfera', 'oficinagestion' ),
            'id' => 'geosfera-side-bar',
            'description' => __( 'Geosfera Sidebar', 'oficinagestion' ),
            'before_widget' => '<div class="widget-content">',
            'after_widget' => "</div>",
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        )
    );
}
add_action( 'widgets_init', 'geosfera_sidebar' );

//Biosfera sidebar
function biosfera_sidebar() {
    register_sidebar(
        array (
            'name' => __( 'Biosfera', 'oficinagestion' ),
            'id' => 'biosfera-side-bar',
            'description' => __( 'Biosfera Sidebar', 'oficinagestion' ),
            'before_widget' => '<div class="widget-content">',
            'after_widget' => "</div>",
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        )
    );
}
add_action( 'widgets_init', 'biosfera_sidebar' );

//Olores ofensivos sidebar
function olores_sidebar() {
    register_sidebar(
        array (
            'name' => __( 'Olores Ofensivos', 'oficinagestion' ),
            'id' => 'olores-side-bar',
            'description' => __( 'Olores Ofensivos Sidebar', 'oficinagestion' ),
            'before_widget' => '<div class="widget-content">',
            'after_widget' => "</div>",
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        )
    );
}
add_action( 'widgets_init', 'olores_sidebar' );

//Residuos sidebar
function residuos_sidebar() {
    register_sidebar(
        array (
            'name' => __( 'Residuos', 'oficinagestion' ),
            'id' => 'residuos-side-bar',
            'description' => __( 'Residuos Sidebar', 'oficinagestion' ),
            'before_widget' => '<div class="widget-content">',
            'after_widget' => "</div>",
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        )
    );
}
add_action( 'widgets_init', 'residuos_sidebar' );

//Geovisores sidebar
function geovisores_sidebar() {
    register_sidebar(
        array (
            'name' => __( 'Geovisores', 'oficinagestion' ),
            'id' => 'geovisores-side-bar',
            'description' => __( 'Geovisores Sidebar', 'oficinagestion' ),
            'before_widget' => '<div class="widget-content">',
            'after_widget' => "</div>",
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        )
    );
}
add_action( 'widgets_init', 'geovisores_sidebar' );

//Plagas sidebar
function plagas_sidebar() {
    register_sidebar(
        array (
            'name' => __( 'Plagas', 'oficinagestion' ),
            'id' => 'plagas-side-bar',
            'description' => __( 'Plagas Sidebar', 'oficinagestion' ),
            'before_widget' => '<div class="widget-content">',
            'after_widget' => "</div>",
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        )
    );
}
add_action( 'widgets_init', 'plagas_sidebar' );

//Agua sidebar
function agua_sidebar() {
    register_sidebar(
        array (
            'name' => __( 'Agua', 'oficinagestion' ),
            'id' => 'agua-side-bar',
            'description' => __( 'Agua Sidebar', 'oficinagestion' ),
            'before_widget' => '<div class="widget-content">',
            'after_widget' => "</div>",
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        )
    );
}
add_action( 'widgets_init', 'agua_sidebar' );

//Bases de datos sidebar
function bases_datos_sidebar() {
    register_sidebar(
        array (
            'name' => __( 'Bases de datos', 'oficinagestion' ),
            'id' => 'bases-datos-side-bar',
            'description' => __( 'Bases de datos Sidebar', 'oficinagestion' ),
            'before_widget' => '<div class="widget-content">',
            'after_widget' => "</div>",
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        )
    );
}
add_action( 'widgets_init', 'bases_datos_sidebar' );

//Energia sidebar
function energia_sidebar() {
    register_sidebar(
        array (
            'name' => __( 'Energia', 'oficinagestion' ),
            'id' => 'energia-side-bar',
            'description' => __( 'Energía Sidebar', 'oficinagestion' ),
            'before_widget' => '<div class="widget-content">',
            'after_widget' => "</div>",
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        )
    );
}
add_action( 'widgets_init', 'energia_sidebar' );

//Huella de Carbono sidebar
function huella_sidebar() {
    register_sidebar(
        array (
            'name' => __( 'Huella de Carbono', 'oficinagestion' ),
            'id' => 'huella-side-bar',
            'description' => __( 'Huella de Carbono Sidebar', 'oficinagestion' ),
            'before_widget' => '<div class="widget-content">',
            'after_widget' => "</div>",
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        )
    );
}
add_action( 'widgets_init', 'huella_sidebar' );


//PGIRS sidebar
function pgirs_sidebar() {
    register_sidebar(
        array (
            'name' => __( 'PGIRS', 'oficinagestion' ),
            'id' => 'pgirs-side-bar',
            'description' => __( 'PGIRS Sidebar', 'oficinagestion' ),
            'before_widget' => '<div class="widget-content">',
            'after_widget' => "</div>",
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        )
    );
}
add_action( 'widgets_init', 'pgirs_sidebar' );

//PMAS sidebar
function pmas_sidebar() {
    register_sidebar(
        array (
            'name' => __( 'PMAS', 'oficinagestion' ),
            'id' => 'pmas-side-bar',
            'description' => __( 'PMAS Sidebar', 'oficinagestion' ),
            'before_widget' => '<div class="widget-content">',
            'after_widget' => "</div>",
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        )
    );
}
add_action( 'widgets_init', 'pmas_sidebar' );

//Riesgos Ambientales sidebar
function riesgos_ambientales_sidebar() {
    register_sidebar(
        array (
            'name' => __( 'Riesgos Ambientales', 'oficinagestion' ),
            'id' => 'riesgos_ambientales-side-bar',
            'description' => __( 'Riesgos Ambientales Sidebar', 'oficinagestion' ),
            'before_widget' => '<div class="widget-content">',
            'after_widget' => "</div>",
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        )
    );
}
add_action( 'widgets_init', 'riesgos_ambientales_sidebar' );

//Green Metric sidebar
function green_metric_sidebar() {
    register_sidebar(
        array (
            'name' => __( 'Green Metric', 'oficinagestion' ),
            'id' => 'green-side-bar',
            'description' => __( 'Green Metric Sidebar', 'oficinagestion' ),
            'before_widget' => '<div class="widget-content">',
            'after_widget' => "</div>",
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        )
    );
}
add_action( 'widgets_init', 'green_metric_sidebar' );


//Cultura Ambiental sidebar
function cultura_sidebar() {
    register_sidebar(
        array (
            'name' => __( 'Cultura Ambiental', 'oficinagestion' ),
            'id' => 'cultura-ambiental-side-bar',
            'description' => __( 'Cultura Ambiental Sidebar', 'oficinagestion' ),
            'before_widget' => '<div class="widget-content">',
            'after_widget' => "</div>",
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        )
    );
}
add_action( 'widgets_init', 'cultura_sidebar' );

//*********PMAS facultades
//PMAS facultad enfermeria
function pmas_facultad_enfermeria_sidebar() {
    register_sidebar(
        array (
            'name' => __( 'PMAS Fac Enfermeria', 'oficinagestion' ),
            'id' => 'pmas-facultad-enfermeria-side-bar',
            'description' => __( 'PMAS Fac Enfermeria Sidebar', 'oficinagestion' ),
            'before_widget' => '<div class="widget-content">',
            'after_widget' => "</div>",
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        )
    );
}
add_action( 'widgets_init', 'pmas_facultad_enfermeria_sidebar' );

//PMAS Facultad Ciencias Agrarias
function pmas_facultad_cagrarias_sidebar() {
    register_sidebar(
        array (
            'name' => __( 'PMAS Fac Ciencias Agrarias', 'oficinagestion' ),
            'id' => 'pmas-facultad-cagrarias-side-bar',
            'description' => __( 'PMAS Fac Ciencias Agrarias Sidebar', 'oficinagestion' ),
            'before_widget' => '<div class="widget-content">',
            'after_widget' => "</div>",
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        )
    );
}
add_action( 'widgets_init', 'pmas_facultad_cagrarias_sidebar' );

//PMAS Facultad Ciencias Economicas
function pmas_facultad_ceconomicas_sidebar() {
    register_sidebar(
        array (
            'name' => __( 'PMAS Fac Ciencias Economicas', 'oficinagestion' ),
            'id' => 'pmas-facultad-ceconomicas-side-bar',
            'description' => __( 'PMAS Fac Ciencias Economicas Sidebar', 'oficinagestion' ),
            'before_widget' => '<div class="widget-content">',
            'after_widget' => "</div>",
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        )
    );
}
add_action( 'widgets_init', 'pmas_facultad_ceconomicas_sidebar' );

//PMAS Facultad Veterinaria
function pmas_facultad_veterinaria_sidebar() {
    register_sidebar(
        array (
            'name' => __( 'PMAS Fac Veterinaria', 'oficinagestion' ),
            'id' => 'pmas-facultad-veterinaria-side-bar',
            'description' => __( 'PMAS Fac Veterinaria Sidebar', 'oficinagestion' ),
            'before_widget' => '<div class="widget-content">',
            'after_widget' => "</div>",
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        )
    );
}
add_action( 'widgets_init', 'pmas_facultad_veterinaria_sidebar' );

//PMAS Facultad Ingeniería
function pmas_facultad_ingenieria_sidebar() {
    register_sidebar(
        array (
            'name' => __( 'PMAS Fac Ingeniería', 'oficinagestion' ),
            'id' => 'pmas-facultad-ingenieria-side-bar',
            'description' => __( 'PMAS Fac Ingniería Sidebar', 'oficinagestion' ),
            'before_widget' => '<div class="widget-content">',
            'after_widget' => "</div>",
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        )
    );
}
add_action( 'widgets_init', 'pmas_facultad_ingenieria_sidebar' );

//PMAS Facultad Ciencias Humanas
function pmas_facultad_chumanas_sidebar() {
    register_sidebar(
        array (
            'name' => __( 'PMAS Fac Ciencias Humanas', 'oficinagestion' ),
            'id' => 'pmas-facultad-chumanas-side-bar',
            'description' => __( 'PMAS Fac ciencias Humanas Sidebar', 'oficinagestion' ),
            'before_widget' => '<div class="widget-content">',
            'after_widget' => "</div>",
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        )
    );
}
add_action( 'widgets_init', 'pmas_facultad_chumanas_sidebar' );

//PMAS Facultad de Medicina
function pmas_facultad_medicina_sidebar() {
    register_sidebar(
        array (
            'name' => __( 'PMAS Fac Medicina', 'oficinagestion' ),
            'id' => 'pmas-facultad-medicina-side-bar',
            'description' => __( 'PMAS Fac Medicina Sidebar', 'oficinagestion' ),
            'before_widget' => '<div class="widget-content">',
            'after_widget' => "</div>",
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        )
    );
}
add_action( 'widgets_init', 'pmas_facultad_medicina_sidebar' );

//PMAS Facultad de Odontología
function pmas_facultad_odontologia_sidebar() {
    register_sidebar(
        array (
            'name' => __( 'PMAS Fac Odontología', 'oficinagestion' ),
            'id' => 'pmas-facultad-odontologia-side-bar',
            'description' => __( 'PMAS Fac Odontología Sidebar', 'oficinagestion' ),
            'before_widget' => '<div class="widget-content">',
            'after_widget' => "</div>",
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        )
    );
}
add_action( 'widgets_init', 'pmas_facultad_odontologia_sidebar' );

//PMAS Facultad de Artes
function pmas_facultad_artes_sidebar() {
    register_sidebar(
        array (
            'name' => __( 'PMAS Fac Artes', 'oficinagestion' ),
            'id' => 'pmas-facultad-artes-side-bar',
            'description' => __( 'PMAS Fac Artes Sidebar', 'oficinagestion' ),
            'before_widget' => '<div class="widget-content">',
            'after_widget' => "</div>",
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        )
    );
}
add_action( 'widgets_init', 'pmas_facultad_artes_sidebar' );

//PMAS Facultad de Ciencias
function pmas_facultad_ciencias_sidebar() {
    register_sidebar(
        array (
            'name' => __( 'PMAS Fac Ciencias', 'oficinagestion' ),
            'id' => 'pmas-facultad-ciencias-side-bar',
            'description' => __( 'PMAS Fac Ciencias Sidebar', 'oficinagestion' ),
            'before_widget' => '<div class="widget-content">',
            'after_widget' => "</div>",
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        )
    );
}
add_action( 'widgets_init', 'pmas_facultad_ciencias_sidebar' );

//PMAS Facultad de Derecho
function pmas_facultad_derecho_sidebar() {
    register_sidebar(
        array (
            'name' => __( 'PMAS Fac Derecho', 'oficinagestion' ),
            'id' => 'pmas-facultad-derecho-side-bar',
            'description' => __( 'PMAS Fac Derecho Sidebar', 'oficinagestion' ),
            'before_widget' => '<div class="widget-content">',
            'after_widget' => "</div>",
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        )
    );
}
add_action( 'widgets_init', 'pmas_facultad_derecho_sidebar' );

//PMAS Proyecto Centro Tecnológico de acopio
function pmas_proyecto_centro_acopio_sidebar() {
    register_sidebar(
        array (
            'name' => __( 'PMAS Proyecto Centro Tecnologico de Acopio', 'oficinagestion' ),
            'id' => 'pmas-pctacopio-side-bar',
            'description' => __( 'PMAS Proyecto Centro Tecnologico de Acopio Sidebar', 'oficinagestion' ),
            'before_widget' => '<div class="widget-content">',
            'after_widget' => "</div>",
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        )
    );
}
add_action( 'widgets_init', 'pmas_proyecto_centro_acopio_sidebar' );

//Aspectos e Impactos Ambientales
function aspectos_e_impactos_ambientales_side_bar() {
    register_sidebar(
        array (
            'name' => __( 'Aspectos e Impactos Ambientales', 'oficinagestion' ),
            'id' => 'aspectos-e-impactos-ambientales-side-bar',
            'description' => __( 'Aspectos e Impactos Ambientales Sidebar', 'oficinagestion' ),
            'before_widget' => '<div class="widget-content">',
            'after_widget' => "</div>",
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        )
    );
}
add_action( 'widgets_init', 'aspectos_e_impactos_ambientales_side_bar' );

//Residuos Peligrosos
function residuos_peligrosos_side_bar() {
    register_sidebar(
        array (
            'name' => __( 'Residuos Peligrosos', 'oficinagestion' ),
            'id' => 'residuos-peligrosos-side-bar',
            'description' => __( 'Residuos Peligrosos Sidebar', 'oficinagestion' ),
            'before_widget' => '<div class="widget-content">',
            'after_widget' => "</div>",
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        )
    );
}
add_action( 'widgets_init', 'residuos_peligrosos_side_bar' );

function residuos_de_construccion_y_demolicion_side_bar() {
    register_sidebar(
        array (
            'name' => __( 'Residuos de Construccion y Demolicion', 'oficinagestion' ),
            'id' => 'residuos-de-construccion-y-demolicion-side-bar',
            'description' => __( 'Residuos de Construccion y Demolicion Sidebar', 'oficinagestion' ),
            'before_widget' => '<div class="widget-content">',
            'after_widget' => "</div>",
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        )
    );
}
add_action( 'widgets_init', 'residuos_de_construccion_y_demolicion_side_bar' );

function residuos_no_peligrosos_side_bar() {
    register_sidebar(
        array (
            'name' => __( 'Residuos no Peligrosos', 'oficinagestion' ),
            'id' => 'residuos-no-peligrosos-side-bar',
            'description' => __( 'Residuos no Peligrosos Sidebar', 'oficinagestion' ),
            'before_widget' => '<div class="widget-content">',
            'after_widget' => "</div>",
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        )
    );
}
add_action( 'widgets_init', 'residuos_no_peligrosos_side_bar' );

//Enques
function wbst_enqueues() {

	wp_register_script('jquery', get_bloginfo('template_url').'/js/jquery.js', __FILE__, false, '1.11.3', true);
	wp_enqueue_script( 'jquery' );

	//Styles

	wp_register_style('bootstrap-css', get_template_directory_uri() . '/css/bootstrap.min.css', false, '3.3.4', null);
	wp_enqueue_style('bootstrap-css');

	wp_register_style('bootstrap-theme', get_template_directory_uri() . '/css/bootstrap-theme.min.css', false, '3.3.4', null);
	wp_enqueue_style('bootstrap-theme');

	wp_register_style('phone-css', get_template_directory_uri() . '/css/phone.css', false, null);
	wp_enqueue_style('phone-css');

  	wp_register_style('printer-css', get_template_directory_uri() . '/css/printer.css', false, null);
	wp_enqueue_style('printer-css');

	wp_register_style('reset-css', get_template_directory_uri() . '/css/reset.css', false, null);
	wp_enqueue_style('reset-css');

	wp_register_style('small-css', get_template_directory_uri() . '/css/small.css', false, null);
	wp_enqueue_style('small-css');

	wp_register_style('tablet-css', get_template_directory_uri() . '/css/tablet.css', false, null);
	wp_enqueue_style('tablet-css');

	wp_register_style('unal-css', get_template_directory_uri() . '/css/unal.css', false, null);
	wp_enqueue_style('unal-css');

	wp_register_style('bxslider-css', get_template_directory_uri() . '/css/jquery.bxslider.css', false, null);
	wp_enqueue_style('bxslider-css');

	wp_register_style('base-css', get_template_directory_uri() . '/css/base.css', false, '1.0', null);
	wp_enqueue_style('base-css');

	//Scripts
  
	wp_register_script('html5-js', get_template_directory_uri() . '/js/html5shiv.js', false, null, true);
	wp_enqueue_script('html5-js');

	wp_register_script('matchmedia-js', get_template_directory_uri() . '/js/matchmedia.addListener.js', false, null, true);
	wp_enqueue_script('matchmedia-js');

	wp_register_script('polyfill-js', get_template_directory_uri() . '/js/matchmedia.polyfill.js', false, null, true);
	wp_enqueue_script('polyfill-js');

	wp_register_script('respond-js', get_template_directory_uri() . '/js/respond.js', false, null, true);
	wp_enqueue_script('respond-js');

	wp_register_script('unal-js', get_template_directory_uri() . '/js/unal.js', false, null, true);
	wp_enqueue_script('unal-js');

	wp_register_script('bxslider-js', get_template_directory_uri() . '/js/jquery.bxslider.min.js', false, null, true);
	wp_enqueue_script('bxslider-js');

	if (is_singular() && comments_open() && get_option('thread_comments')) {
		wp_enqueue_script('comment-reply');
	}
}
add_action('wp_enqueue_scripts', 'wbst_enqueues', 100);

function planes_manejo_enqueues() {
	wp_register_style('style_planes_manejo-css', get_template_directory_uri() . '/css/style_planes_manejo.css', false, null);
	wp_enqueue_style('style_planes_manejo-css');
}

function plan_manejo_enqueues() {
	wp_register_style('style_planes_manejo-css', get_template_directory_uri() . '/css/style_planes_manejo.css', false, null);
	wp_enqueue_style('style_planes_manejo-css');
	
	wp_register_script('planManejo-js', get_template_directory_uri() . '/js/planManejo.js', false, null, true);
	wp_enqueue_script('planManejo-js');
}
/*add_action('wp_enqueue_scripts', 'plan_manejo_enqueues', 100);*/

function admin_plan_manejo_enqueues() {
	wp_register_style('style_planes_manejo-css', get_template_directory_uri() . '/css/style_planes_manejo.css', false, null);
	wp_enqueue_style('style_planes_manejo-css');
	
	wp_register_script('admin_script_planes_manejo-js', get_template_directory_uri() . '/js/admin_script_planes_manejo.js', false, null, true);
	wp_enqueue_script('admin_script_planes_manejo-js');
}
/*add_action('wp_enqueue_scripts', 'admin_plan_manejo_enqueues', 100);*/

function includeHeadSlider($list, $time){
    include_once("slider.php");
    $slider = new Slider;
    $slider->createSlider($list, $time);
}

/*
Clean up wp_head()
*/
remove_action('wp_head', 'wp_generator');
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'index_rel_link');
remove_action('wp_head', 'feed_links', 2);
remove_action('wp_head', 'feed_links_extra', 3);
remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);

/*
Show less info to users on failed login for security.
(Will not let a valid username be known.)
*/
function show_less_login_info() { 
    return "<strong>ERROR</strong>: Stop guessing!"; }
add_filter( 'login_errors', 'show_less_login_info' );

/*
Do not generate and display WordPress version
*/
function no_generator()  { 
    return ''; }
add_filter( 'the_generator', 'no_generator' );	

//Navbar
/**
 * Class Name: wp_bootstrap_navwalker
 * GitHub URI: https://github.com/twittem/wp-bootstrap-navwalker
 * Description: A custom WordPress nav walker class to implement the Bootstrap 3 navigation style in a custom theme using the WordPress built in menu manager.
 * Version: 2.0.4
 * Author: Edward McIntyre - @twittem
 * License: GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 */
class wp_bootstrap_navwalker extends Walker_Nav_Menu {
	/**
	 * @see Walker::start_lvl()
	 * @since 3.0.0
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param int $depth Depth of page. Used for padding.
	 */
	public function start_lvl( &$output, $depth = 0, $args = array() ) {
		$indent = str_repeat( "\t", $depth );
		$output .= "\n$indent<ul role=\"menu\" class=\" dropdown-menu\">\n";
	}
	/**
	 * @see Walker::start_el()
	 * @since 3.0.0
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param object $item Menu item data object.
	 * @param int $depth Depth of menu item. Used for padding.
	 * @param int $current_page Menu item ID.
	 * @param object $args
	 */
	public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
		$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';
		/**
		 * Dividers, Headers or Disabled
		 * =============================
		 * Determine whether the item is a Divider, Header, Disabled or regular
		 * menu item. To prevent errors we use the strcasecmp() function to so a
		 * comparison that is not case sensitive. The strcasecmp() function returns
		 * a 0 if the strings are equal.
		 */
		if ( strcasecmp( $item->attr_title, 'divider' ) == 0 && $depth === 1 ) {
			$output .= $indent . '<li role="presentation" class="divider">';
		} else if ( strcasecmp( $item->title, 'divider') == 0 && $depth === 1 ) {
			$output .= $indent . '<li role="presentation" class="divider">';
		} else if ( strcasecmp( $item->attr_title, 'dropdown-header') == 0 && $depth === 1 ) {
			$output .= $indent . '<li role="presentation" class="dropdown-header">' . esc_attr( $item->title );
		} else if ( strcasecmp($item->attr_title, 'disabled' ) == 0 ) {
			$output .= $indent . '<li role="presentation" class="disabled"><a href="#">' . esc_attr( $item->title ) . '</a>';
		} else {
			$class_names = $value = '';
			$classes = empty( $item->classes ) ? array() : (array) $item->classes;
			$classes[] = 'menu-item-' . $item->ID;
			$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );
			if ( $args->has_children )
				$class_names .= ' dropdown';
			if ( in_array( 'current-menu-item', $classes ) )
				$class_names .= ' active';
			$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';
			$id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args );
			$id = $id ? ' id="' . esc_attr( $id ) . '"' : '';
			$output .= $indent . '<li' . $id . $value . $class_names .'>';
			$atts = array();
			$atts['title']  = ! empty( $item->title )	? $item->title	: '';
			$atts['target'] = ! empty( $item->target )	? $item->target	: '';
			$atts['rel']    = ! empty( $item->xfn )		? $item->xfn	: '';
			// If item has_children add atts to a.
			if ( $args->has_children && $depth === 0 ) {
				$atts['href']   		= $item->url;
				$atts['data-toggle']	= 'dropdown';
				$atts['class']			= 'dropdown-toggle';
				$atts['aria-haspopup']	= 'true';
			} else {
				$atts['href'] = ! empty( $item->url ) ? $item->url : '';
			}
			$atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args );
			$attributes = '';
			foreach ( $atts as $attr => $value ) {
				if ( ! empty( $value ) ) {
					$value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
					$attributes .= ' ' . $attr . '="' . $value . '"';
				}
			}
			$item_output = $args->before;
			/*
			 * Glyphicons
			 * ===========
			 * Since the the menu item is NOT a Divider or Header we check the see
			 * if there is a value in the attr_title property. If the attr_title
			 * property is NOT null we apply it as the class name for the glyphicon.
			 */
			if ( ! empty( $item->attr_title ) )
				$item_output .= '<a'. $attributes .'><span class="glyphicon ' . esc_attr( $item->attr_title ) . '"></span>&nbsp;';
			else
				$item_output .= '<a'. $attributes .'>';
			$item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
			$item_output .= ( $args->has_children && 0 === $depth ) ? ' <span class="caret"></span></a>' : '</a>';
			$item_output .= $args->after;
			$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
		}
	}
	/**
	 * Traverse elements to create list from elements.
	 *
	 * Display one element if the element doesn't have any children otherwise,
	 * display the element and its children. Will only traverse up to the max
	 * depth and no ignore elements under that depth.
	 *
	 * This method shouldn't be called directly, use the walk() method instead.
	 *
	 * @see Walker::start_el()
	 * @since 2.5.0
	 *
	 * @param object $element Data object
	 * @param array $children_elements List of elements to continue traversing.
	 * @param int $max_depth Max depth to traverse.
	 * @param int $depth Depth of current element.
	 * @param array $args
	 * @param string $output Passed by reference. Used to append additional content.
	 * @return null Null on failure with no changes to parameters.
	 */
	public function display_element( $element, &$children_elements, $max_depth, $depth, $args, &$output ) {
        if ( ! $element )
            return;
        $id_field = $this->db_fields['id'];
        // Display this element.
        if ( is_object( $args[0] ) )
           $args[0]->has_children = ! empty( $children_elements[ $element->$id_field ] );
        parent::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );
    }
	/**
	 * Menu Fallback
	 * =============
	 * If this function is assigned to the wp_nav_menu's fallback_cb variable
	 * and a manu has not been assigned to the theme location in the WordPress
	 * menu manager the function with display nothing to a non-logged in user,
	 * and will add a link to the WordPress menu manager if logged in as an admin.
	 *
	 * @param array $args passed from the wp_nav_menu function.
	 *
	 */
	public static function fallback( $args ) {
		if ( current_user_can( 'manage_options' ) ) {
			extract( $args );
			$fb_output = null;
			if ( $container ) {
				$fb_output = '<' . $container;
				if ( $container_id )
					$fb_output .= ' id="' . $container_id . '"';
				if ( $container_class )
					$fb_output .= ' class="' . $container_class . '"';
				$fb_output .= '>';
			}
			$fb_output .= '<ul';
			if ( $menu_id )
				$fb_output .= ' id="' . $menu_id . '"';
			if ( $menu_class )
				$fb_output .= ' class="' . $menu_class . '"';
				$fb_output .= '>';
				$fb_output .= '<li><a href="' . admin_url( 'nav-menus.php' ) . '">Add a menu</a></li>';
				$fb_output .= '</ul>';
			if ( $container )
				$fb_output .= '</' . $container . '>';
			echo $fb_output;
		}
	}
}

// Upper navbar (above site title)
register_nav_menu('navbar-default', __('Default navbar (top)', 'wbst'));

register_nav_menu('logegd-menu', __('Logged User (top)', 'wbst'));


//TYpes fix

add_filter('types_information_table', '__return_false');

function true_load_theme_textdomain(){
    load_theme_textdomain( 'wbst', get_template_directory() . '/languages' );
}

//Increase file upload
@ini_set( 'upload_max_size' , '64M' );
@ini_set( 'post_max_size', '64M');
@ini_set( 'max_execution_time', '300' );



/*GOOGLE ANALYTICS*/
function add_google_analytics() {
  wp_enqueue_script( 'analytics', get_template_directory_uri() . '/js/analytics.js');
}

add_action( 'wp_enqueue_scripts', 'add_google_analytics' );

?>