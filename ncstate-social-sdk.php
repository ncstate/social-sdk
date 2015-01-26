<?php

require "vendor/autoload.php";
require "config.php";


if($load_apis['facebook']) include "facebook.php" ;
if($load_apis['twitter'])include "twitter.php";
if($load_apis['instagram'])include "instagram.php";

