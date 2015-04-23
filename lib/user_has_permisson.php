<?php
function user_has_permission($login, $page)
{
    $permissions = permissions_fetch($page, true);

    return in_array($login, $permissions);
}
