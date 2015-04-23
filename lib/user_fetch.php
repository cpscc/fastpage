<?php
function user_fetch($name, $as_array = true)
{
    $name = name_encode($name);

    if (file_exists($path=root("users/$name.json"))) {
        return user(json_decode(file_get_contents($path), $as_array));
    }
    return false;
}

