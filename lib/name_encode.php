<?php
function name_encode($raw)
{
    return preg_replace("/ +/", " ", preg_replace("/[^a-z0-9]/", "_", strtolower($raw)));
}


