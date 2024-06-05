<?php
  /*
    Template Name: Noticias
  */
get_header();
?>

<!--Slide-->
<div class="news-list container">
	<header>
		<h1>Noticias</h1>
	</header>
	<?php
		query_posts('post_type=post&posts_per_page=-1');
		while(have_posts()):the_post();
			//get url post
			$thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full' );
			$url = $thumb['0'];
	?>
		<article class="new-item">
			<figure>
				<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('thumbnail'); ?></a>
			</figure>
			<a href="<?php the_permalink(); ?>"><h3><?php the_title(); ?></h3></a>
			<h4><?php the_date();?></h4>
			<?php the_excerpt();?>
			<a href="<?php the_permalink(); ?>" class="btn">Ver más</a>
		</article>
	<?php
		endwhile;
	wp_reset_query();
	?>
</div>


<?php
get_footer();
?>