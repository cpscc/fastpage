<?php
function name_decode($raw)
{
    if ($raw == 'default') return $raw;
    return hex2bin($raw);
}
