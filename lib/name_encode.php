<?php
function name_encode($raw)
{
    if ($raw == 'default') return $raw;
    return bin2hex($raw);
}

