<?php

/**
 * Retrieves Flickr Photos sets from Album ID.
 *
 * @param string $flickr_id A flickr album ID
 * @param int $num How many posts to return. Defaults to 8.
 * @return array Returns an array of images with square image URL, link to full image, and title of photo.
 */

function getFlickr($flickr_id, $num = 8, $sort = false)
{

    $f = getFlickrConnection();

    $flickr_photos = $f->photosets_getPhotos($flickr_id, $extras = 'date_upload,last_update,views,date_taken', $privacy_filter = null, $num, $page = 1, $media = null);

    $the_photos = $flickr_photos['photoset']['photo'];

    if (!empty($sort)) {

        $sorter = new goodSorter();

        switch ($sort) {
            case 'title':
                $sorter->backwards = false;
                break;
            default:
                $sorter->backwards = true;
                break;
        }

        $the_photos = $sorter->sort($the_photos, $sort, 'title');
    }

    $photos = array();
    foreach ($the_photos as $photo) {
        $photos[] = array(
            'img' => $f->buildPhotoURL($photo, 'square_150'),
            'url' => $f->buildPhotoURL($photo, 'large'),
            'title' => $photo['title'],
        );
    }

    return $photos;

}

function getFlickrConnection()
{

    if (FLICKR_KEY) {
        $flickr = new phpFlickr(FLICKR_KEY);
        if (false !== $flickr->test_echo()) {

            $cache = dirname(__FILE__) . '/cache';

            if (file_exists($cache)) {
                $flickr->enableCache("fs", $cache);
            }

            return $flickr;
        } else {
            throw new \RuntimeException('Flickr API Key has been defined but is invalid.');
        }
    } else {
        throw new \RuntimeException('Flickr API Key has not been defined.');
    }

}
