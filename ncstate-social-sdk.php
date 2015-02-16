<?php

require(dirname(__FILE__) . '/vendor/autoload.php');

if (file_exists('config.php')) {
  require(dirname(__FILE__) . '/config.php');
} else {
  error_log("Missing config.php. Copy the sample file and input your credentials", 0);
  exit(1);
}

if($load_apis['facebook']) include_once(dirname(__FILE__) . '/facebook.php');
if($load_apis['twitter']) include_once(dirname(__FILE__) . '/twitter.php');
if($load_apis['instagram']) include_once(dirname(__FILE__) . '/instagram.php');

