<?php   // db_login.php
   
   
       $dbhost = 'localhost';
       $dbname = 'jukubox';
       $dbuser = 'avgdigital';
       $dbpass = 'Simba328xi123';
   
  $link = mysql_connect($dbhost, $dbuser, $dbpass) or die(mysql_error());
  mysql_select_db($dbname) or die(mysql_error());  ?>

