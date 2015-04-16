<?php
function root($file = null)
{
    $root = str_replace('/lib', '', dirname(__FILE__));
    return $file ? $root . "/" . $file : $root;
}

