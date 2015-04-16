<?php
function authenticated()
{
    return isset($_SESSION['AUTHENTICATED']) || isset($_SESSION['ADMIN']);
}

