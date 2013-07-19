<?php
//echo get_halfhour_price(9); 
print_r($_POST); 
function fTest_mail() { 

//	$fromheader = "From: finchman@gmail.com"; 
	$bccheader = "Bcc: finchman@gmail.com";
	//$headers[] = $fromheader; 
	$headers[] = $bccheader; 
	wp_mail( 'refunds@jukubox.com', 'test', 'testy', $headers  );


} 

//
//echo date("l, F j, Y, g:i a e"); 
//echo get_option('timezone_string');
//fTest_mail(); 
 //print_r($_POST); 

/*get_upcoming_lessons($user_id, 15, "Student");
if( is_teacher($user_id)===TRUE ) {   
	get_upcoming_lessons($user_id, 15, "Teacher"); 
}*/ 

//is_paid_service(2);
/*if( is_teacher($user_id) === TRUE ) {  
	appointments_to_confirm_as_teacher($user_id);
}*/ 
// Finch - dynamic custom style for homepage
if( is_page('home') ) { ?>
<style>
h2.pagetitle { display: none;}
.highlighty { color: #eff92a; }
div#sidebar { background: white; }
span#accTypeText { color: /*red;*/ /*#be102e;*/ #e94747;   }
#toploghome, .toploghome2 { margin-left: 15px; text-align: center; /*border-bottom: solid grey 1px !important;*/  padding-bottom: 8px; } 
.appointments-my-appointments  h3 { display: none; } 
}   
</style>
<?php } // endif ?>
<?php if( is_page('home') && !is_user_logged_in() ) { ?> 

<style>

body { 
	max-width: none; 
}

#nav_wrapper { 
	width: 1000px; 
	margin: 0 auto; 
} 
 
.f-part-wrap { 
	max-width: 1000px; 
	margin: 0 auto; 
}

.f-part-wrap small { 


} 
.f-part-divide { 
	padding: 20px 0px; 
	overflow: hidden; 	
}

.f-part-divide:first-child { 
	padding: 0px 0px; 
}  

.vertical-column-45, .vertical-column-55 { 
	float: left; 
} 

.vertical-column-45 { 
	width: 45%; 
} 

.vertical-column-55 { 
	width: 55%
} 

.nf-big-header { 
	color: #363636;
	font-size: 35px;
	line-height: 1.2;
	text-transform: uppercase;
}  

/*div#container h1, #toploghome { color: #63effc; }*/  
/* div#container, div#sidebar  { background: #1c1c1c !important; color: #43a3fb; } */ 
#toploghome { text-align: center; }  
.widget { /*display: none;*/  }
div#container { 
	width: auto !important;
	margin: 0; 
}  
div#sidebar { width: 290px; margin-left: -68px; }
#sidebar .padder { margin: 0 auto; }  
#centerer { margin-left: 37px; } 
#login_butt { 
	font-size: 21px; 
	height: 39px; 
	background: #008f01; 
	border: none;
	color: #ebebeb;
	margin-top: 10px; 
} 

#login_butt:hover { 
	background-color: #04f005; 
}
div#content .padder { 
	border-right: none; 
} 
div#sidebar { 
	border-left: none; 
} 
#feature_div { 
	display: block; 
}
#tophometable { 
	display: block; 
} 
  
div#loggedin_div { 
	display:none;
} 
/*div#content .padder { 
	margin-right: 0; 
}*/ 
#sidebar .padder { 
	
	border: solid 1px white;
	-moz-border-radius: 8px;
	-webkit-border-radius: 8px;
	border-radius: 8px; 	
	padding: 20px;
} 

#sidebar #centerer { 
	margin-left: 56px; 
}

#sidebar #centerer { 
	padding-top: 25px; 
}   
  
#first_content, #feature_div /*, #teach_prof_div*/   { 
	
/*	border: solid 1px white;
	-moz-border-radius: 8px;
	-webkit-border-radius: 8px;
	border-radius: 8px; */ 	
	padding: 20px; 
} 

#first_content { 
	/*text-align: center;*/ 
	/*margin-top: 30px;*/ 
	position: relative; 
	/*left: 5%;*/ 
	/*width: 33%;*/ 
	margin-bottom: 10px;	
	/*float: left;*/ 
	/*margin-right: 73px; */  
} 

#tophometable { 
	border: none; 
}

#tophometable td { 
	vertical-align: top; 
} 

div.post table td, div.page table td { 
	border-top: none; 
}

#first_content, #feature_div, #sidebar .padder, #teach_prof_div  { 
/*	background: rgba(0, 0, 0, 0.8);*/ 	
} 
/* div#container   { 
	background: transparent !important;
	background: rgba(0, 0, 0, 0.8) !important;  
}*/ 
div#container { 
	border-right: 0; 
}

#bottom_stuff table { 
	margin-bottom: 20px;
}

#teach_prof_div { 
	height: 252px;
	/*width: 950px; */  
}
body { 
	  
	/* NHF background experiment */ 
/*background: url('http://www.ionaudio.com/images/ces-2013/media/JukeboxBluetooth_Media.jpg') center top;
	background: url('http://binghall.stanford.edu/files/bing_ch_interior.jpg') center top;
	background: url('http://www.eu2005.lu/pictures/actualites_photos/06/26philharmonievuesallelarge.jpg') center top;
	background: url('http://www.southcoastmetro.com/images/photos/Concert_Hall.jpg') center top;
background-size: 1500px;*/ 	
} 

#navigation { 
/*	visibility: hidden;
	height: 11px;  */  
} 

/*#nav li { 
	display: none; 
} */ 

#navigation { 
	/*height: 30px; */ 
	border-bottom: none; 
	-webkit-box-shadow: #ccc 3px 3px 8px;
	-moz-box-shadow: #ccc 3px 3px 8px;
	box-shadow: #ccc 3px 3px 8px;
/*-webkit-box-shadow: 0px 2px 15px rgba(57, 72, 85, 0.6);
-moz-box-shadow: 0px 2px 15px rgba(57, 72, 85, 0.6);
box-shadow: 0px 2px 15px rgba(57, 72, 85, 0.6); */  
}

body { 
	width: auto; 
}
div#container { 
/*	width: 1000px;  
	margin: 0 auto; */  
  }  
.padder { 
	width: 1000px;
	margin: 0 auto !important;
}
 
</style>

<?php } ?>

<?php if( is_page('lesson-room') ):  ?>
<style>
#sidebar { 
	display: none; 
}
.padder{ 
	margin-right: 0px; 
}
#container { 
	width: 1200px !important; 
}   

</style>
<?php endif; ?>

<?php if( is_page('register') ):  ?>
<style>
.editfield:last-of-type, .editfield:nth-last-child(2) { 
display: none; 
} 
</style>
<?php endif; ?>
<?php if( !is_user_logged_in() ) : ?>
<style> 
.add-reviews { /*display: none;*/  } 
</style>
<?php endif; ?>
<style>
#friendship-button-<?php echo $user_id; ?> { 
	display: none; 

}
#add_review_<?php echo $user_id; ?> { 
	display: none; 
}  

</style>
<?php if( is_teacher($user_id) === 'nope') : ?>
<style>
.teachers_only_see { display: none; } 
.all_see { padding: 30px; border-left: none !important; } 
</style>
<?php endif; ?>

