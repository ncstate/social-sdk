<?php

use Abraham\TwitterOAuth\TwitterOAuth;

function getTwitter($twitter_handle, $num = 10) {
	$twitterUser = $twitter_handle;
	
	date_default_timezone_set('America/New_York');

  $connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, OAUTH_TOKEN, OAUTH_TOKEN_SECRET);
  $statuses = $connection->get('statuses/user_timeline', array('screen_name' => $twitterUser, 'count' => $num, 'include_entities' => true));

	$tweets = array();  

	foreach($statuses as $status) {
		$tweet = array(
			'time' => strtotime($status->created_at),
			'description' => restoreUrlsWithinText($status),
			'url' => 'https://twitter.com/' . $status->user->screen_name . '/status/' . $status->id_str,
			'media' => $status->entities->media
		);
	    $tweets[] = $tweet;
   }
   return $tweets;
}

/**
 * Restores urls within the text of a tweet to their full original text
 * 
 * @param object $apiResponseTweetObject A json_decoded() one of these: https://dev.twitter.com/docs/platform-objects/tweets
 * @return string The tweet's text with urls expanded
 */
function restoreUrlsWithinText($apiResponseTweetObject) {

    $tweet = $apiResponseTweetObject->text;

    // Replace short url with display url
    foreach ($apiResponseTweetObject->entities->urls as $entity) {
        $tweet = str_replace($entity->url, $entity->display_url, $tweet);        
    }

    // Replace the first media link since it's handled elsewhere
    if($apiResponseTweetObject->entities->media) {
    	$tweet = str_replace($apiResponseTweetObject->entities->media[0]->url, '', $tweet);        
    }

    return $tweet;

}