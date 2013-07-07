<?php

global $bp;
$the_user_ideeznuts = $bp->loggedin_user->userdata->ID; 
$the_user_login = $bp->loggedin_user->userdata->user_login;
$the_user_email = $bp->loggedin_user->userdata->user_email;


global $finch_user_email; 
$finch_user_email = $the_user_email; 

global $user_id; 
$user_id = $the_user_ideeznuts;  
global $user_type; 
function is_teacher($user_id) {
	//global $user_id;  
	$is_teacher_query = "SELECT
					value
				FROM
					wp_bp_xprofile_data
				WHERE
					field_id = 20
				AND
					user_id = '" . $user_id . "'
				"; 
	$is_teacher_array = finch_mysql_query($is_teacher_query, "return"); 
	//finch_mysql_query($is_teacher_query, "display"); 

	
	if(  $is_teacher_array[0]['value'] == 'Teacher' ) { 
		//echo 'True!'; 
		return TRUE;
	} 
	else { 
		//echo 'FALSE!';
		return 'nope'; 
	} 

}

 
function is_teacher_two($user_id) {
	//global $user_id;  
	$is_teacher_query = "SELECT
					value
				FROM
					wp_bp_xprofile_data
				WHERE
					field_id = 20
				AND
					user_id = '" . $user_id . "'
				"; 
	$is_teacher_array = finch_mysql_query($is_teacher_query, "return"); 
	//finch_mysql_query($is_teacher_query, "display"); 

	
	if(  $is_teacher_array[0]['value'] == 'Teacher' ) { 
		//echo 'True!'; 
		return 'teacher';
	} 
	else { 
		//echo 'FALSE!';
		return 'student'; 
	} 

} 

if( is_teacher($user_id) === TRUE ) { 
	$user_type = "Teacher"; 
} 
else { 
	$user_type = "Student"; 
} 

$user_bio = bp_get_profile_field_data('field=6&user_id=' . $the_user_ideeznuts . '') ;
$user_instruments = bp_get_profile_field_data('field=2&user_id=' . $the_user_ideeznuts . '') ;



global $finch_user_name; 
$user_name = bp_get_profile_field_data('field=1&user_id=' . $the_user_ideeznuts . '') ;
$finch_user_name = $user_name; 



//echo $user_name; 
//echo '<pre>'; 
//print_r($user_instruments); 
//echo '</pre>';

$inst_string = $user_instruments[0] . ' and ' . $user_instruments[1]; 

// echo $user_name . ' plays ' . $inst_string  . ' and his bio is thus: ' . $user_bio; 


//print_r($_POST); 

/*function finch_mysql_query($QueryString, $display_or_return) { 

	$make_query = mysql_query($QueryString) or die(mysql_error()); 
	while ( $row = mysql_fetch_assoc($make_query) ) { 
		$all_rows_array[] = $row; 

	} 

	$all_rows_html = '<pre>' . print_r($all_rows_array, TRUE) . '</pre>'; 
	
	if( $display_or_return == "display" ) 
	{ 
		echo $all_rows_html; 
	} 
	else
	{ 
		return $all_rows_array;
	}  

} */ 

// see if current user is a teacher - if not, they must be a student

//echo '<br /><br />'; 
//is_teacher($user_id); 

function get_upcoming_lessons($user_id, $time_interval, $StudentOrTeacher) {  

	// This will get all upcoming lessons - can enter the room 15 minutes before up to 15 minutes after

	if( $StudentOrTeacher == "Teacher" ) { 
		$idTable = "worker";
		$titleMessage = "You have a lesson to teach right now!"; 
	 
	} 
	else { 
		$idTable = "user"; 
		$titleMessage = "You have a lesson right now!";  
	} 

	
	$upcoming_query = "SELECT
				wp_app_appointments.*, 
				wp_bp_xprofile_data.value AS worker_name,
				user_xprofile_table.value AS student_name, 
				wp_app_services.name AS service_name
			FROM
				wp_app_appointments
			INNER JOIN
				wp_bp_xprofile_data
			ON
				wp_app_appointments.worker = wp_bp_xprofile_data.user_id
			INNER JOIN
				wp_app_services
			ON
				wp_app_appointments.service = wp_app_services.ID
			INNER JOIN
				wp_bp_xprofile_data AS user_xprofile_table
			ON
				wp_app_appointments.user = user_xprofile_table.user_id
			WHERE
				wp_app_appointments." . $idTable . " = '" . $user_id . "'
			AND
				wp_app_appointments.status IN ('confirmed', 'completed', 'paid', 'reserved')
			AND

				 wp_app_appointments.start <= NOW() " /*.  " DATE_SUB(NOW(), INTERVAL " . $time_interval . " MINUTE)*/ . " 
			AND
				 wp_app_appointments.end >= NOW()  " /* DATE_SUB(NOW(), INTERVAL " . $time_interval . "  MINUTE) */  
				 /* wp_app_appointments.end >= NOW()*/ . "
 			AND
				wp_bp_xprofile_data.field_id = 1 
			AND
				user_xprofile_table.field_id = 1
			"; 
	$upcoming_array = finch_mysql_query($upcoming_query, "array");  
//	finch_mysql_query($upcoming_query, "display");

	if(!$upcoming_array) { 
		return false;
	}  
	$upcoming_html = '<div id="enter_app_room_wrap">'; 
	$upcoming_html .= '<h3 style="margin:0;margin-top: 10px; margin-bottom: 10px;">' . $titleMessage . '</h3><table><tbody>'; 
	
	foreach( $upcoming_array as $key => $value) {
		
		$lesson_id = $value['ID']; 

		$beg_time = strtotime($value['start']);  // scheduled start time
		$beg_date = date('M j, Y \a\t  g:i a', $beg_time);

		$beg_enter_time = $beg_time - ($time_interval*60);  // can enter the room 15 minutes before 
		$beg_enter_date =  date('Y-m-j g:i:s', $beg_enter_time);

		
		$end_time = strtotime($value['end']); 
		$end_enter_time = $end_time + ($time_interval*60); // can enter the room up to 15 minutes after lesson ends

		$end_date = date('M j, Y \a\t  g:i a', $end_time);
		$end_enter_date = date('Y-m-j g:i:s', $end_enter_time);

		//echo time() . " &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" . $beg_enter_time . '<br />';
		/* $time = time(); 
		if( $time >= $beg_enter_time ) {
			echo '<script>alert("Hello!");</script>'; 	
		}  */

		$enterable_lessons = Array();  // are there available lessons currently?  
	
		if( (time() >= $beg_enter_time) /*&& (time() <= $end_enter_time)*/   ) { 
			$can_enter = TRUE;
			$take_lesson_html = 'The Room is Open!<br /><input type="button" class="enter_room" value="Enter the Lesson Room!" goto="' . get_home_url() . '/lesson-room/?lesson_id=' . $lesson_id . '" />
			';  
			$enterable_lessons[] = "yes";  
		} 
		else { 
			$can_enter = FALSE; 
			$take_lesson_html = 'Room not yet available'; 
		}  	

		$teacher_name = $value['worker_name'];
		$student_name = $value['student_name'];
		
		if( $StudentOrTeacher == "Teacher" ) { 
			$other_person = $student_name;  
		} 
		else { 
			$other_person = $teacher_name; 
		} 
  
		$start_date = $beg_date;
		$service_type = $value['service_name'];  
	
		//echo $end_date . '&nbsp;&nbsp;&nbsp;&nbsp; ' . $end_enter_date . '&nbsp;&nbsp;&nbsp;&nbsp;' . $can_enter . '<br />';
		if( $can_enter == TRUE ) { 
			$upcoming_html .= "<tr><td> " . $service_type . " with " . $other_person . "<br /> on " . $beg_date . " <br />until " . $end_date . /*"<br />" . $beg_enter_date . "<br />" . $end_enter_date . */ "</td>";	
			$upcoming_html .= "<td>" . $take_lesson_html . "</td></tr>";  
		} 		 
	} 
	$upcoming_html .= "</tbody></table>";
	$upcoming_html .= "<script>
				jQuery('.enter_room').click(function() { 
					var link = jQuery(this).attr('goto'); 
					window.location = link; 					

				}); 
			  </script>";  
	$upcoming_html .= "</div><!--  enter_app_room_wrap --> "; 
	$num_enterable_lessons = count($enterable_lessons); 
	if( $enterable_lessons ) {  
		echo $upcoming_html; 
	} 
}  


function lesson_room_error_message() { 
	
	$error_html = '<script> window.location.href="' . get_home_url() . '/room-not-authorized/"</script>';
	echo $error_html;  
} 


function authorize_lesson_room($LessonId, $UserId ) {  // Is this user authorized to be here as either teacher or student?
	$error_html = '<script> window.location.href="' . get_home_url() . '/room-not-authorized/"</script>'; 
	if( !$LessonId ) { 
		echo $error_html; 
		return FALSE; 
	}  
 
	$authorize_query = "SELECT
					user, worker, start, end
				FROM
					wp_app_appointments
				WHERE
					ID = '" . $LessonId . "'
				"; 

	$authorize_array = finch_mysql_query($authorize_query, "return");
	//finch_mysql_query($authorize_query, "display");
	
	if( ($UserId == $authorize_array[0]['worker']) ||  ($UserId == $authorize_array[0]['user'])  ) { 
	
		$user_authorized = 1; 
		return TRUE; 
	} 
	else { 
		$user_authorized = 0; 
		echo $error_html;  
		return FALSE; 
	} 
	
	/*if( $user_authorized == 0 )  { 
		echo $error_html;  
		return FALSE; 
		//echo "User authorized!i";  		
	} 
	else { 
		return TRUE; 
	  	 //echo "User not  authorized!";
	} */  
} 







// functions to see if there are appointments to confirm
// does this service require payment
function is_paid_service($ServiceId) { 
	$service_info_query = "SELECT
					price
				FROM
					wp_app_services
				WHERE
					id = " . $ServiceId . "
				"; 
	$service_info_array = finch_mysql_query( $service_info_query, "return");
	//finch_mysql_query( $service_info_query, "display");  
	$price = $service_info_array[0]['price']; 
	if( $price == 0 ) { 
		
		//echo 'free!';  
		return FALSE;
	} 
	else { 
		
		//echo 'not free!'; 
		return TRUE; 
	} 

} 

// appointments the teacher should confirm
function appointments_to_confirm_as_teacher($UserId) {
	global $current_user;  get_currentuserinfo(); 
	$appointments_query = "SELECT
					* 
				FROM
					wp_app_appointments
				WHERE
					worker = " . $UserId . " 
				AND
					status IN ('pending', 'paid')  
				AND
					start >= NOW()
				"; 
	$appointments_array = finch_mysql_query($appointments_query, "return");
	//finch_mysql_query($appointments_query, "display"); 
	
	//$num_confirm_appointments = 1;
	if( ! $appointments_array) { 
		return false;
	} 
	$num_confirm_appointments = 0; 
	foreach( $appointments_array as $key => $value ) { 
		if( $value['status'] == 'pending') { 
			// appointment is pending - does it require payment?
			$service_id = $value['service'];  
			
			if(is_paid_service($service_id) === FALSE) { 
				$add_service = TRUE; 
				$num_confirm_appointments++; 
			} 
			else { 
				$add_service = FALSE;

				// NHF - added this in - paid services that are pending
					// must also be included in count
				$num_confirm_appointments++;  
			}   // end if/else				

		} // end if
		else  // isn't pending, must be paid
		{ 		
			$num_confirm_appointments++; 
		} 
	} // end foreach

	//echo $num_confirm_appointments;
	if( $num_confirm_appointments > 1 ) { 
		$apptext = "appointments"; 
	} 
	else { 
		$apptext = "appointment"; 
	} // end ifelse  

	$titleMessage = "You have " . $num_confirm_appointments . " requested " . $apptext . " to confirm!";

	$confirmLink =  '<input type="button" class="conf_app" value="Confirm Appointments" goto="' . get_home_url() . '/members/' . $current_user->user_login . '/appointments/my-appointments/" style="margin-top: -6px; margin-left: 12px;"/>';
	$confirmLink .= '<script>
				jQuery(".conf_app").click( function() { 
					var link = jQuery(this).attr("goto"); 
					window.location = link; 
				}); // end click
			</script>'; 	
 
	$confirm_html = '<div class="confirmdiv" style="margin-top: 10px;"><span style="margin:0;margin-top: 10px; font-weight: bold; font-size: 17px">' . $titleMessage . '</span>'; 
	$confirm_html .= '<span style="/*float: right;*/ ">' . $confirmLink . ' </span></div>';
	echo $confirm_html; 	
} 


?>
