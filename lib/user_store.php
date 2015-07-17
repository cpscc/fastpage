<?php
function user_store($user)
{
    if (isset($user['token'])) user_store_token($user);
    $name = name_encode($user['login']);
    $user = json_encode(user($user));
    return file_put_contents(root("users/$name.json"), $user) !== false;
}

