<?php


/**
 * Retrieves Flickr Photos sets from Album ID.
 * 
 * @param string $flickr_id A flickr album ID
 * @param int $num How many posts to return. Defaults to 8.
 * @return array Returns an array of images with image square image URL, link to full image, and title of photo.
 */
function getFlickr($flickr_id, $num = 8) {
  
  $f = getFlickrConnection();
  $flickr_photos = $f->photosets_getPhotos($flickr_id, $extras = NULL, $privacy_filter = NULL, $num, $page = 1, $media = NULL);
  $photos = array();

  foreach ($flickr_photos['photoset']['photo'] as $photo) {

    $photos[] = array(
      'img' => $f->buildPhotoURL($photo, 'square_150'),
      'url' => $f->buildPhotoURL($photo, 'large'),
      'title' => $photo['title']
    );

  }

  return $photos;

}

function getFlickrConnection() {

  if (FLICKR_KEY) {
    $flickr = new phpFlickr(FLICKR_KEY);
    if(FALSE !== $flickr->test_echo()) {
      $flickr->enableCache("fs", dirname( __FILE__ ) . '/cache');
      return $flickr;
    } else {
      throw new \RuntimeException('Flickr API Key has been defined but is invalid.');
    }
  } else {
    throw new \RuntimeException('Flickr API Key has not been defined.');
  }

}