<?php

define( 'NCSTATE_SOCIAL_PATH', dirname(__FILE__) . '/' );

require( NCSTATE_SOCIAL_PATH . 'vendor/autoload.php' );


if ( defined('ABSPATH') && function_exists('ot_get_option') ) {
  require_once( NCSTATE_SOCIAL_PATH . 'wp-config.php' );
} elseif ( file_exists( NCSTATE_SOCIAL_PATH . 'config.php' ) ) {
  require_once( NCSTATE_SOCIAL_PATH . 'config.php' );
} else {
  error_log("Missing config.php. Copy the sample file and input your credentials", 0);
  exit(1);
}

if($load_apis['facebook']) include_once( NCSTATE_SOCIAL_PATH . 'facebook.php');
if($load_apis['twitter']) include_once( NCSTATE_SOCIAL_PATH . 'twitter.php');
if($load_apis['instagram']) include_once( NCSTATE_SOCIAL_PATH . 'instagram.php');
if($load_apis['flickr']) include_once( NCSTATE_SOCIAL_PATH . 'flickr.php');

