<?php
function user_verify_token($token)
{
    return !empty(user_by_token($token));
}
