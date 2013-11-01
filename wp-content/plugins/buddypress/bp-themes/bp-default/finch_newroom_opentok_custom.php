
<?php
    // include opentok sdk
	$get_lesson_id = htmlentities(mysql_real_escape_string($_GET['lesson_id'])); 

	authorize_lesson_room($get_lesson_id, $user_id); // is the user authorized to be here?  If not, redirect to an error page

echo $get_lesson_id; 	
//echo $get_session_id . '<br />';
//	if($get_session_id  == '') { echo 'no session id!<br />'; } 

//$pass = substr(md5(uniqid(mt_rand(), true)) , 0, 8);

//echo '<script>alert("' . $pass . '");</script>';  
// check if lesson has session_id

	$check_session_id = "SELECT
				wp_app_appointments_meta.value, wp_app_appointments.*
			FROM
				wp_app_appointments_meta
			INNER JOIN
				wp_app_appointments
			ON
				wp_app_appointments_meta.lesson_id = wp_app_appointments.id
			WHERE
				lesson_id = '" . $get_lesson_id . "'
			AND 
				meta_type = 'session_id'  
			"; 
	$check_session_array = finch_mysql_query($check_session_id, "return"); 
	
	$db_session_id = $check_session_array[0]['value']; 

	/* if($db_session_id == '') 
	{ 
		$is_session_id = FALSE; 
	} 
	else
	{ 	
		$is_session_id = TRUE; 
	} */ 


    require_once 'Opentok-PHP-SDK-master/OpenTokSDK.php';
    require_once 'Opentok-PHP-SDK-master/OpenTokArchive.php';
    require_once 'Opentok-PHP-SDK-master/OpenTokSession.php';

    $apiKey = '13712412'; 
    $apiSecret = 'cfb5605dadf94424ecbb0602dbb5356e0f5e5f4c'; 

    // Creating an OpenTok Object
    $apiObj = new OpenTokSDK($apiKey, $apiSecret); 
// SESSIONS - if session id already exists, use that.  If not, create one.  

if( $db_session_id ) {
	$session = $db_session_id; 
} 
else
{ 
 
    // Creating Simple Session object, passing IP address to determine closest production server
//$session = $apiObj->createSession( $_SERVER["REMOTE_ADDR"] );

// Creating Simple Session object 
// Enable p2p connections
$session = $apiObj->createSession( $_SERVER["REMOTE_ADDR"], array(SessionPropertyConstants::P2P_PREFERENCE=> "enabled") ); 

      //echo $session . '<br />';
	
	/*$insert_session_id = "UPDATE 
					juku_lessons
				SET
					session_id = '" . $session . "' 
				WHERE
					lesson_id = '" . $get_lesson_id . "'
			    "; */ 

	$insert_session_id = "INSERT INTO 
					wp_app_appointments_meta(
						lesson_id, 
						value,
						meta_type ) 
					VALUES( 
						'" . $get_lesson_id . "',
						'" . $session . "',
						'session_id'
					)";  
						 
				

	$insert_session_id_query = mysql_query($insert_session_id) or die(mysql_error());  
 
} 


	$sessionId = $session; 

	// After creating a session, call generateToken(). Require parameter: SessionId
       // $token = $apiObj->generateToken($sessionId);

	// Giving the token a moderator role, expire time 5 days from now, and connectionData to pass to other users in the session
	$token = $apiObj->generateToken($sessionId, RoleConstants::MODERATOR, time() + (5*24*60*60), "hello world!" );
	// echo $token;

?>


<script src="http://static.opentok.com/webrtc/v2.0/js/TB.min.js" ></script>
 

<script type="text/javascript">

       var apiKey = '<?php echo $apiKey; ?>'; 
    var sessionId = '<?php echo $sessionId; ?>'; 
    var token = '<?php echo $token; ?>'; 


    TB.setLogLevel(TB.DEBUG);

   // var session = TB.initSession(sessionId);
    // session.addEventListener('sessionConnected', sessionConnectedHandler);
   // session.connect(apiKey, token);
    
    var publisher;
    var subscribers = {};
    var VIDEO_WIDTH = 320;
    var VIDEO_HEIGHT = 240;

    TB.addEventListener("exception", exceptionHandler);

    if (TB.checkSystemRequirements() != TB.HAS_REQUIREMENTS) {
			alert("You don't have the minimum requirements to run this application."
				  + "Please upgrade to the latest version of Flash.");
		} else {
			session = TB.initSession(sessionId);	// Initialize session

			// Add event listeners to the session
			session.addEventListener('sessionConnected', sessionConnectedHandler);
			session.addEventListener('sessionDisconnected', sessionDisconnectedHandler);
			session.addEventListener('connectionCreated', connectionCreatedHandler);
			session.addEventListener('connectionDestroyed', connectionDestroyedHandler);
			session.addEventListener('streamCreated', streamCreatedHandler);
			session.addEventListener('streamDestroyed', streamDestroyedHandler);
		}
 
     // alert(TB.checkSystemRequirements() ) ; 
  
   //--------------------------------------
   //  LINK CLICK HANDLERS
   //--------------------------------------

		/*
		If testing the app from the desktop, be sure to check the Flash Player Global Security setting
		to allow the page from communicating with SWF content loaded from the web. For more information,
		see http://www.tokbox.com/opentok/build/tutorials/helloworld.html#localTest
		*/
		function connect() {
			session.connect(apiKey, token);
		}

		function disconnect() {
			session.disconnect();
			hide('disconnectLink');
			hide('publishLink');
			hide('unpublishLink');
		}

		// Called when user wants to start publishing to the session
		function startPublishing() {
			if (!publisher) {
				var parentDiv = document.getElementById("myCamera");
				var publisherDiv = document.createElement('div'); // Create a div for the publisher to replace
				publisherDiv.setAttribute('id', 'opentok_publisher');
				parentDiv.appendChild(publisherDiv);
				var publisherProps = {width: VIDEO_WIDTH, height: VIDEO_HEIGHT};
				publisher = TB.initPublisher(apiKey, publisherDiv.id, publisherProps);  // Pass the replacement div id and properties
				session.publish(publisher);
				show('unpublishLink');
				hide('publishLink');
			}
		}

		function stopPublishing() {
			if (publisher) {
				session.unpublish(publisher);
			}
			publisher = null;

			show('publishLink');
			hide('unpublishLink');
		}

    //--------------------------------------
    //  OPENTOK EVENT HANDLERS
    //--------------------------------------




  /*  OLD NHF HANDLERS  

    function sessionConnectedHandler(event) {
      publisher = TB.initPublisher(apiKey, 'myPublisherDiv');
      session.publish(publisher);

      // Subscribe to streams that were in the session when we connected
      subscribeToStreams(event.streams);
    }

    function streamCreatedHandler(event) {
      // Subscribe to any new streams that are created
      subscribeToStreams(event.streams);
    }

    function subscribeToStreams(streams) {
      for (var i = 0; i < streams.length; i++) {
        // Make sure we don't subscribe to ourself
        if (streams[i].connection.connectionId == session.connection.connectionId) {
          return;
        }

        // Create the div to put the subscriber element in to
        var div = document.createElement('div');
        div.setAttribute('id', 'stream' + streams[i].streamId);
        document.body.appendChild(div);

        // Subscribe to the stream
        session.subscribe(streams[i], div.id);
      }  


    } */ 

                //--------------------------------------
		//  OPENTOK EVENT HANDLERS
		//--------------------------------------

		function sessionConnectedHandler(event) {
			// Subscribe to all streams currently in the Session
			for (var i = 0; i < event.streams.length; i++) {
				addStream(event.streams[i]);
			}
			show('disconnectLink');
			show('publishLink');
			hide('connectLink');
		}

		function streamCreatedHandler(event) {
			// Subscribe to the newly created streams
			for (var i = 0; i < event.streams.length; i++) {
				addStream(event.streams[i]);
			}
		}

		function streamDestroyedHandler(event) {
			// This signals that a stream was destroyed. Any Subscribers will automatically be removed.
			// This default behaviour can be prevented using event.preventDefault()
		}

		function sessionDisconnectedHandler(event) {
			// This signals that the user was disconnected from the Session. Any subscribers and publishers
			// will automatically be removed. This default behaviour can be prevented using event.preventDefault()
			publisher = null;

			show('connectLink');
			hide('disconnectLink');
			hide('publishLink');
			hide('unpublishLink');
		}

		function connectionDestroyedHandler(event) {
			// This signals that connections were destroyed
		}

		function connectionCreatedHandler(event) {
			// This signals new connections have been created.
		}

		/*
		If you un-comment the call to TB.setLogLevel(), above, OpenTok automatically displays exception event messages.
		*/
		function exceptionHandler(event) {
			alert("Exception: " + event.code + "::" + event.message);
		}




    //--------------------------------------
    //  HELPER METHODS
    //--------------------------------------

		function addStream(stream) {
			// Check if this is the stream that I am publishing, and if so do not publish.
			if (stream.connection.connectionId == session.connection.connectionId) {
				return;
			}
			var subscriberDiv = document.createElement('div'); // Create a div for the subscriber to replace
			subscriberDiv.setAttribute('id', stream.streamId); // Give the replacement div the id of the stream as its id.
			document.getElementById("subscribers").appendChild(subscriberDiv);
			var subscriberProps = {width: VIDEO_WIDTH, height: VIDEO_HEIGHT};
			subscribers[stream.streamId] = session.subscribe(stream, subscriberDiv.id, subscriberProps);
		}

		function show(id) {
			document.getElementById(id).style.display = 'block';
		}

		function hide(id) {
			document.getElementById(id).style.display = 'none';
		}



</script> 
