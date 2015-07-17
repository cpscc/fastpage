<?php
/**
 * The token is stored in each user.
 * This creates an index for easy lookup of 
 * users via tokens or vice-versa.
 */
function user_store_token($user)
{
    $name = name_encode($user['login']);
    $old_user = user_fetch($user['login']);

    file_put_contents(root("tokens/t_$user[token]"), $user['login']);
    file_put_contents(root("tokens/u_$name"), $user['token']);

    if (!empty($old_user['token']) && $user['token'] != $old_user['token']) {
        unlink(root("tokens/t_$old_user[token]"));
    }
}
