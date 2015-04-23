<?php
function user_verify($user, &$error = null)
{
    $in_system = user_fetch($user['login']);

    if (!$in_system) {
        $error = "Unable to find login: '{$user['login']}'";
        return false;
    }

    if ($in_system['password'] !== $user['password']) {
        $error = "Invalid password";
        return false;
    }

    return $in_system;
}

