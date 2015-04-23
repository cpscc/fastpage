<?php
require dirname(__FILE__) . '/vendor/autoload.php';
require dirname(__FILE__) . '/lib/root.php';

foreach (glob(root("lib/*.php")) as $filename) {
    require_once $filename;
}

ini_set('date.timezone', 'America/Los_Angeles');

ini_set('display_errors', true);
error_reporting(E_ERROR | E_PARSE);

define('APP', 'Pagio');


/** Folders and Repositories */

repo_initialize('public/images');
repo_initialize('pages');
repo_initialize('templates');
repo_initialize('users');
repo_initialize('permissions');

