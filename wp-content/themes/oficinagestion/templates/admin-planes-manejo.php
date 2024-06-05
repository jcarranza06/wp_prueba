<?php
/*
Template Name: Administrador Planes de Manejo
*/
get_header();

function openAdmin($passString)
{
	$password = 'cc77cfc14c77d30ca47294362ccdd6c0b4c6dcd0';

	if (sha1($passString) == $password) {
		return true;
	}else{
		return false;
	}
}

?>
<?php $backgroundImg = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'full'); ?>
<main class="detalle">
	<?php
	if (have_posts()):
		while (have_posts()):
			the_post();
			?>
			<div class="head">
				<div class="backimg" style='background: url("<?php echo $backgroundImg[0] ?>")'>
					<div class="head-container">
						<h1 class="the-title">
							<?php the_title(); ?>
						</h1>
						<div class="breadcrumb-class"><?php if (function_exists('yoast_breadcrumb')) {
							yoast_breadcrumb('</p><p id=“breadcrumbs”> Está en:', '</p><p>');
						} ?></div>
					</div>
				</div>
			</div>

			<div class="content">
				<div class="content">
					<?php the_content(); ?>
				</div>
				<div>
					<div id="content_container_planes_manejo"></div>
				</div>
				<?php
				if(isset($_COOKIE['passwordAdmin'])){
					$_POST['passwordAdmin'] = $_COOKIE['passwordAdmin'];
				}
				if (isset($_POST['passwordAdmin']) and openAdmin($_POST['passwordAdmin'])) {
					//setcookie("passwordAdmin", $_POST['passwordAdmin'], time()+3600);
					admin_plan_manejo_enqueues();

					?>
					<div style="display: none;">
						<form class="form-inline" method="post" id="redirectionForm">
							<input type="password" class="form-control" id="inputPasswordAdminPlanesManejo" name="passwordAdmin"
								placeholder="" value="<?php echo $_POST['passwordAdmin'];?>">
						</form>
					</div>
					
					<?php
				} else { ?>
					<form class="form-inline" method="post">
						<div class="form-group">
							<label for="inputPassword2" class="labelPassword">Clave</label>
							<input type="password" class="form-control" id="inputPasswordAdminPlanesManejo" name="passwordAdmin"
								placeholder="">
						</div>
						<button class="btn btn-default" id="btnAccesMatrisAspectosEImpactos">Acceder</button>
					</form>

					<?php

				}
				?>
			</div>
		<?php
		endwhile;
	else:
		wp_redirect(get_bloginfo('siteurl') . '/404', 404);
		exit;
	endif;
	?>
</main>

<?php

get_footer();

?>