<?php

require '../vendor/autoload.php';

foreach (glob("../lib/*.php") as $filename) {
    require $filename;
}

ini_set('date.timezone', 'America/Los_Angeles');

ini_set('display_errors', true);
error_reporting(E_ERROR | E_PARSE);

session_cache_limiter(false);
session_start(); 


/** YAML Repositories */

repo_initialize('public/profile');
repo_initialize('users');
repo_initialize('profiles');


/** Set theme */

if (file_exists('../config/theme'))
    define('THEME', trim(file_get_contents('../config/theme')));
else
    define('THEME', 'default');


/** URL Routing */

require '../routes.php';
