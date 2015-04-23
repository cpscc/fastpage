<?php
function create_session($name = 'USER')
{
    return $_SESSION[strtoupper($name)] = true;
}

