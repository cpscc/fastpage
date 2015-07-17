<?php
function user_by_token($token, $as_array = true)
{
    if ($file = file_get_contents($path=root("tokens/t_$token"))) {
        return user_fetch(trim($file));
    }
    return false;
}
