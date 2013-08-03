<?php  ?>
<script>
	// custom javascript to create "confirm appointments" menu item
	var thing = "<?php global $current_user; get_currentuserinfo(); echo $current_user->user_login; ?>"; 
	//alert(thing); 
	var confirmlink = "<?php echo get_home_url() . '/members/' . $current_user->user_login . '/appointments/my-appointments/' ; ?>"; 
	//alert(confirmlink);
	
	jQuery('#nav').ready( function() {  
		jQuery('.finch-confirm-app a').attr("href", "" + confirmlink + ""); 	
	}); 
</script>
<?php  ?>

<script>
window['finch_home_url'] = "<?php echo get_home_url(); ?>"; 
window['finch_ajax_url'] = "<?php echo get_home_url(); ?>/wp-admin/admin-ajax.php";
window['finch_user_id'] = "<?php echo $user_id; ?>"; 
window['finch_user_name'] = "<?php echo $finch_user_name; ?>"; 
window['finch_user_email'] = "<?php echo $finch_user_email; ?>";  
window['finch_user_type'] = "<?php echo $user_type; ?>"; 

			 function generate_email(data_string, refresh) {
						//alert(data_string); 
						 
						$.ajax({  
  								type: "POST",  
								dataType: "JSON", 
  								url: "<?php echo get_home_url(); ?>/wp-admin/admin-ajax.php",  
  								data: "action=requestLessonApproval&"+ data_string + "",  
  								success: process_lesson_request,  
  								error: function(MLHttpRequest, textStatus, errorThrown){  
  									alert(errorThrown);
									alert("Something\'s not right!");   
  								}  
  							});   					

							function process_lesson_request(data) {
								//alert("Hooray!");  
								//console.log(data);
								if( refresh == "refresh" ) {  
									window.location.href = app_location(); 
								}  
								 
							}   
					}  // end function generate mail


function finch_ajax_request(action, data_string, success) {
						 
	$.ajax({  
  		type: "POST",  
		dataType: "JSON", 
  		url: "" + window['finch_ajax_url'] + "",  
  		data: "action=" + action + "&"+ data_string + "",  
  		success: success,  
  		error: function(MLHttpRequest, textStatus, errorThrown){  
  			alert(errorThrown);
			alert("Something\'s not right!");   
  		}  
  	});   					

								  
}  // end function finch_ajax_request


function all_same_height(element) { 
        var divlengths = []; 
        jQuery(element).each( function() { 
                var height = jQuery(this).height(); 
                //var name = jQuery(this).attr('id'); 
                //alert(name); 
                 //alert(height); 
                divlengths.push(height); 
        }); // end each

        function compare(a,b){
                return b-a;
        }
        console.log(divlengths);  
         divlengths.sort(compare); 
        console.log(divlengths); 
        var allheight = divlengths[0]; 

        jQuery(element).height( allheight);     
} 

// all javascript necessary for generating a new room and entering it 
jQuery('#newroomtable').ready(function() { 
	jQuery('#newRoomButton').click(function() {
	    if(window['finch_user_type'] == "Teacher") {  
		var DataString="getReturn=yes"; 
		var action="getNewRoomKey";
		//alert(window['finch_user_type']); 
		jQuery('#new_roomkey_form').addClass('loading');  
		finch_ajax_request(action, DataString, Loggy); 
		
		function Loggy(response) { 
			console.log(response);
			var newkey = response.passcode;
 			var newLink = window['finch_home_url'] + '/lesson-room/?room_key=' + newkey + ''; 
			//alert(newkey);
			jQuery('#newkey').html(newkey + '<br /><br /><strong>LINK TO SHARE:</strong><br /><br /><a href="' + newLink + '" target="_blank">' + newLink + '</a>');
			jQuery('#enter_room_key').attr("value", "" + newkey + "");   
			jQuery('#remindtext').show();  
		} 
		jQuery('#new_roomkey_form').removeClass('loading');
	    } // end if teacher
	    else { 
		alert('Only teachers can create new rooms!'); 	
	
	    } // end else (studnet)   
	}); // end click

	jQuery('#enterRoomPass').attr('action', '' +  window['finch_home_url'] + '/lesson-room/');

	jQuery('#enterRoomPass input[type="submit"]').click( function () {
		var keyInput = jQuery('#enter_room_key').val();
		if( !keyInput ) { 
			alert('You must input a room key code!'); 
			return false; 
		} // end if 
		else { 
			window.open('' + window['finch_home_url'] + '/lesson-room/?room_key=' + keyInput + '', '_blank' ); 
			return false; 
		} 	
	}); // end click  

}); // end ready

// set correct default values for name and email when requesting an appointment
jQuery('appointments-confirmation-wrapper').ready(function() { 
	jQuery('.appointments-name-field-entry').attr("value","" + window['finch_user_name'] + ""); 
	jQuery('.appointments-email-field-entry').attr("value", "" + window['finch_user_email'] + ""); 
}); // end ready


// make sub menu items the same width as their parents
jQuery('#nav').ready( function() { 
	jQuery('.sub-menu li').each( function() { 
		var width = jQuery(this).parent('ul').parent('li').width();
		//alert(width);  
		jQuery(this).css('width', width + 'px');
		jQuery(this).parent('ul').css('width', width + 'px'); 
	});// end each 
}); // end ready


jQuery('#bottom_stuff').ready(function() { 
	
	jQuery('.bxslider1, .bxslider').bxSlider({ 
		mode : 'fade',
		controls: 'false', 
		auto: 'true', 
		pause: 5000, 
/*		onSliderLoad: function()   { 	
	var height1 = jQuery('.bxslider1').height(); 
	alert(height1);  } */   	
	});  

		
	all_same_height('.finchsizer'); 	
}); // end bottom_stuff ready

jQuery('.bx-viewport').ready( function () { 

	// make boxes on homepage the same size. 

//	all_same_height('.bx-viewport'); 


	//all_same_height('.bx-slider li'); 	
 
}); // end ready 

<?php if( !is_user_logged_in() ) : ?>
jQuery(document).ready(function() { 
	jQuery('.loggedin_menu').remove(); 
}); // document.ready
<?php endif; ?>
<?php if( is_teacher($user_id) === 'nope' ) : ?>
jQuery('#nav').ready( function() { 
	jQuery('.finch-confirm-app').remove(); 
}); // end ready 
<?php endif; ?>
// nhf automatically reload page when changing lesson type selector 
jQuery(document).ready(function() { 
	jQuery('.app_select_services').change(function() { 
		jQuery('.app_services_button').click(); 
	}); // end change


}); // ready

</script>

<?php if( is_page('lesson-room') ): ?>
<script>
// Script for governing right publisher window
jQuery('.publisherContainer').ready( function() {
    var pubBox = jQuery('.publisherContainer');
    var initialPos = pubBox.offset().top;
    //alert( initialPos ) ;  
//    var rightPos = pubBox.offset(); 
//	alert(rightPos); console.log(rightPos);  
	jQuery(document).scroll( function() {
	
   	var initialLeftPos = pubBox.offset().left;  
        var position = window.pageYOffset;
        if( ( position > initialPos ) && ( !pubBox.hasClass('scrollyPublish') ) ) {
            pubBox.addClass('scrollyPublish');
	    pubBox.css("left",initialLeftPos );  
        }
        if ( ( position < initialPos ) && ( pubBox.is('.scrollyPublish') ) ) {
           pubBox.removeClass('scrollyPublish');
	   pubBox.css("left", "auto"); 
        }
    }); // end scroll



}); // end ready



</script>
<?php endif; ?>

<script>
jQuery('#aboutFounders').ready( function() {
    jQuery('#aboutFounders .founder_div a img').each( function() {  
	var origWidth = jQuery(this).outerHeight();
	var origHeight = jQuery(this).outerWidth();  
	//alert(origWidth + ' x ' + origHeight);
	var changeAmount = 8; 
	var newWidth = origWidth + changeAmount;  
	var newHeight = origHeight + changeAmount; 		
 	var margAmount = changeAmount / 2; 
	//alert(margAmount); 
	
	jQuery(this).parent('a').parent('div').css({ height: newHeight + "px", width: newWidth + "px"}); 	



	jQuery(this).hover(function() { 
		//alert('Hovering!');
		jQuery(this).stop().animate({ 
			width: newWidth + "px", 
			height: newHeight + "px",  
			/*marginLeft: "-" + changeAmount + "px", 
			marginTop: "-" + changeAmount + "px"*/  /*,
			marginRight: "-" + changeAmount + "px", 
			marginBottom: "-" + changeAmount + "px"*/ 
	
		}, 100, function(){    
				jQuery(this).parent('a').parent('div').stop().animate({ 
					borderTopColor: '#1fb3dd', 
					borderLeftColor: '#1fb3dd', 	
					borderRightColor: '#1fb3dd', 
					borderBottomColor: '#1fb3dd' 
				}, 150)				

			})   
	}, function(){ //alert('hovering out!'); 
	    
		jQuery(this).parent('a').parent('div').stop().animate({ 
			borderTopColor: 'transparent', 
			borderLeftColor: 'transparent', 	
			borderRightColor: 'transparent', 
			borderBottomColor: 'transparent' 
		}, 100); 
		jQuery(this).stop().animate({ 
			width: origWidth + "px", 
			height: origHeight + "px",
			/*marginLeft: "0px", 
			marginTop: "0px",
			marginRight: "0px", 
			marginBottom: "0px" */ 
	
		}, 100)   
	

	} 

	); // end hover
    }); // end each
}); // end aboutFounders ready
</script>


<?php if( is_page('home') && !is_user_logged_in() ) : ?> 
<script>
jQuery('.gk-features').ready( function() { 
	 
	var FeatBox = jQuery('.gk-features'); 
   	var FeatTopOffset = FeatBox.offset().top;
	var FeatTopThingie = FeatTopOffset - 500; 

	all_same_height('.gk-features a'); 
	//console.log(FeatTopOffset);  
	 //alert(FeatTopOffset); 
	//alert(FeatWindowPos);
	jQuery(document).scroll( function() { 
		//alert('scrolling!');
        	var FeatWindowPos = window.pageYOffset;
		//alert(FeatWindowPos); 
		if( (FeatWindowPos > FeatTopThingie) && (!FeatBox.hasClass('loaded')) ) { 
			
			FeatBox.children('a').each( function() { 
				jQuery(this).addClass('loaded'); 
			}); // end each  
			FeatBox.addClass('loaded'); 
		}
	}); // end scroll 
}); // end ready
</script>
<?php endif; ?>
<script>
jQuery(document).ready( function() { 
	var friendButt = jQuery('.friendship-button'); 

	if( friendButt.hasClass('not_friends') ) { 

		jQuery('#schedule-lesson').addClass('noFriends'); 
	} 
	


}); // end ready
jQuery('.priceForm').ready( function () { 
	jQuery('.SetHourPrice').priceFormat({ 
		limit:5, 
		clearPrefix: true,
		thousandsSeparator: '',
	}); 

}); // end ready
jQuery('#classRoomTrouble').ready( function() { 
	jQuery('#classRoomTrouble a').click( function() { 
		jQuery('#troubleInfo').slideToggle(400, function() { 

		}); // end slide	
	}); // end click 
}); // end ready
jQuery('.editfield input[name="field_28"]').ready(function() {
	
	var textlimit = 160; 
 
	jQuery('.editfield input[name="field_28"]').keyup(function(e) {
		var field = jQuery(this); 
            var tlength = jQuery(this).val(); 
		var tRealLength = tlength.length; 
		console.log(textlimit);  
		var tCutLength = tlength.substring(0,textlimit);
		var warnMes = jQuery('#finchLengthMes');  
		if( tRealLength > textlimit  ) { 
			/*alert('reached the limit!');
			alert(warnMes.length); */ 
			field.val(tCutLength);
			if(warnMes.length==0) {  
				field.before('<h3 id="finchLengthMes">This field can be only ' + textlimit + '  characters long</h3>'); 
			}  
		}
		else if( tRealLength < ( textlimit - 2 ) ) { 
			jQuery('#finchLengthMes').remove(); 
		} 
         }); 
}); // ready

// forces teachers to be signed up for at least one service
jQuery('#serviceForm').ready(function() { 
	jQuery('.serv_check').click( function() { 
	 	var jj = 0;
		jQuery('.serv_check').each( function() { 
			if( jQuery(this).is(':checked') ) { 
				jj++; 
			} 
		}); // end each  
		if( jj < 1 ) { 
			alert('You must be registered for one type of service');
			return false;  
		}  
	}); // end click
}); // end ready

/* jQuery('#signup_form, #profile-edit-form').ready(function() {
	
//	alert('hello!'); 
	  jQuery(this).submit(function(e) {
                var bdayVal = jQuery('#field_34').val(); 
                var match = /^(\d\d)\/(\d\d)\/(\d\d\d\d)$/.exec(bdayVal);
                if( !match ) { 
			jQuery('#field_34').focus();  
                        alert('Not a valid birthday!');
                        return false; 
                } else { 
			//alert( match );
			//console.log(match); 
			var d = new Date(match[3], match[1] - 1, match[2]);
			if ( d.getFullYear() != match[3] || d.getMonth() + 1 != match[1] || d.getDate() != match[2] ) { 
				jQuery('#signup_form #field_34').focus(); 
				alert('Not a valid birthday!');
				//alert(d.getFullYear() + ' vs ' + match[3]); 
				//alert((d.getMonth() + 1 ) + ' vs ' + (match[1] - 0) );
				//alert(d.getDate() + ' vs ' + match[2] ); i
				
				return false; 
			}
			//alert('A valid birthday!');   
			//return false; 
		} 
		
        
        }); // end submit 

 

}); // ready
 */ 

</script>
