<?php
  /*
    Template Name: Predios
  */
	get_header();
	
?>
<?php $backgroundImg = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full' ); ?>
<!--<main class="detalle">
	<?php
       	if(have_posts()):
        	//while (have_posts()):the_post();
    ?>
	<div class="head">
		<div class="backimg" style='background: url("<?php //echo $backgroundImg[0]  ?>")'>
			<div class="head-container">
				<h1 class="the-title"><?php //the_title();?></h1>	
				<div class="breadcrumb-class"><?php //if ( function_exists('yoast_breadcrumb') ) {yoast_breadcrumb( '</p><p id=“breadcrumbs”> Está en:','</p><p>' );	}?></div>	
			</div>
		</div>
	</div>

	<div class="content row sidebar-row">
		<div id="content-details">
			<?php //the_content();?>
		</div>-->
		<!--<iframe id="iFramePredios"
    title="Predios"
    width="100%"
    height="100vh"
	allowfullscreen 
	allow="geolocation"
    src="https://storymaps.arcgis.com/stories/805870543def4904818f3d335eb12aef?header">
</iframe>-->
<iframe id="iFramePredios"
    title="Predios"
    width="100%"
    height="100vh"
	src="https://storymaps.arcgis.com/stories/805870543def4904818f3d335eb12aef" frameborder="0" allowfullscreen allow="geolocation"></iframe>
		<!--<div id="sidebar-right" class="sidebar">
			<?php //if ( is_active_sidebar( 'predios-side-bar' ) ) : ?>
		    	<?php //dynamic_sidebar( 'predios-side-bar' ); ?>
			<?php //endif; ?>
		</div>
	</div>
	<?php 
            //endwhile;
    	        else:wp_redirect(get_bloginfo('siteurl').'/404', 404); exit; endif;
    ?>
</main>-->

<?php

get_footer();

?>
