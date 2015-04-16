<?php

require '../config.php';

session_cache_limiter(false);
session_start(); 


/** Set theme */

if (file_exists('../config/theme'))
    define('THEME', trim(file_get_contents('../config/theme')));
else
    define('THEME', 'default');


/** URL Routing */

require '../routes.php';
