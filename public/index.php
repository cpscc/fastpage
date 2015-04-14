<?php

require '../vendor/autoload.php';
require '../functions.php';

ini_set('date.timezone', 'America/San_Francisco');

ini_set('display_errors', true);
error_reporting(E_ERROR | E_PARSE);

session_cache_limiter(false);
session_start(); 


/** JSON Repositories */

initialize_repo('links');
initialize_repo('promo_codes');
initialize_repo('users');


/** Set theme */

if (file_exists('../config/theme'))
    define('THEME', trim(file_get_contents('../config/theme')));
else
    define('THEME', 'default');


/** URL Routing */

require '../routes.php';
