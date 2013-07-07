<?php 
require_once('all_includes.php'); 

$lessons_to_cancel = $_POST['LessonIdsToCancel']; 
$canceller = $_POST['canceller']; 

$stuffback['lessons to cancel'] = $lessons_to_cancel;
$stuffback['canceller'] = $canceller; 

$json_stuffback = json_encode($stuffback); 
echo $json_stuffback;   



?>
