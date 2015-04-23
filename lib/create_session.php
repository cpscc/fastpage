<?php
function create_session($name = 'AUTHENTICATED')
{
    return $_SESSION[$name] = true;
}

