<?php

define('NCSTATE_SOCIAL_PATH', dirname(__FILE__) . '/');

if (file_exists(NCSTATE_SOCIAL_PATH . 'config.php')) {
    require_once NCSTATE_SOCIAL_PATH . 'config.php';
} else {
    if (!empty(FACEBOOK_APP_ID) && !empty(FACEBOOK_SECRET)) {
        include_once NCSTATE_SOCIAL_PATH . 'facebook.php';
    }

    if (!empty(CONSUMER_KEY) && !empty(CONSUMER_SECRET) && !empty(OAUTH_TOKEN) && !empty(OAUTH_TOKEN_SECRET)) {
        include_once NCSTATE_SOCIAL_PATH . 'twitter.php';
    }

    if (!empty(INSTAGRAM_APP_KEY)) {
        include_once NCSTATE_SOCIAL_PATH . 'instagram.php';
    }

    if (!empty(FLICKR_KEY)) {
        include_once NCSTATE_SOCIAL_PATH . 'flickr.php';
    }
}

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
