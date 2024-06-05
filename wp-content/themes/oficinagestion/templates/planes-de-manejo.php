<?php
/*
Template Name: Planes de Manejo
*/
get_header();

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
					<div id="planesContainer">
						<div class="facultadContainer" onclick="redirect('Enfermeria')">
							<img src="https://ogabogota.unal.edu.co/wp-content/uploads/2023/01/Enfermeria.png"
								alt="imagen Enfermeria">
							<div class="labelFacultadContainer">
								<h3> Enfermeria</h3>
							</div>
						</div>
						<div class="facultadContainer" onclick="redirect('Artes')">
							<img src="https://ogabogota.unal.edu.co/wp-content/uploads/2023/01/Artes.png" alt="imagen Artes">
							<div class="labelFacultadContainer">
								<h3> Artes</h3>
							</div>
						</div>
						<div class="facultadContainer" onclick="redirect('Ciencias Humanas')">
							<img src="https://ogabogota.unal.edu.co/wp-content/uploads/2023/01/Ciencias-humanas.png"
								alt="imagen Ciencias-humanas">
							<div class="labelFacultadContainer">
								<h3> Ciencias Humanas</h3>
							</div>
						</div>
						<div class="facultadContainer" onclick="redirect('Derecho')">
							<img src="https://ogabogota.unal.edu.co/wp-content/uploads/2023/01/Derecho.png"
								alt="imagen Derecho">
							<div class="labelFacultadContainer">
								<h3> Derecho</h3>
							</div>
						</div>
						<div class="facultadContainer" onclick="redirect('Economia')">
							<img src="https://ogabogota.unal.edu.co/wp-content/uploads/2023/01/Economia.png"
								alt="imagen Economia">
							<div class="labelFacultadContainer">
								<h3> Economía</h3>
							</div>
						</div>
						<div class="facultadContainer" onclick="redirect('Ciencias Agrarias')">
							<img src="https://ogabogota.unal.edu.co/wp-content/uploads/2023/01/Agronomia.png"
								alt="imagen Ciencias Agrarias">
							<div class="labelFacultadContainer">
								<h3> Ciencias Agrarias</h3>
							</div>
						</div>
						<div class="facultadContainer" onclick="redirect('Ingenieria')">
							<img src="https://ogabogota.unal.edu.co/wp-content/uploads/2023/01/Ingenieria.png"
								alt="imagen Ingenieria">
							<div class="labelFacultadContainer">
								<h3> Ingenieria</h3>
							</div>
						</div>
						<div class="facultadContainer" onclick="redirect('Medicina')">
							<img src="https://ogabogota.unal.edu.co/wp-content/uploads/2023/01/Medicina.png"
								alt="imagen Medicina">
							<div class="labelFacultadContainer">
								<h3> Medicina</h3>
							</div>
						</div>
						<div class="facultadContainer" onclick="redirect('Odontologia')">
							<img src="https://ogabogota.unal.edu.co/wp-content/uploads/2023/01/Odontologia.png"
								alt="imagen Odontologia">
							<div class="labelFacultadContainer">
								<h3> Odontologia</h3>
							</div>
						</div>
						<div class="facultadContainer" onclick="redirect('Veterinaria')">
							<img src="https://ogabogota.unal.edu.co/wp-content/uploads/2023/01/Veterinaria.png"
								alt="imagen Veterinaria">
							<div class="labelFacultadContainer">
								<h3> Veterinaria</h3>
							</div>
						</div>
						<div class="facultadContainer" onclick="redirect('Odontologia')">
							<img src="https://ogabogota.unal.edu.co/wp-content/uploads/2023/01/Odontologia.png"
								alt="imagen agronomía">
							<div class="labelFacultadContainer">
								<h3> Agronomía</h3>
							</div>
						</div>
					</div>
					</body>

					<script type="text/javascript">
						function redirect(string) {
							window.location.href = "https://ogabogota.unal.edu.co/planes-de-manejo/plan-de-manejo?FACULTAD=" + string
						}
					</script>
				</div>
				<!--<div id="sidebar-right" class="sidebar">
							<?php //if ( is_active_sidebar( 'pmas-facultad-derecho-side-bar' ) ) : ?>
								<?php //dynamic_sidebar( 'pmas-facultad-derecho-side-bar' ); ?>
							<?php //endif; ?>
						</div>-->
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
planes_manejo_enqueues();
get_footer();

?>