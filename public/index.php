<?php

require '../config.php';

session_cache_limiter(false);
session_start(); 

define('VIEWS', 'templates');


/** URL Routing */

require '../routes.php';
