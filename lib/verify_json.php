<?php
function verify_json($json, &$error)
{
    if (json_decode($json) === null) {
        $error = "Invalid JSON";
        return false;
    }
    return true;
}
