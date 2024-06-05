<?php
  /*
    Template Name: Boletines
  */
	get_header();
	
?>
<?php $backgroundImg = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full' ); ?>
<main class="detalle">
	<div class="head">
		<div class="backimg" style='background: url("<?php echo $backgroundImg[0]  ?>")'>
			<div class="head-container">
				<h1 class="the-title"><?php the_title();?></h1>	
				<div class="breadcrumb-class"><?php if ( function_exists('yoast_breadcrumb') ) {yoast_breadcrumb( '</p><p id=“breadcrumbs”> Está en:','</p><p>' );	}?></div>	
			</div>
		</div>
	</div>
	<div class="content">
		<div class="filters">			
			<div class="filter-year">
				<?php
					$currentYear = date('Y');
					$already_selected_value = $currentYear;
					$earliest_year = 2020;

					print '<form name="year"><select name="yearboletin" id="year"><option value="">Seleccione Año</option>';
					foreach (range(date('Y'), $earliest_year) as $x) {
					    print '<option value="'.$x.'"'.($x === $already_selected_value ? ' selected="selected"' : '').'>'.$x.'</option>';
					}
					print '</select></form>';
				?>
			</div>
			<div class="filter-month">
				<form name="month">
					<select name="monthboletin" onchange="" id="month">
						<option value="">Seleccione Mes</option>
						<option value="Enero">Enero</option>
						<option value="Febrero">Febrero</option>
						<option value="Marzo">Marzo</option>
						<option value="Abril">Abril</option>
						<option value="Mayo">Mayo</option>
						<option value="Junio">Junio</option>
						<option value="Julio">Julio</option>
						<option value="Agosto">Agosto</option>
						<option value="Septiembre">Septiembre</option>
						<option value="Octubre">Octubre</option>
						<option value="Noviembre">Noviembre</option>
						<option value="Diciembre">Diciembre</option>
					</select>
				</form>
			</div>
			<button class="fltrbtn" type="submit" onclick="filter_boletin()">Filtrar</button>
		</div>		
		<div class="boletines">
			<ul id="list-boletines">
				<?php	
					$query = new WP_Query(array(
					    'post_type' => 'boletines',
					    'post_status' => 'publish'
					));
					
					while ($query->have_posts()) {
					    $query->the_post();
					    $post_id = get_the_ID();
					    $title_boletin = get_the_title();
					    $url_pdf_boletin = get_field('boletin');
					    $img_boletin = get_field('portada');
					    $year_boletin = get_field('ano');
					    $month_boletin = get_field('mes');

					    echo '<li class="boletin-item" dataid="'.$year_boletin.$month_boletin.'"><a target="_blank" href="'.$url_pdf_boletin.'"><img src="'.$img_boletin.'" alt="Boletin Ambiental"><span class="title">'.$title_boletin.'</span></a></li>';

					    //echo $post_id."<br/>".$title_boletin."<br/>".$url_pdf_boletin."<br/>".$img_boletin."<br/>".$year_boletin."<br/>".$month_boletin."<br/>";
					    //echo "<br>";
					    
					}
					wp_reset_query();
				?>
			</ul>
		</div>
	</div>
</main>
<?php
get_footer();
?>
