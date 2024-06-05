<?php
  /*
    Template Name: Plan de Manejo
  */
	get_header();
	$FACULTAD_title = $_GET['FACULTAD'];
?>
<?php $backgroundImg = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full' ); ?>
<main class="detalle">
	<?php
       	if(have_posts()):
        	while (have_posts()):the_post();
    ?>
	<div class="head">
		<div class="backimg" style='background: url("<?php echo $backgroundImg[0]  ?>")'>
			<div class="head-container">
				<h1 class="the-title"><?php the_title(); echo ' de '.$FACULTAD_title;?></h1>	
				<div class="breadcrumb-class"><?php if ( function_exists('yoast_breadcrumb') ) {yoast_breadcrumb( '</p><p id=“breadcrumbs”> Está en:','</p><p>' );	}?></div>	
			</div>
		</div>
	</div>

	<div class="content">
		<!--<div class="content">
	            <?php //the_content();?>
		</div>-->
		<div id="content-PM">
			<h1 id="tituloPaginaPlanManejo"> </h1>
    		<div id="objetivesContainer"></div>
		</div>
		<!--<div id="sidebar-right" class="sidebar">
			<?php //if ( is_active_sidebar( 'pmas-facultad-derecho-side-bar' ) ) : ?>
		    	<?php //dynamic_sidebar( 'pmas-facultad-derecho-side-bar' ); ?>
			<?php //endif; ?>
		</div>-->
	</div>
	<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
	<?php 
            endwhile;
    	        else:wp_redirect(get_bloginfo('siteurl').'/404', 404); exit; endif;
    ?>
</main>

<?php

plan_manejo_enqueues();
get_footer();

?>