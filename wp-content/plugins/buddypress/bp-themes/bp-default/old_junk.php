

<?php 
// get all the teachers who teach cello
// field id 7 => says whether student or teacher
// field id 2 => says what instrument they play (out of possible selections)
/* 
$all_teachers_query = "SELECT
				a.user_id, b.value
			FROM
				wp_bp_xprofile_data a
			INNER JOIN
				 wp_bp_xprofile_data b
			ON
				a.user_id = b.user_id
			WHERE
				a.field_id = 7
			AND
				a.value = 'Teacher'
			AND
				b.field_id = 2
			AND
				b.value LIKE '%cello%'
			GROUP BY
				b.value
			"; */ 
 

$all_teachers_query1 = "SELECT
				user_id
			FROM
				wp_bp_xprofile_data
			WHERE
				field_id = 7
			AND
				value = 'Teacher'
			"; 
//echo '<br />how many teachers? ';  finch_mysql_query($all_teachers_query1, "display") ;

$all_cello_query = "SELECT
				user_id, value
			FROM
				wp_bp_xprofile_data
			WHERE
				field_id = 2
			AND
				value LIKE '%cello%'
			"; 

//echo 'how many cellists? ';  finch_mysql_query($all_cello_query, "display") ;

					 

$all_teachers_query = "SELECT
				a.field_id, b.field_id AS bfield_id, a.user_id, a.value, b.value AS bvalue 
			FROM
				wp_bp_xprofile_data a
			RIGHT JOIN
				wp_bp_xprofile_data b
			ON
				a.user_id = b.user_id
			WHERE
				a.field_id = 2
			AND
				a.value LIKE '%\"cello\"%'
			AND
				b.field_id = 20
			AND
				b.value = 'Teacher'
			";
//echo 'big teacher join query: '; finch_mysql_query($all_teachers_query, "display"); 
 
/*  
$all_teachers_query_sql = mysql_query($all_teachers_query) or die(mysql_error()); 
while( $row = mysql_fetch_assoc($all_teachers_query_sql) ) { 

	$all_teacher_ids[] = $row; 

} 

echo '<pre>'; 
print_r($all_teacher_ids); 
echo '</pre>';  */ 
 
// echo '<script> alert("' . $the_user_ideeznuts . ' and userlogin: ' . $the_user_login . '  and userbio: ' . $user_bio . ' and instruments: ' . $user_instruments . '"); </script>'; 

// echo 'Name: '; 


$the_user_id = get_current_user_id(); 


/* bp_member_latest_update();
bp_member_ */  

//bp_get_profile_field_data( 'field=Biographical Information' );
/* 
$get_profile_meta = "SELECT 
				wp_bp_xprofile_data.*, 
				wp_bp_xprofile_fields.*

 			FROM
				wp_bp_xprofile_data
			INNER JOIN
				wp_bp_xprofile_fields
			ON
				wp_bp_xprofile_data.field_id = wp_bp_xprofile_fields.id
			WHERE
				wp_bp_xprofile_data.user_id = '" . $the_user_id . "'"; 
	$get_meta_query = mysql_query($get_profile_meta) or die (mysql_error()); 	while( $row = mysql_fetch_assoc($get_meta_query) ) 
	{ 
		$meta_data[] = $row; 

	} 	
echo '<pre>'; 
	print_r($meta_data); 
echo '</pre>'; */

?> 
