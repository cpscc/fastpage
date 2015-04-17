<?php
function page_fetch($name)
{
    if (file_exists($path=root("pages/$name.json"))) {
        return json_decode(file_get_contents($path));
    }
    return false;
}
