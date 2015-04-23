<?php
function authenticated()
{
    return isset($_SESSION['USER']) || isset($_SESSION['ADMIN']);
}

