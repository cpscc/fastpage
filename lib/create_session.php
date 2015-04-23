<?php
function create_session($role = 'USER', $login = '')
{
    $_SESSION[strtoupper($role)] = true;
    $_SESSION['LOGIN'] = $login;
}

