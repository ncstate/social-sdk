<?php

use Abraham\TwitterOAuth\TwitterOAuth;

/**
 * Retrieves tweets for a given username.
 * 
 * @param string $username A Twitter handle without @
 * @param int $num How many posts to return. Defaults to 10.
 * @return array Returns an array of posts with keys time, description, url, and media.
 */
function getTwitter($twitter_handle, $num = 10) {
	$twitterUser = $twitter_handle;

  $connection = getTwitterConnection();
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

function getTwitterConnection() {
  if (CONSUMER_KEY && CONSUMER_SECRET && OAUTH_TOKEN && OAUTH_TOKEN_SECRET) {
    return new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, OAUTH_TOKEN, OAUTH_TOKEN_SECRET);
  } else {
    throw new \RuntimeException('Twitter API Credentials have not been defined.');
  }
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