<?php

require '../vendor/autoload.php';
require '../functions.php';

ini_set('date.timezone', 'America/Los_Angeles');

ini_set('display_errors', true);
error_reporting(E_ERROR | E_PARSE);

session_cache_limiter(false);
session_start(); 


/** YAML Repositories */

initialize_repo('public/profile');
initialize_repo('users');
initialize_repo('profiles');


/** Set theme */

if (file_exists('../config/theme'))
    define('THEME', trim(file_get_contents('../config/theme')));
else
    define('THEME', 'default');


/** URL Routing */

require '../routes.php';
