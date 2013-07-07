<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package WordPress
 * @subpackage Twenty_Eleven
 * @since Twenty Eleven 1.0
 */

get_header(); ?>

		<div id="primary">
			<div id="content" role="main">
				
				<?php 

					 
					 $lesson = "SELECT 
							juku_lessons.lesson_id,
							juku_lessons.lesson_code,
							juku_lessons.student_id,
							juku_students.name AS student_name,
							juku_lessons.teacher_id,
							juku_teachers.name AS teacher_name, 
							juku_instruments.name AS instrument, 
							juku_lessons.lesson_hour_duration,
							juku_lessons.lesson_date, 
							juku_lessons.session_id
						FROM
							juku_lessons
						INNER JOIN
							juku_students
						ON
							juku_lessons.student_id = juku_students.id
						INNER JOIN
							juku_teachers
						ON
							juku_lessons.teacher_id = juku_teachers.id
						INNER JOIN
							juku_instruments
						ON
							juku_teachers.instrument = juku_instruments.id
					";  
							 


					$lesson_query = mysql_query($lesson) or die(mysql_error()); 
					while ($lesson_array = mysql_fetch_assoc($lesson_query) )
					{ 
						$lesson_all_array[] = $lesson_array; 
					} 
	
					/* print_r($lesson_all_array); 
					echo 'Hello world 2!';*/ 

				foreach($lesson_all_array as $key => $value ) { 
					$lesson_id = $value['lesson_id']; 
					$student_name = $value['student_name'];
					$teacher_name = $value['teacher_name'];
					$instrument = $value['instrument'];		
					$lesson_duration = $value['lesson_hour_duration'];
					$lesson_date = $value['lesson_date'];
					$session_id = $value['session_id'];
					echo '<br />'; 	
					echo 'Lesson ID: ' . $lesson_id . '<br />Student name: ' . $student_name . '<br />Teacher name: ' . $teacher_name . '<br />Instrument: ' . $instrument . '<br />Duration: ' . $lesson_duration . ' hour.<br />Lesson date and time: ' . $lesson_date . '<br />' . $session_id .  '<br />
					<a href="http://www.avgdigital.co/jukubox/take-lesson/?lesson_id=' . $lesson_id . '&session_id=' . $session_id . '">Take this lesson!</a><br />';   


				} 

					

	


				?>


				<?php while ( have_posts() ) : the_post(); ?>

					<?php get_template_part( 'content', 'page' ); ?>

					<?php comments_template( '', true ); ?>

				<?php endwhile; // end of the loop. ?>

			</div><!-- #content -->
		</div><!-- #primary -->

<?php get_footer(); ?>
