<?php
require_once(dirname(dirname(dirname( dirname( __FILE__ ) ))) . '/wp-config.php' ); 
$url = site_url();

if ($_FILES["file"]["error"] > 0) 
{
	echo "Error: " . $_FILES["file"]["error"] . "<br />";
}

else 
{
	if ((($_FILES["file"]["type"] == "image/gif") || ($_FILES["file"]["type"] == "image/jpeg") || ($_FILES["file"]["type"] == "image/png") || ($_FILES["file"]["type"] == "image/pjpeg"))) 
	{
		move_uploaded_file($_FILES["file"]["tmp_name"], "images/bookingImages/" . $_FILES["file"]["name"]);
		$filename = $_FILES["file"]["name"];
	} 
	else 
	{
		echo "choose correct format";
	}
}
global $wpdb;
$bookingImageName = $wpdb->get_var('SELECT GeneralSettingsValue FROM ' . generalSettingsTable().' where GeneralSettingsKey = "booking_image"');
if ($filename != $bookingImageName || $filename != "") 
{
	$wpdb->query
    (
    	$wpdb->prepare
        (
        	'UPDATE '. generalSettingsTable().' SET GeneralSettingsValue = %s WHERE GeneralSettingsKey = %s',
            $filename,
            "booking_image"
        )
    );
    echo "<script type='text/javascript'>window.location = '$url/wp-admin/admin.php?page=manageBookingForm';</script>";
}

?> 