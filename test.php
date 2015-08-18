<?php
//define('ABSPATH', '/');

require "ncstate-social-sdk.php";

// Facebook example
echo "<h2>Facebook</h2>";
try {
  $fb = getFacebook('ncstate', 1);
} catch (Exception $e) {
  echo $e->getMessage();
}

foreach($fb as $post) {
  echo "<strong>" . date('M d, y', $post['time']) . "</strong><br/>";
  echo $post['message'] . "<br/>";
  echo "<a href=" . $post['url'] . ">" . $post['url'] . "</a><br/><br/>";
}

// Twitter Example
echo "<br/><br/><br/><br/><h2>Twitter</h2>";
try {
$twitter = getTwitter("ncstate", 2);
} catch (Exception $e) {
  echo $e->getMessage();
}

foreach($twitter as $tweet) {
  $output = "<p><strong>" . date('M d, y', $tweet['time']) . "</strong><br/>" . $tweet['description'];
  if ($tweet['media'][0]->media_url) {
    $output .= "<br/><img src='" . $tweet['media'][0]->media_url . "' />";
  }
  $output .= "</p>";
  echo $output;
}

// Instagram Example
echo "<br/><br/><h2>Instagram</h2>";
try {
$instagram = getInstagram("ncstate", 10, 'thinkanddo');
} catch (Exception $e) {
  echo $e->getMessage();
}

foreach($instagram as $one_gram) {
  if($one_gram['url'] != null){
      echo '<a href="' . $one_gram['url'] . '"><img width="200" src="' . $one_gram['img'] . '" alt="' . $one_gram['img'] . '"></a>';
  }
}