
<?php  echo '
	
			function finch_return_confirmation(response) { 
						$(".wait_img").remove(); console.log(response); 
						if ( response && response.error ) {
							alert(response.error);
						}
						else if ( response && ( response.refresh=="1" || response.price==0 ) ) {
							alert("'.esc_js($confirm_text).'");
							if ( response.gcal_url != "" ) {
								if ( response.gcal_same_window ) {
									window.open(response.gcal_url,"_self");
								}
								else {
									window.open(response.gcal_url,"_blank");
									window.location.href=app_location();
								}
							}
							else {
								window.location.href=app_location();
							}
							
							/* NHF CUSTOM CODE - send confirmation email */
							/* final_value - custon datatype for lesson information */  
							/* NFH */ 	
							/*var RequestQueryString = "LessonData=" + final_value + ""*/ ;
							alert(final_value);   
							/* generate_email();*/  
					 		/* $.ajax({  
  								type: "POST",  
								dataType: "JSON", 
  								url: "' .  get_home_url() . '/wp-admin/admin-ajax.php",  
  								data: "action=finchJsonTest",  
  								success: process_lesson_request,  
  								error: function(MLHttpRequest, textStatus, errorThrown){  
  									alert(errorThrown);
									alert("Something\'s not right!");   
  								}  
  							});   					

							function process_lesson_request(data) {
								alert("Hooray!");  
								console.log(data); 
								alert("Lesson cancelled!");
								window.location.href = window.location.href;  
							}  */ 
						}
						else if ( response ) {
							$(".appointments-paypal").find(".app_amount").val(response.price);
							$(".appointments-paypal").find(".app_custom").val(response.app_id);
							var old_val = $(".appointments-paypal").find(".app_submit_btn").val();
							var new_val = old_val.replace("PRICE",response.price).replace("SERVICE",response.service_name);
							$(".appointments-paypal").find(".app_submit_btn").val(new_val);
							var old_val2 = $(".appointments-paypal").find(".app_item_name").val();
							var new_val2 = old_val2.replace("SERVICE",response.service_name);
							$(".appointments-paypal").find(".app_item_name").val(new_val2);
							$(".appointments-paypal .app_submit_btn").focus();
							if ( response.gcal_url != "" ) {
								window.open(response.gcal_url,"_blank");
							}
							if ( response.mp == 1 ) {
								$(".mp_buy_form input[name=\'variation\']").val(response.variation);
								$(".mp_buy_form").show();
							}
							else {
								$(".appointments-paypal").show();							
							}
						}
						else{
							alert("'.esc_js(__('A connection problem occurred. Please try again.','appointments')).'");
						}
					}/*},"json");*/ '; // NHF - end of original $.post commented out
?>


<?php 

// Junk html - old buttons

// <input id="publishLink" onclick="javascript:startPublishing()" type="button" value="Start Publishing" style="display:none;"/> <input id="unpublishLink" onclick="javascript:stopPublishing()" type="button" value="Stop Publishing" style="display:none;" />

?> 
