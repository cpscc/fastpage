<?php
function verify_mustache($view, &$error)
{
    try {
        (new Mustache_Engine)->render($view);
    } catch (Exception $e) {
        $error = $e->getMessage();
        return false;
    }
    return true;
}
