<?php

/*** 
    Ideally your server configuration will have the correct default timezone
    setting. If not, uncomment the following line and set it appropriately.
    http://php.net/manual/en/timezones.php
*/
//date_default_timezone_set('America/New_York');

// Define which API's to load. To exclude an API, change value to false.
$load_apis = array(
	'facebook' => true,
	'twitter' => true,
	'instagram' => true,
	'flickr' => true,
);


if($load_apis['facebook']) {

	// Facebook Config
	define('FACEBOOK_APP_ID', ot_get_option('facebook_app_id'));
	define('FACEBOOK_SECRET',  ot_get_option('facebook_secret'));

}

if($load_apis['twitter']) {

	// Twitter Config
	define('CONSUMER_KEY', ot_get_option('twitter_consumer_key'));
	define('CONSUMER_SECRET', ot_get_option('twitter_consumer_secret'));
	define('OAUTH_TOKEN', ot_get_option('oauth_token'));
	define('OAUTH_TOKEN_SECRET', ot_get_option('oauth_token_secret'));

}

if($load_apis['instagram']) {

	// Instagram Config
	define('INSTAGRAM_APP_KEY', ot_get_option('instagram_app_key'));

}

if($load_apis['flickr']) {

	// Flickr Config
	define('FLICKR_KEY', ot_get_option('flickr_key'));

}