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

							<div class="header-acceso mt-4 border-bottom pt-5 pl-4 pb-4" style="background-image:url(https://img.playbook.com/9ZnGzQNH478OK9w9ak51tzDoS7EALoui74lDQyvvHvA/Z3M6Ly9wbGF5Ym9v/ay1hc3NldHMtcHVi/bGljLzE1MzMzMDdm/LTM3YWMtNDc3MS05/YmZhLWU0YTg4ZDY1/MTQ4Ng);background-size:cover;border-radius:0.4rem 0.4rem 0 0; margin-left:-0.80rem">
								<h2> <i class="fas fa-rocket"></i> Aulas de Acceso Rápido </h2>
							</div>	
									<!-- CARDS CONTAINER -->
							<div class="cardlists-container justify-content-center justify-content-md-start row py-5" style="row-gap: 1rem;">

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
									
									
									$courses = enrol_get_my_courses('enddate');
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




									
									<?php 

									$current_time = time();
									if($mycourse->category != 29 && $mycourse->enddate > $current_time ) :?>
									
									<div class="card col-11 col-md-3 border mx-2 p-3">
										<h4 class="my-0 " style="font-size:1.25rem;"> <i class="fas fa-chalkboard" style="color:#00B4DD; display:inline-block; margin-right:4px"></i> <?php print_r($mycourse->fullname); ?> </h4>

												<?php 
										$modlink = new moodle_url( '/course/view.php', array('id'=>$course->id) );
										?>
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
<!-- +=========================+ -->


<div class="items-container">
    <?php
    $display = 'd-block';
    $activities = get_array_of_activities($course->id);
    $MAX_NUM_ACTIVITIES = 2;
    $current_time = time(); // Obtener el tiempo actual
    $activities_shown = 0; // Contador de actividades mostradas
    $activities_found = false; // Variable para rastrear si se han encontrado actividades válidas
    $additional_activities = []; // Almacenar actividades adicionales

    foreach ($activities as $activity): 
        // Filtro que no se muestre las que son tipo label
        if ($activity->mod !== 'label'):
            // Verificar y mostrar las fechas si están presentes
			$timestamp = null;
            $date_label = '';            

            if (isset($activity->customdata['cutoffdate'])) {
                $timestamp = $activity->customdata['cutoffdate'];
                $date_label = 'Fecha límite: ';
            } elseif (isset($activity->customdata['duedate'])) {
                $timestamp = $activity->customdata['duedate'];
                $date_label = 'Fecha de entrega: ';
            } elseif (isset($activity->customdata['timeclose'])) {
                $timestamp = $activity->customdata['timeclose'];
                $date_label = 'Fecha de cierre: ';
            } elseif (isset($activity->customdata['allowsubmissionsfromdate'])) {
                $timestamp = $activity->customdata['allowsubmissionsfromdate'];
                $date_label = 'Fecha de inicio de entregas: ';
            } elseif (isset($activity->customdata['deadline'])) {
                $timestamp = $activity->customdata['deadline'];
                $date_label = 'Fecha límite: ';
            }

            // Verificar la fecha en availability
            $availability_timestamp = null;
            if (isset($activity->availability)) {
                $availability_data = json_decode($activity->availability, true);
                if ($availability_data !== null && isset($availability_data['c'][0]['t'])) {
                    $availability_timestamp = $availability_data['c'][0]['t'];
                }
            } elseif (isset($activity->customdata['timeopen'])) {
                $availability_timestamp = $activity->customdata['timeopen'];
            }

            // Comprobar que la actividad esté dentro del rango de fechas: current_time >= availability y current_time <= fecha límite
            if ($timestamp !== null && ($availability_timestamp === null || $current_time >= $availability_timestamp) && $current_time <= $timestamp):
                $activities_found = true; // Marcar que se ha encontrado al menos una actividad válida
                $formatted_date = date('d-m-Y', $timestamp);
                $modlink2 = new moodle_url('/mod/' . $activity->mod . '/view.php', array('id' => $activity->cm));
                
                if ($activities_shown < $MAX_NUM_ACTIVITIES):
                    $activities_shown++; // Incrementar el contador de actividades mostradas
                    ?>
                    <!-- Actividad item -->
                    <div class="actividad">
                        <i class="fa fa-file-text-o"></i>
                        <a href="<?php echo $modlink2 ?>" class="d-inline-block p-2" style="color:#02172b; text-decoration:underline">
                            <?php echo $activity->name; ?>
                        </a>
                        <span class="d-block mb-2" style="font-size:0.8rem; line-height: 0;"><?php echo $date_label . $formatted_date; ?></span>
                    </div>
                    <!-- Fin Actividad Item -->
                <?php
                else:
                    // Agregar actividad a la lista de adicionales
                    $additional_activities[] = [
                        'modlink' => $modlink2,
                        'name' => $activity->name,
                        'date_label' => $date_label,
                        'formatted_date' => $formatted_date
                    ];
                endif;
            endif;
        endif;
    endforeach;

    if (!$activities_found): // Si no se ha encontrado ninguna actividad válida
        ?>
        <p>No hay actividades abiertas.</p>
        <?php $display = 'd-none' ?>
    <?php endif; ?>

    <?php 
    if ($activities_found && count($additional_activities) > 0): ?>
        <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#additionalActivities" aria-expanded="false" aria-controls="additionalActivities">
            Ver más actividades
        </button>
        <div class="collapse" id="additionalActivities">
            <?php foreach ($additional_activities as $activity): ?>
                <!-- Actividad adicional item -->
                <div class="actividad">
                    <i class="fa fa-file-text-o"></i>
                    <a href="<?php echo $activity['modlink'] ?>" class="d-inline-block p-2" style="color:#02172b; text-decoration:underline">
                        <?php echo $activity['name']; ?>
                    </a>
                    <span class="d-block mb-2" style="font-size:0.8rem; line-height: 0;"><?php echo $activity['date_label'] . $activity['formatted_date']; ?></span>
                </div>
                <!-- Fin Actividad adicional item -->
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>


<!-- +=========================+ -->



										</div>

										<div class="programa  mt-3">	
											<span class="py-0 px-1" style="display:inline-block; border-radius:4px; background-color:#02172b; color:white; font-size:0.7rem"><?php echo $category->name ?></span>
											<div class="separator" class="d-block"></div>
											<a href="<?php echo $modlink  ?>" class="cta d-inline-block px-3 py-1 mt-1" style="background-color:#f2de3c; color:#02172b; font-weight:bold; border-radius:4px; font-size:0.8rem ;">Ir al curso</a>
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


<?php
// Obtener los metacursos
$metacourses = enrol_get_my_courses();
$metacourses_found = false;

// Verificar si hay metacursos en la categoría específica
foreach ($metacourses as $metacourse) {
    if ($metacourse->category == 29) {
        $metacourses_found = true;
        break;
    }
}
?>
<!-- SECCIÓN METACURSOS -->


<?php
// Obtener los metacursos
$metacourses = enrol_get_my_courses();
$metacourses_found = false;

// Verificar si hay metacursos en la categoría específica
foreach ($metacourses as $metacourse) {
    if ($metacourse->category == 29) {
        $metacourses_found = true;
        break;
    }
}
?>

<?php if ($metacourses_found): ?>
    <!-- SECCIÓN METACURSOS -->
    <div class="seccion-metacursos">
        <div class="header-acceso mt-4 border-bottom pt-5 pl-4 pb-4" style="background-image:url(https://img.playbook.com/QKPmHUmuFWOZP3BNwdTVlp8BF5DsBt1yWJuCzLKdsp0/Z3M6Ly9wbGF5Ym9v/ay1hc3NldHMtcHVi/bGljLzMyYThlY2Nj/LWY4NzQtNDE5ZS1h/YTkxLTYzNWExODdi/NGNmYw);background-size:cover;border-radius:0.4rem 0.4rem 0 0; margin-left:-0.80rem">
            <h2> <i class="fas fa-cubes"></i> Procesos de formación activos</h2>
        </div>

        <div class="cards-container justify-content-center justify-content-md-start row py-5">
            <?php foreach ($metacourses as $metacourse): ?>
                <?php if ($metacourse->category == 29): ?>
                    <?php 
                        $modlink3 = new moodle_url('/course/view.php', array('id' => $metacourse->id));
                    ?>
                    <!-- METACURSO -->
                    <div class="card col-11 col-md-3 border mx-2 p-4">
                        <h4 class="mt-0 metacurso"> 
                            <a href="<?php echo $modlink3 ?>" style="display:block; width:100%; height:100%; font-size:1.25rem">
                                <i class="fas fa-folder d-inline-block mr-1"></i>  <?php echo $metacourse->fullname ?>
                            </a>
                        </h4>
                        <a href="<?php echo $modlink3 ?>"> Abrir</a>
                    </div>
                    <!-- FIN METACURSO -->
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    </div>
    <!-- FIN SECCIÓN METACURSOS -->
<?php endif; ?>


							<!-- FIN SECCIÓN METACURSOS -->


<!-- SECCIÓN AULAS HISTÓRICAS -->

<?php
$archives = enrol_get_my_courses('enddate'); // Obtener todos los cursos archivados
$current_time = time(); // Obtener el tiempo actual

// Filtrar cursos archivados válidos
$filtered_archives = array_filter($archives, function($archived) use ($current_time) {
    return $archived->enddate < $current_time && $archived->category != 29;
});

// Verificar si hay cursos archivados válidos
$has_archived_courses = !empty($filtered_archives);
?>

<?php if ($has_archived_courses): ?>
    <div class="seccion-aulas">
        <div class="header-acceso mt-4 border-bottom pt-5 pl-4 pb-4" style="background-image:url('https://img.playbook.com/2GWxFcRUx6v8AIwNR6E6L69kCwjLPScmRC_YE39LETg/Z3M6Ly9wbGF5Ym9v/ay1hc3NldHMtcHVi/bGljL2U0OTNkMmJh/LWM1ODMtNGVjNy05/Y2Q5LWMyMjdmNjEz/YTBkOA');background-size:cover;border-radius:0.4rem 0.4rem 0 0; margin-left:-0.80rem">
            <h2> <i class="fas fa-history"></i> Aulas históricas </h2>
        </div>
        
        <div class="cards-container row py-5 justify-content-center justify-content-md-start align-items-start">
            <?php 
            $course_count = 0;
            foreach($filtered_archives as $archived):
                $formatted_course_date = date('d-m-Y', $archived->enddate);
                $modlink4 = new moodle_url('/course/view.php', array('id' => $archived->id));
                
                if ($course_count < 3): 
            ?>
                    <div class="card col-11 col-md-3 border mx-2 p-3">
                        <h4 class="mt-0 metacurso" style="font-size:1.25rem"> <i class="fas fa-archive d-inline-block mr-1"></i>  <?php echo $archived->fullname; ?></h4>
                        <a href="<?php echo $modlink4; ?>"> Ir al curso </a>
                        <p style="font-size:0.8rem">Fecha de finalización: <?php echo $formatted_course_date; ?></p>
                    </div>
            <?php 
                else: 
            ?>
                    <div class="card col-11 col-md-3 border mx-2 p-3 collapse" id="additionalCourses">
                        <h4 class="mt-0 metacurso" style="font-size:1.25rem"> <i class="fas fa-archive d-inline-block mr-1"></i>  <?php echo $archived->fullname; ?></h4>
                        <a href="<?php echo $modlink4; ?>"> Ir al curso </a>
                        <p style="font-size:0.8rem">Fecha de finalización: <?php echo $formatted_course_date; ?></p>
                    </div>
            <?php 
                endif; 
                $course_count++;
            endforeach; 
            ?>
        </div>

        <?php if ($course_count > 3): ?>
            <div class="text-center my-3">
                <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#additionalCourses" aria-expanded="false" aria-controls="additionalCourses">
                    Otras asignaturas
                </button>
            </div>
        <?php endif; ?>
    </div>
<?php endif; ?>

<!-- FIN SECCIÓN AULAS HISTÓRICAS -->







								
								

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
