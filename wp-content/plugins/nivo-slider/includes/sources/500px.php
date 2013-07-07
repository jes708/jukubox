<?php

require_once( dirname(dirname(__FILE__)) . '/oauth/provider.php' );

/**
 * 500px OAuth class
*/

class nivo_source_500px extends provider {
  
	public 	$host = 'https://api.500px.com/v1/';
	public $format = 'json';
	private $access_token_url = 'https://api.500px.com/v1/oauth/access_token';
	private $authenticate_token_url = 'https://api.500px.com/v1/oauth/authorize';
	private $authorize_url = 'https://api.500px.com/v1/oauth/authorize';
	private $request_token_url = 'https://api.500px.com/v1/oauth/request_token';
 	
 	private $consumer_key = '6abSILqaiitnO49GEsfomAf7vSwrdgYbQIxTtpVF';
 	private $consumer_secret = 'UucQs3BYOykl6k6hSZBLiwdXLsKfHsWzZ3Z8Zera';
 	
 	private $max_count = 100;
 	private $default_count = 20;
 	
 	private $settings = array	(	'getUsersImages' => array( 	'name' => 'User Images',
 																'param_type' => 'text',
 																'param_desc' => 'Enter a username'),
 									'getTaggedImages' => array( 'name' => 'Tagged Images',
 																'param_type' => 'text',
 																'param_desc' => 'Enter a hashtag without the #'),
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
	
	private function getImages($images) {
		$new_images = array();
		if ($images) {
		    foreach($images->photos as $photo) {
			    $new_images[] = array(  'id' => $photo->id,
			    						'image_src' => str_replace('/2.jpg', '/4.jpg', $photo->image_url),
			    						'thumbnail' => $photo->image_url,
			    						'alt_text' => (isset($photo->name) ? $this->filter_text($photo->name) : ''),
										'post_permalink' => 'http://500px.com/photo/'. $photo->id,
										'post_title' => (isset($photo->name) ? $this->filter_text($photo->name) : '')
			    );
			}
		}
		return $new_images;
	}
	
	function getUsersImages($username, $count = null) {
		$count = isset($count) ? $count : $this->default_count;
		$count = ($count > $this->max_count) ? $this->max_count : $count;
		$params = array('feature' => 'user', 'username' => $username);
		$params['rpp'] = $count;
		$images = $this->get('photos', $params);
		return $this->getImages($images);
	}
	
	function getTaggedImages($tag, $count = null) {
		$count = isset($count) ? $count : $this->default_count;
		$count = ($count > $this->max_count) ? $this->max_count : $count;
		$params = array('tag' => $tag);
		$params['rpp'] = $count;
		$images = $this->get('photos/search', $params);
		return $this->getImages($images);
	}
	
	
}
