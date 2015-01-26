<?php

require "vendor/autoload.php";

if (file_exists('config.php')) {
  require "config.php";
} else {
  error_log("Missing config.php. Copy the sample file and input your credentials", 0);
  exit(1);
}

if($load_apis['facebook']) include "facebook.php" ;
if($load_apis['twitter'])include "twitter.php";
if($load_apis['instagram'])include "instagram.php";

