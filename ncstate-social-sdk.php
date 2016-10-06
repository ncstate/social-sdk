<?php

define('NCSTATE_SOCIAL_PATH', dirname(__FILE__) . '/');

require_once NCSTATE_SOCIAL_PATH . 'vendor/autoload.php';

if (defined('ABSPATH') && function_exists('ot_get_option')) {
    require_once NCSTATE_SOCIAL_PATH . 'wp-config.php';
} elseif (file_exists(NCSTATE_SOCIAL_PATH . 'config.php')) {
    require_once NCSTATE_SOCIAL_PATH . 'config.php';
} else {
    error_log("Missing config.php. Copy the sample file and input your credentials", 0);
    exit(1);
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

if ($load_apis['facebook']) {
    include_once NCSTATE_SOCIAL_PATH . 'facebook.php';
}

if ($load_apis['twitter']) {
    include_once NCSTATE_SOCIAL_PATH . 'twitter.php';
}

if ($load_apis['instagram']) {
    include_once NCSTATE_SOCIAL_PATH . 'instagram.php';
}

if ($load_apis['flickr']) {
    include_once NCSTATE_SOCIAL_PATH . 'flickr.php';
}
