<?php
function user(array $user)
{
    return array_select_keys((array)$user, ['role','login','password','firstname','lastname']);
}
