<?php
function MailManagement($bookingId,$action)
{
	require_once(dirname(dirname(dirname( dirname( __FILE__ ) ))) . '/wp-config.php' );
	global $wpdb;
	$url = plugins_url('', __FILE__); 
	$bookingDetail = $wpdb->get_row
	(
	 	$wpdb->prepare
	 	(
			"SELECT CONCAT(".customersTable().".CustomerFirstName ,'  ',". customersTable().
			".CustomerLastName) as ClientName,".customersTable().".CustomerEmail,".customersTable().".CustomerMobile,". servicesTable(). ".ServiceName,". servicesTable(). ".ServiceId,"
			.employeesTable(). ".EmployeeName,".employeesTable(). ".EmployeeId,".employeesTable(). ".EmployeeEmail,".bookingTable().".Date,". bookingTable().".TimeSlot,
			". bookingTable().".BookingId, ". bookingTable().".PaymentStatus, ". bookingTable().".TransactionId, ". bookingTable().".PaymentDate,". bookingTable().
			".BookingStatus from ".bookingTable()." LEFT OUTER JOIN " .customersTable()." ON ".bookingTable().
			".CustomerId= ".customersTable().".CustomerId ". " LEFT OUTER JOIN " .employeesTable()." ON ".bookingTable().
			".EmployeeId=".employeesTable().".EmployeeId". " LEFT OUTER JOIN " .servicesTable()." ON ".bookingTable().
			".ServiceId=".servicesTable().".ServiceId where ".bookingTable().".BookingId =  ".$bookingId
		)
	);
	$title=get_bloginfo('name');
	$admin_email = get_option('bp_AdminEmail');
	if($admin_email = "")
	{
		$admin_email = get_settings('admin_email');
	}
	$to = $bookingDetail->CustomerEmail;
	$paymentStatus = $bookingDetail->PaymentStatus;
	$paymenTtransId = $bookingDetail->TransactionId;
	$paymentDate = $bookingDetail->PaymentDate;
	
	$dateFormat = $wpdb->get_var('SELECT GeneralSettingsValue FROM ' . generalSettingsTable() . ' where GeneralSettingsKey = "default_Date_Format"');											

	if($dateFormat == 0)
	{
	
		$date =  date("M d, Y", strtotime($bookingDetail->Date));
	
	}
	else if($dateFormat == 1)
	{
	
		$date =   date("Y/m/d", strtotime($bookingDetail->Date));
	
	}	
	else if($dateFormat == 2)
	{
	
		$date =  date("m/d/Y", strtotime($bookingDetail->Date));
	
	}	
	else if($dateFormat == 3)
	{
		$date =  date("d/m/Y", strtotime($bookingDetail->Date));
	}
	
	$getHours = floor(($bookingDetail->TimeSlot)/60);
	$getMins = ($bookingDetail->TimeSlot) % 60;
	$hourFormat = $getHours . ":" . $getMins;
	$timeFormats = $wpdb->get_var("SELECT GeneralSettingsValue FROM ".generalSettingsTable()." WHERE GeneralSettingsKey = 'default_Time_Format'");
	if($timeFormats == 0)
	{
		$time  = DATE("g:i a", STRTOTIME($hourFormat));
	}
	else 
	{
		$time  = DATE("H:i", STRTOTIME($hourFormat));
	}
	
    $currentDateComputer = date("Y-m-d");
	if($dateFormat == 0)
	{
	
		$currentDate =  date("M d, Y", strtotime($currentDateComputer));
	
	}
	else if($dateFormat == 1)
	{
	
		$currentDate =   date("Y/m/d", strtotime($currentDateComputer));
	
	}	
	else if($dateFormat == 2)
	{
	
		$currentDate =  date("m/d/Y", strtotime($currentDateComputer));
	
	}	
	else if($dateFormat == 3)
	{
		$currentDate =  date("d/m/Y", strtotime($currentDateComputer));
	}
	
	if($action == "approved")
	{
		
				$emailContent = $wpdb->get_var('SELECT EmailContent FROM  ' . email_templatesTable() . ' WHERE EmailType = ' . '"' . "booking-confirmation" . '"');	
			    $emailSubject = $wpdb->get_var('SELECT EmailSubject FROM  ' . email_templatesTable() . ' WHERE EmailType = ' . '"' . "booking-confirmation" . '"');
			   	$message_1 = str_replace("[client_name]", $bookingDetail->ClientName, stripcslashes($emailContent));
			    $message_2 = str_replace("[service_name]", $bookingDetail->ServiceName, $message_1);
			    $message_3 = str_replace("[booked_time]", $time, $message_2);
				$message_4 = str_replace("[employee_name]", $bookingDetail->EmployeeName, $message_3);
				$message_6 = str_replace("[companyName]", $title, $message_4);
			    $message_7 = str_replace("[booked_date]", $date, $message_6);
				$message =  str_replace("[date]", $currentDate, $message_7);
				$headers=  "From: " .$title. " <". $admin_email . ">" ."\n" .
				    	   "Content-Type: text/html; charset=\"" .
						    get_option('blog_charset') . "\n";
				$headers .= "Bcc: ".$bookingDetail->EmployeeEmail . "\n";
				
				wp_mail($to,$emailSubject,$message,$headers);
	}		
/***********************************************************************************************************************************************************/
	else if($action == "disapproved")
	{
			$emailContent = $wpdb->get_var('SELECT EmailContent FROM  ' . email_templatesTable() . ' WHERE EmailType = ' . '"' . "booking-disapproved" . '"');	
			$emailSubject = $wpdb->get_var('SELECT EmailSubject FROM  ' . email_templatesTable() . ' WHERE EmailType = ' . '"' . "booking-disapproved" . '"');
			
				$msg_1 = str_replace("[first name]", $bookingDetail->ClientName, stripcslashes($emailContent) );
	        	$msg_2 = str_replace("[service]", $bookingDetail->ServiceName, $msg_1);
	       		$msg_3 = str_replace("[date]", $date, $msg_2);
	        	$msg_4= str_replace("[time]", $time, $msg_3);
				$msg_5 = str_replace("[employee_name]", $bookingDetail->EmployeeName, $msg_4);
				$msg_7 = str_replace("[companyName]", $title, $msg_5);
				$headers=  "From: " .$title. " <". $admin_email . ">" ."\n" .
				    	   "Content-Type: text/html; charset=\"" .
						    get_option('blog_charset') . "\n";
							
				wp_mail($to,$emailSubject, $msg_7, $headers);    
			
	}
/***********************************************************************************************************************************************************/
	else if($action == "approval_pending")
	{
				$emailContent = $wpdb->get_var('SELECT EmailContent FROM  ' . email_templatesTable() . ' WHERE EmailType = ' . '"' . "booking-pending-confirmation" . '"');	
				$emailSubject = $wpdb->get_var('SELECT EmailSubject FROM  ' . email_templatesTable() . ' WHERE EmailType = ' . '"' . "booking-pending-confirmation" . '"');

					$message_1 = str_replace("[client_name]",  $bookingDetail->ClientName, stripcslashes($emailContent));
			    	$message_2 = str_replace("[service_name]", $bookingDetail->ServiceName, $message_1);
			    	$message_5 = str_replace("[booked_time]", $time, $message_2);
			    	$message_7 = str_replace("[companyName]", $title, $message_5);
			    	$message_8 = str_replace("[employee_name]", $bookingDetail->EmployeeName, $message_7);
			    	$message_final = str_replace("[booked_date]", $date, $message_8);
					$headers=  "From: " .$title. " <". $admin_email . ">" ."\n" .
				    	   "Content-Type: text/html; charset=\"" .
						    get_option('blog_charset') . "\n";
							
					wp_mail($to,$emailSubject,$message_final,$headers);
				
			
	}
/***********************************************************************************************************************************************************/
	else if($action == "admin")
	{
			$emailContent = $wpdb->get_var('SELECT EmailContent FROM  ' . email_templatesTable() . ' WHERE EmailType = ' . '"' . "admin-control" . '"');	
			$emailSubject = $wpdb->get_var('SELECT EmailSubject FROM  ' . email_templatesTable() . ' WHERE EmailType = ' . '"' . "admin-control" . '"');
				$msg_1 = str_replace("[client_name]", $bookingDetail->ClientName, stripcslashes($emailContent));
			    $msg_2 = str_replace("[service_name]", $bookingDetail->ServiceName, $msg_1);
			    $msg_3 = str_replace("[booked_time]", $time, $msg_2);
			    $msg_4= str_replace("[booked_date]", $date, $msg_3);
			    $approve = "<a href=\"$url/adminEmailLink.php?action=ApprovedLink&id=".$bookingId."\">Confirm Booking</a>";
			    $msg_5 = str_replace("[approve]", $approve, $msg_4);
			    $disapprove = "<a href=\"$url/adminEmailLink.php?action=DisapproveLink&id=".$bookingId."\">Dicline Booking</a>";
			    $msg_6 = str_replace("[deny]", $disapprove, $msg_5);
				$msg_7 = str_replace("[email_address]", $bookingDetail->CustomerEmail, $msg_6);
				$msg_8 = str_replace("[mobile_number]", $bookingDetail->CustomerMobile, $msg_7);
				$msg_9 = str_replace("[employee_name]", $bookingDetail->EmployeeName, $msg_8);
				$msg_10 = str_replace("[companyName]", $title, $msg_9);
				$headers=  "From: " .$title. " <". $admin_email . ">" ."\n" .
				    	   "Content-Type: text/html; charset=\"" .
						    get_option('blog_charset') . "\n";
							
				wp_mail($admin_email,$emailSubject,$msg_10,$headers);
				
	}

}

?>				