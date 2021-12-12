<?php
if (!function_exists('base_url')) {
    function base_url(){
        if (isset($_SERVER['HTTP_HOST'])) {
            $http = isset($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) !== 'off' ? 'https' : 'http';
            if($http == 'http') {
                return "http://" . $_SERVER['SERVER_NAME'] . '/event';
                // return "http://event.lokerprogrammer.com';
            } else {
                return "https://" . $_SERVER['SERVER_NAME'] . '/event';
                // return "https://event.lokerprogrammer.com';
            }
        }
        else $base_url = 'http://localhost/';

        return $base_url;
    }
}

?>