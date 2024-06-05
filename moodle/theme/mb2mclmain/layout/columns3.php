<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 *
 * @package   theme_mb2mclmain
 * @copyright 2020 - 2022 Mariusz Boloz (https://mb2themes.com)
 * @license   Commercial https://themeforest.net/licenses
 *
 */

defined('MOODLE_INTERNAL') || die();

global $DB; // codigo por univirtual
$sidePre = theme_mb2mclmain_isblock($PAGE, 'side-pre');
$sidePost = theme_mb2mclmain_isblock($PAGE, 'side-post');
$sidebarPos = theme_mb2mclmain_theme_setting($PAGE, 'sidebarpos', 'classic');
$sidebar = ($sidePre || $sidePost);
$contentCol = 'col-md-12';
$sidePreCol = 'col-md-3';
$sidePostCol = 'col-md-3';

if ($sidePre && $sidePost)
{
	$contentCol = 'col-md-6';

	if ($sidebarPos === 'classic')
	{
		$contentCol .= ' order-2';
		$sidePreCol .= ' order-1';
		$sidePostCol .= ' order-3';
	}
	elseif ($sidebarPos === 'left')
	{
		$contentCol .= ' order-3';
		$sidePreCol .= ' order-1';
		$sidePostCol .= ' order-2';
	}

}
elseif ($sidePre || $sidePost)
{
	$contentCol = 'col-md-9';

	if ($sidebarPos === 'classic')
	{
		$contentCol .= ' order-2';
		$sidePreCol .= ' order-1';
		$sidePostCol .= ' order-3';
	}
	elseif ($sidebarPos === 'left')
	{
		$contentCol .= ' order-3';
		$sidePreCol .= ' order-1';
		$sidePostCol .= ' order-2';
	}
}


?>
<?php echo $OUTPUT->theme_part('head'); ?>
<?php echo $OUTPUT->theme_part('header'); ?>
<?php //echo $OUTPUT->theme_part('region_slider'); ?>
<?php echo $OUTPUT->theme_part('page_header'); ?>
<?php echo theme_mb2mclmain_notice(); ?>
<?php echo $OUTPUT->theme_part('site_menu'); ?>
<div id="main-content">
	<?php echo $OUTPUT->theme_part('dashboard'); ?>
    <div class="container-fluid">
        <div class="row">
            <section id="region-main" class="content-col <?php echo $contentCol; ?>">
                <div id="page-content">
					<?php echo theme_mb2mclmain_panel_link(); ?>
               		<?php if (is_siteadmin()): ?>
						<?php echo theme_mb2mclmain_check_plugins(); ?>
                    <?php endif; ?>
                	<?php echo $OUTPUT->course_content_header(); ?>


					<?php if (theme_mb2mclmain_isblock($PAGE, 'content-top')) : ?>
                		<?php echo $OUTPUT->blocks('content-top', theme_mb2mclmain_block_cls($PAGE, 'content-top','none')); ?>
             		<?php endif; ?>







                	<?php if ( $PAGE->bodyid == 'page-my-index'):  ?>



						<ul class="nav nav-tabs mainProfileUvt" id="myTab" role="tablist">

							<li class="nav-item" role="presentation">
								<button class="nav-link active" id="home-tab" data-toggle="tab" data-target="#content-a" type="button" role="tab" aria-controls="home" aria-selected="true">
							
								<?php if (theme_mb2mclmain_isblock($PAGE, 'tab-a')) : ?>
									<?php echo $OUTPUT->blocks('tab-a', theme_mb2mclmain_block_cls($PAGE, 'tab-a','none')); ?>
								<?php endif; ?>


								</button>
							</li>
							<li class="nav-item" role="presentation">
								<button class="nav-link" id="profile-tab" data-toggle="tab" data-target="#content-b" type="button" role="tab" aria-controls="profile" aria-selected="false">
									
								<?php if (theme_mb2mclmain_isblock($PAGE, 'tab-b')) : ?>
									<?php echo $OUTPUT->blocks('tab-b', theme_mb2mclmain_block_cls($PAGE, 'tab-b','none')); ?>
								<?php endif; ?>

								</button>
							</li>
							<li class="nav-item" role="presentation">
								<button class="nav-link" id="contact-tab" data-toggle="tab" data-target="#content-c" type="button" role="tab" aria-controls="contact" aria-selected="false">
								
								<?php if (theme_mb2mclmain_isblock($PAGE, 'tab-c')) : ?>
									<?php echo $OUTPUT->blocks('tab-c', theme_mb2mclmain_block_cls($PAGE, 'tab-c','none')); ?>
								<?php endif; ?>
								
							</button>
							</li>
							<li class="nav-item" role="presentation">
								<button class="nav-link" id="contact-tab" data-toggle="tab" data-target="#content-d" type="button" role="tab" aria-controls="contact" aria-selected="false">
									

								<?php if (theme_mb2mclmain_isblock($PAGE, 'tab-d')) : ?>
									<?php echo $OUTPUT->blocks('tab-d', theme_mb2mclmain_block_cls($PAGE, 'tab-d','none')); ?>
								<?php endif; ?>								

								</button>
							</li>


						</ul>


						<div class="tab-content" id="myTabContent">

							<div class="tab-pane fade show active" id="content-a" role="tabpanel" aria-labelledby="content-a-tab">

							<!-- SECCION ACCESO RÁPIDO -->

							<div class="seccion-acceso-rapido">

							<div class="header-acceso mt-4 border-bottom">
								<h2> Aulas de Acceso Rápido </h2>
							</div>	
									<!-- CARDS CONTAINER -->
							<div class="card-container row py-5">

									<?php  // Nuevo front ?>
								
								<?php 

								/*
									$courses = get_courses();
									print_r($courses); 
									//ojo
									$courses2 = enrol_get_users_courses($USER->id, true);
									print_r($courses2); 
									//print_r($USER)
									$courses = enrol_get_my_courses();;
									print_r($courses); 

								*/
									
									
									$courses = enrol_get_my_courses();
									?>
									<?php
									foreach ($courses as $course): ?>

									
									<?php	$mycourse = get_course($course->id);
											//print_r($mycourse);
											//echo theme_mb2mclmain_course_panel(); // obtiene las actividades del curso
											//theme_mb2mclmain_get_section_activities(); // actividades de la sección
											// 🖖🏼 print_r(get_fast_modinfo($course->id)); // información detallada de los módulos del curso
											//✅ print_r(get_array_of_activities($course->id)); actividades del curso

											//Fecha del curso
											/*$timestamp = $mycourse->startdate;
											$formatted_date = date('Y-m-d', $timestamp);
											print_r($formatted_date); //1714194000*/
											

											//
									
											$category = $DB->get_record('course_categories',array('id'=>$mycourse->category));
											
											/*
											ver actividades
											$activities = get_array_of_activities($course->id);
											// Verificar si $activities es un array
											if (is_array($activities)) {
												// Recorrer el array con un bucle foreach
												foreach ($activities as $activity) {
													// Aquí puedes hacer lo que necesites con cada elemento del array
													print_r($activity);
												}
											} else {
												echo "No se encontraron actividades.";
											}
											*/

											

											
									?>




									
									<?php if($mycourse->category == 2 ) :?>
									
									<div class="card col-4 border mx-2 p-4">
										<h4 class="my-0"> <?php print_r($mycourse->fullname); ?> </h4>

										<!-- Barra de progreso -->
										
										<div class="barra py-2 mb-3 " style="position:relative">
											Avance <?php echo theme_mb2mclmain_dashboard_course_progress_bar($mycourse); ?>%
											<div class="counter" style="background:#59D06B; height:2px; width:<?php echo theme_mb2mclmain_dashboard_course_progress_bar($mycourse);?>%; border-radius:2px; position:relative; z-index:10"></div>
											<div class="counter" style="background:#dedede; height:2px; width:100%; border-radius:2px;position:absolute; margin-top:-2px"></div>
										</div>
										<!-- FIn Barra de progreso -->

										<div class="actividades">
											<div class="subtitle">
												<h5 class="my-0">Actividades Abiertas</h5>
											</div>

											<div class="items-container">

											<?php
											$activities = get_array_of_activities($course->id);
											foreach ($activities as $activity): ?>

												<!-- Actividad item -->
												<div class="actividad">
													<i class="fa fa-file-text-o"></i>
													<a href="#" class="d-inline-block p-2" style="color:#02172b; text-decoration:underline"> <?php print_r($activity->name); ?> </a>


													<?php  if (isset($activity->customdata['duedate'])) :?>
													<?php 
															$timestamp = $activity->customdata['duedate'];
															$formatted_date = date('d-m-Y', $timestamp);
															
													?>
													<span class="d-block mb-2" style="font-size:0.8rem; line-height: 0;"> Fecha de cierre <?php print_r($formatted_date); ?></span>
												
													<?php //print_r($activity); ?>
													
													
													<?php endif; ?>
												</div>
												<!-- Fin Actividad Item -->
	
												<?php endforeach; ?>

											</div>

										</div>

										<div class="programa d-flex justify-content-between align-items-center mt-3">	
											<span class="py-1 px-3" style=" border-radius:12px; background-color:#02172b; color:white; font-size:0.8rem"><?php echo $category->name ?></span>
											<a href="#" class="cta d-inline-block px-3 py-1" style="background-color:#f2de3c; color:#02172b; font-weight:bold; border-radius:2px ">Ir al curso</a>
										</div>

									</div>

									<?php endif;?>


									<?php endforeach; ?>
								
								<?php  // FIN Nuevo front ?>



							</div> 
								<!-- FIN CARD CONTAINER -->
								

							</div>
							<!-- FIN SECCIÓN ACCESO RÁPIDO -->



							<!-- SECCIÓN METACURSOS -->

							<div class="seccion-metacursos">

								<div class="header-acceso mt-4 border-bottom">
									<h2> Procesos de formación activos </h2>
								</div>

								<div class="card-container row py-5">

								<?php $metacourses = enrol_get_my_courses(); 
									foreach( $metacourses as $metacourse ):
								?>
									<?php if($metacourse->category == 3 ): ?>
											<!-- METACURSO -->
									<div class="card col-4 border mx-2 p-4">
										<div class="imagen mb-4" style="background:linear-gradient(180deg, rgba(218,216,60,1) 30%, rgba(101,215,164,1) 100%); height:128px">

										</div>
										<h4 class="mt-0 metacurso"><?php echo $metacourse->fullname ?></h4>
										<p>Pregrado</p>
										<a href="#"> Abrir</a>
									</div>
											<!-- FIN METACURSO -->
									<?php endif; ?>
								<?php endforeach; ?>
																				

								</div>

							</div>

							<!-- FIN SECCIÓN METACURSOS -->

							<!-- SECCIÓN AULAS HISTÓRICAS -->

							<div class="seccion-aulas">
								<div class="header-acceso mt-4 border-bottom">
									<h2> Aulas históricas </h2>
								</div>	
								<!-- FIN SECCIÓN AULAS HISTÓRICAS -->
								<div class="card-container row py-5">	
									<?php 
									$archives = enrol_get_my_courses();
									foreach($archives as $archived):?>

										<?php if($archived->category == 2 ): //DEfinir la categoría de los archivados ?>		
											<div class="card col-4 border mx-2 p-4">

													<h4 class="mt-0 metacurso"><?php echo $archived->fullname ?></h4>
													<p>Pregrado</p>
													<a href="#"> Abrir</a>
											</div>	
										<?php endif; ?>
										
										<?php endforeach; ?>
											
								</div>	
							</div>






								
								

								<?php if (theme_mb2mclmain_isblock($PAGE, 'content-a')) : ?>
									<?php echo $OUTPUT->blocks('content-a', theme_mb2mclmain_block_cls($PAGE, 'content-a','none')); ?>
								<?php endif; ?>
								
								

							</div>
							<div class="tab-pane fade" id="content-b" role="tabpanel" aria-labelledby="content-b-tab">

								<?php if (theme_mb2mclmain_isblock($PAGE, 'content-b')) : ?>
									<?php echo $OUTPUT->blocks('content-b', theme_mb2mclmain_block_cls($PAGE, 'content-b','none')); ?>
								<?php endif; ?>
						
							</div>
							<div class="tab-pane fade" id="content-c" role="tabpanel" aria-labelledby="content-c-tab">
									
								<?php if (theme_mb2mclmain_isblock($PAGE, 'content-c')) : ?>
									<?php echo $OUTPUT->blocks('content-c', theme_mb2mclmain_block_cls($PAGE, 'content-c','none')); ?>
								<?php endif; ?>

							</div>
							<div class="tab-pane fade" id="content-d" role="tabpanel" aria-labelledby="content-d-tab">
									
								<?php if (theme_mb2mclmain_isblock($PAGE, 'content-d')) : ?>
									<?php echo $OUTPUT->blocks('content-d', theme_mb2mclmain_block_cls($PAGE, 'content-d','none')); ?>
								<?php endif; ?>

							</div>


						</div>




					<?php endif; ?>










                	<?php echo $OUTPUT->main_content(); ?>
                    <?php if (theme_mb2mclmain_isblock($PAGE, 'content-bottom')) : ?>
                		<?php echo $OUTPUT->blocks('content-bottom', theme_mb2mclmain_block_cls($PAGE, 'content-bottom','none')); ?>
             		<?php endif; ?>
                    <?php echo theme_mb2mclmain_moodle_from(2017111300) ? $OUTPUT->activity_navigation() : ''; ?>
                	<?php echo $OUTPUT->course_content_footer(); ?>
                </div>
            </section>
            <?php if ($sidePre) : ?>
            	<div class="sidebar-col <?php echo $sidePreCol; ?>">
                	<?php echo $OUTPUT->blocks('side-pre', theme_mb2mclmain_block_cls($PAGE, 'side-pre','default')); ?>
                </div>
            <?php endif; ?>
            <?php if ($sidePost) : ?>
            <div class="sidebar-col <?php echo $sidePostCol; ?>">
            	<?php echo $OUTPUT->blocks('side-post', theme_mb2mclmain_block_cls($PAGE, 'side-post','default')); ?>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php echo theme_mb2mclmain_moodle_from(2018120300) ? $OUTPUT->standard_after_main_region_html() : '' ?>
<?php echo $OUTPUT->theme_part('bottom_info'); ?>
<?php echo $OUTPUT->theme_part('region_bottom_abcd'); ?>
<?php echo $OUTPUT->theme_part('footer_info'); ?>
<?php echo $OUTPUT->theme_part('footer', array('sidebar'=>$sidebar)); ?>
<?php echo $OUTPUT->theme_part('region_adminblock'); ?>
