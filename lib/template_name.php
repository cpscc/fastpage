<?php
function template_name($raw)
{
    if ($raw == 'default') return $raw;
    return hex2bin($raw);
}
