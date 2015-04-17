<?php
function page_fetch($name, $as_array = false)
{
    if (file_exists($path=root("pages/$name.json"))) {
        return json_decode(file_get_contents($path), $as_array);
    }
    return false;
}
