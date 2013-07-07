<?php

require_once( dirname(dirname(__FILE__)) . '/oauth/provider.php' );

/**
 * Flickr OAuth class
*/

class nivo_source_flickr extends provider {
  
	public 	$host = 'http://api.flickr.com/services/rest/';
	public  $format = 'json';
	private $access_token_url = 'http://www.flickr.com/services/oauth/access_token';
	private $authenticate_token_url = 'http://www.flickr.com/services/oauth/authorize';
	private $authorize_url = 'http://www.flickr.com/services/oauth/authorize';
	private $request_token_url = 'http://www.flickr.com/services/oauth/request_token';
 	
 	private $consumer_key = '1baf56f3bc7c27483e1df422acc0d095';
 	private $consumer_secret = '0d38db3086dde4ac';
 	
 	private $max_count = 500;
 	private $default_count = 20;
 
 	private $settings = array	( 	'getUsersImages' => array( 	'name' => 'User Images',
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
	
	function getFormat($url) { return "{$this->host}{$url}?format={$this->format}&nojsoncallback=1"; }
	
	private function getImages($images) {
		$new_images = array();
		if ($images) {
		    foreach($images->photos->photo as $photo) {
			    $new_images[] = array(  'id' => $photo->id,
			    						'image_src' => 'http://farm'. $photo->farm .'.static.flickr.com/'. $photo->server .'/'. $photo->id .'_'. $photo->secret .'_b.jpg',
			    						'thumbnail' => 'http://farm'. $photo->farm .'.static.flickr.com/'. $photo->server .'/'. $photo->id .'_'. $photo->secret .'_q.jpg',
			    						'alt_text' => (isset($photo->title) ? $this->filter_text($photo->title) : ''),
										'post_permalink' => 'http://www.flickr.com/photos/'. $photo->owner .'/' .$photo->id,
										'post_title' => (isset($photo->title) ? $this->filter_text($photo->title) : '')
			    );
			}
		}
		return $new_images;
		
	}
	
	private function getUserId($username) {
		$params = array( 	'method' => 'flickr.people.findByUsername',
							'username' => $username
						);
		$userid = 0;
		$user = $this->get('', $params);
		if (isset($user->user) && isset($user)) {
			$user = $user->user;
			$userid = $user->id;
		} 
		return $userid;
		
	}

	function getOwnImages($count = null) {
		$count = isset($count) ? $count : $this->default_count;
		$count = ($count > $this->max_count) ? $this->max_count : $count;
		$params = array(	'method' => 'flickr.photos.search', 
							'user_id' => 0, 
							'per_page' => $count, 
							'page' => 1);
		$images = array();
		if ($userid != 0) $images = $this->get('', $params);
		return $this->getImages($images);
	}
	
	function getUsersImages($username, $count = null) {
		$count = isset($count) ? $count : $this->default_count;
		$count = ($count > $this->max_count) ? $this->max_count : $count;
		$userid = $this->getUserId($username);
		$params = array(	'method' => 'flickr.photos.search', 
							'user_id' => $userid, 
							'per_page' => $count, 
							'page' => 1);
		$images = array();
		if ($userid != 0) $images = $this->get('', $params);
		return $this->getImages($images);
	}
	
	function getTaggedImages($tags, $count = null) {
		$count = isset($count) ? $count : $this->default_count;
		$count = ($count > $this->max_count) ? $this->max_count : $count;
		$params = array(	'method' => 'flickr.photos.search', 
							'tags' => $tags, 
							'tag_mode' => 'all',
							'per_page' => $count, 
							'page' => 1);
		$images = array();
		$images = $this->get('', $params);
		return $this->getImages($images);
	}

	
}
