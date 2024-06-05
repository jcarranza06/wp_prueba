<?php
  /*
    Template Name: HOME
  */
get_header();
?>

<!--Slide-->
<div class="home-slider">
	<div class="video-container">
		
	</div><!--video institucional-->
	<ul class="slides-home">
	<?php
		query_posts('post_type=slide-home&posts_per_page-1');
		while(have_posts()):the_post();
			//get url post
			$thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full' );
			$url = $thumb['0'];
	?>
		<li style="background-image:url(<?php echo $url; ?>)">
			<div class="caption">
				<h3><?php the_title(); ?></h3>
				<?php the_content();?>
			</div>
		</li>
	<?php
		endwhile;
	wp_reset_query();
	?>
	</ul>
</div>


<?php
get_footer();
?>