<?php

/* Sorting Mechanism for Flickr & Such */
if (!class_exists('goodSorter')) {
    class goodSorter
    {

        public $sort_fields;
        public $backwards = false;
        public $numeric = false;

        public function sort()
        {
            $args = func_get_args();
            $array = $args[0];
            if (!$array) {
                return array();
            }

            $this->sort_fields = array_slice($args, 1);
            if (!$this->sort_fields) {
                return $array();
            }

            if ($this->numeric) {
                usort($array, array($this, 'numericCompare'));
            } else {
                usort($array, array($this, 'stringCompare'));
            }
            return $array;
        }

        public function numericCompare($a, $b)
        {
            foreach ($this->sort_fields as $sort_field) {
                if ($a[$sort_field] == $b[$sort_field]) {
                    continue;
                }
                return ($a[$sort_field] < $b[$sort_field]) ? ($this->backwards ? 1 : -1) : ($this->backwards ? -1 : 1);
            }
            return 0;
        }

        public function stringCompare($a, $b)
        {
            foreach ($this->sort_fields as $sort_field) {
                $cmp_result = strcasecmp($a[$sort_field], $b[$sort_field]);
                if ($cmp_result == 0) {
                    continue;
                }

                return ($this->backwards ? -$cmp_result : $cmp_result);
            }
            return 0;
        }
    }
}

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

    if ($sort != false) {

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
