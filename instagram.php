<?php

use MetzWeb\Instagram\Instagram;


/**
 * Retrieves Instagram photos for a given username.
 * 
 * @param string $username An Instagram handle without @
 * @param int $num How many photos to return. Defaults to 10.
 * @return array Returns an array of photos with keys time, img, and url.
 */
function getInstagram($username, $num = 10) {
	
	$instagram = new Instagram(INSTAGRAM_APP_KEY);
	
	$user_info = $instagram->searchUser($username, 1);
	$user_info = $user_info->data;
	
	$temp = $instagram->getUserMedia($user_info[0]->id, $num);
	
	$media = $temp->data;
	
	$photos = array();
	
	foreach($media as $image) {
		$photo = array(
			'time' => $image->created_time,
			'img' => $image->images->standard_resolution->url,
			'url' => $image->link,
		);
		$photos[] = $photo;
	}
	return $photos;
}
