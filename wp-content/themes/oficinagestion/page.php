<?php get_header();?>

    <main class="detalle">
        <?php
            if(have_posts()):
                while (have_posts()):the_post();
        ?>
        <div class="breadcrumb-class">Está en:<a href="<?php home_url();?>" target="_self" title="Inicio">Inicio</a>/<span><?php the_title();?></span></div>

        <div class="content">
            <?php the_content();?>
        </div>

        <?php 
                endwhile;
            else:wp_redirect(get_bloginfo('siteurl').'/404', 404); exit; endif;
        ?>

    </main>

<?php get_footer();?>