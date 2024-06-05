<?php
/*
Template Name: Archives
*/
get_header(); ?>

<div id="container" class="container">
	<div id="content" role="main" class="news-list container">

		<?php 
		// Check if there are any posts to display
		if ( have_posts() ) : ?>

		<header class="archive-header">
		<?php
		// Display optional category description
		 if ( category_description() ) : ?>
		<div class="archive-meta"><?php echo category_description(); ?></div>
		<?php endif; ?>
		</header>

		<?php

		// The Loop
		while ( have_posts() ) : the_post(); ?>
		<article class="new-item">
			<figure>
				<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('thumbnail'); ?></a>
			</figure>
			<a href="<?php the_permalink(); ?>"><h3><?php the_title(); ?></h3></a>
			<h4><?php the_date();?></h4>
			<?php the_excerpt();?>
			<a href="<?php the_permalink(); ?>" class="btn">Ver más</a>
		</article>
		<?php endwhile; 

		else: ?>
		<p>No hay noticias de  <?php single_cat_title( '', false ); ?> </p>


		<?php endif; ?>

	</div><!-- #content -->
</div><!-- #container -->


<?php get_footer(); ?>
