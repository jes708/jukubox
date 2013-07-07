<?php

require_once( dirname(dirname(__FILE__)) . '/oauth/provider.php' );

/**
 * Instagram OAuth class
*/

class nivo_source_instagram extends provider {
  
	public 	$host = 'https://api.instagram.com/v1/';
	public  $format;
	private $access_token_url = 'https://api.instagram.com/oauth/access_token/';
	private $authenticate_token_url = '';
	private $authorize_url = 'https://api.instagram.com/oauth/authorize/';
	private $request_token_url = '';
 	
 	private $consumer_key = '962ae861a606454084a9295e401fca3b';
 	private $consumer_secret = 'a9bc8436de7344419eaec9968bc28cef';
 	private $redirect_uri = 'http://dev7studios.com/oauth/instagram.php';
 	
 	private $max_count = 40;
 	private $default_count = 20;
 	
 	private $settings = array	(	'getOwnImages' => array( 	'name' => 'My Images'),
 									'getUsersImages' => array( 	'name' => 'User Images',
 																'param_type' => 'text',
 																'param_desc' => 'Enter a username'),
 									'getTaggedImages' => array( 'name' => 'Tagged Images',
 																'param_type' => 'text',
 																'param_desc' => 'Enter a hashtag without the #'),
 									'getLocationImages' => array( 	'name' => 'Location Images',
 																	'param_type' => 'text',
 																	'param_desc' => 'Enter a latitude and longitude, eg. 51.4638, 0.1677')
 								);
 	
 	function __construct($oauth_token = NULL, $oauth_token_secret = NULL) {
 	
 		parent::__construct(	$this->host,
 								$this->format,
 								$this->access_token_url,
 								$this->authenticate_token_url,
 								$this->authorize_url,
 								$this->request_token_url,
 								$this->consumer_key,
 								$this->consumer_secret,
 								$this->settings,
 								$this->max_count,
 								$this->default_count,
 								$oauth_token,
 								$oauth_token_secret
 							);

	}
	
	function getFormat($url) { return "{$this->host}{$url}"; }
	
	function get_authorise_url($callback = '', $source = '') {
		$_SESSION[$source .'_oauth_token'] = 'instagram_token';
		$_SESSION[$source .'_oauth_token_secret'] = 'instagram_secret';		
		$return_uri = base64_encode($callback. '&type=' . $source);	
		$redirect = $this->redirect_uri .'?return_uri='. $return_uri;
		return $this->authorize_url.'?client_id='. $this->consumer_key. '&redirect_uri='. $redirect . '&response_type=code&scope=basic';
	}
	
    
    function getAccessToken($oauth_verifier, $return_uri) {
	    $redirect_uri = ($this->redirect_uri .'?return_uri='. base64_encode($return_uri));
	    $parameters = array('client_id' => $this->consumer_key, 'client_secret' => $this->consumer_secret, 'grant_type' => 'authorization_code', 'redirect_uri' => $redirect_uri, 'code' => $oauth_verifier);	
        $method = 'POST';
        $oauth = new OAuthRequest($method, $this->accessTokenUrl(), $parameters);
        $request = $this->http($oauth->get_normalized_http_url(), $method, $oauth->to_postdata());
        $token = json_decode($request);
        $access_token['oauth_token'] = $token->access_token;
        $access_token['oauth_token_secret'] = 'nosecret';
        return $access_token;
	}
	
	private function getImages($images) {
		$new_images = array();
		if ($images) {
		    foreach($images->data as $photo) {
			    $new_images[] = array(  'id' => $photo->id,
			    						'image_src' => $photo->images->standard_resolution->url,
			    						'thumbnail' => $photo->images->thumbnail->url,
			    						'alt_text' => (isset($photo->caption->text) ? $this->filter_text($photo->caption->text) : ''),
										'post_permalink' => $photo->link,
										'post_title' => (isset($photo->caption->text) ? $this->filter_text($photo->caption->text) : '')
			    );
			}
		}
		return $new_images;
	}
	
	private function getUserId($username) {
		$params = array( 	'q' => $username,
							'count' => 1 
						);
		$userid = 0;
		$user = $this->get('users/search', $params, 1);
		if (isset($user->data) && isset($user)) {
			$user = $user->data;
			$userid = $user[0]->id;
		} 
		return $userid;
	}
	
	function getOwnImages($count = null ) {
		$count = isset($count) ? $count : $this->default_count;
		$count = ($count > $this->max_count) ? $this->max_count : $count;
		$params = ($count == $this->default_count) ? array() : array( 'count' => $count );
		$images = $this->get('users/self/media/recent/', $params, 1);
		return $this->getImages($images);
	}
	
	function getUsersImages($username, $count = null) {
		$count = isset($count) ? $count : $this->default_count;
		$count = ($count > $this->max_count) ? $this->max_count : $count;
		$params = ($count == $this->default_count) ? array() : array( 'count' => $count );
		$userid = $this->getUserId($username);
		$images = array();
		if ($userid != 0) $images = $this->get('users/'. $userid .'/media/recent/', $params, 1);
		return $this->getImages($images);
	}
	
	function getTaggedImages($tag, $count = null) {
		$count = isset($count) ? $count : $this->default_count;
		$count = ($count > $this->max_count) ? $this->max_count : $count;
		$params = ($count == $this->default_count) ? array() : array( 'count' => $count );
		$images = $this->get('tags/'. $tag .'/media/recent/', $params, 1);
		return $this->getImages($images);
	}
	
	function getLocationImages($latlng, $count = null) {
		$count = isset($count) ? $count : $this->default_count;
		$count = ($count > $this->max_count) ? $this->max_count : $count;
		$latlng = explode(",", $latlng);		
		$params = array( 	'lat' => $latlng[0],
							'lng' => $latlng[1],
							'count' => $count
						);
		$images = $this->get('media/search/', $params, 1);
		return $this->getImages($images);
	}
 	
}
