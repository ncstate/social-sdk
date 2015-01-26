<?php

use Facebook\FacebookSession;
use Facebook\FacebookRequest;
use Facebook\FacebookRequestException;

function getFacebook($username, $raw = false, $num = 10) {
	$app_id = FACEBOOK_APP_ID;
	$secret = FACEBOOK_SECRET;
	$authToken = FACEBOOK_APP_ID . "|" . FACEBOOK_SECRET;
	
	FacebookSession::setDefaultApplication($app_id, $secret);

	$session = new FacebookSession($authToken);

	try {
		$response = (new FacebookRequest($session, 'GET', '/'.$username.'/posts', array( 'limit'=>$num ) ))->execute()->getGraphObject();
	} catch (FacebookRequestException $ex){
		echo $ex->getMessage();
	} catch (Exception $ex){
		echo $ex->getMessage();
	}

	$data = $response->getPropertyAsArray('data');

	if($raw) {
		return $data;
	}
	
	$posts = array();

	foreach($data as $post) {
		$fb_post = array(
			'time' => strtotime($post->getProperty('updated_time')),
			'message' => $post->getProperty('message'),
			'url' => $post->getProperty('link')
		);
	    $posts[] = $fb_post;
	}
	return $posts;
}
