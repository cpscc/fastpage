<?php
function page_fetch($name)
{
    if (file_exists($path=root("pages/$name.json"))) {
        return ['page'=>file_get_contents($path)];
    }
    return false;
}
