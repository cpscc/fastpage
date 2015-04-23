<?php
function verify_admin($user, &$error = null)
{
    $users = repo_open('users');

    foreach ($users as $u) {
        if ($u['login'] != trim($user['login']))
            continue;

        if ($u['password'] != $user['password']) {
            $error = "Invalid password";
            return false;
        }

        return true;
    }

    $error = "Unable to find login: {$user['login']}";
    return false;
}

