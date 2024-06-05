<?php get_header();?>

    <main class="detalle">
        <?php
            if(have_posts()):
                while (have_posts()):the_post();
        ?>
        <div class="breadcrumb-class">Está en:<a href="<?php home_url();?>" target="_self" title="Inicio">Inicio</a>/<span><?php the_title();?></span></div>
        
        <div class="content">
            <div class="top-new">
                <div class="text-header">
                    <h1><?php the_title();?></h1>
                    <h4><?php the_time('F j, Y'); ?></h4>
                </div>
                <div class="header-thumb">
                    <figure>
                        <?php the_post_thumbnail('full'); ?>
                    </figure>
                </div>
            </div>
            <div class="body-new">
                <?php the_content();?>
            </div>
        </div>

        <?php 
                endwhile;
            else:wp_redirect(get_bloginfo('siteurl').'/404', 404); exit; endif;
        ?>

    </main>

<?php get_footer();?>