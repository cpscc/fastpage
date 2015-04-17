<?php
function resource_fetch($resource)
{
    if (file_exists($f=root($resource))) {
        return file_get_contents($f);
    }
    return '';
}
