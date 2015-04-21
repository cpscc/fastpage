<?php
function page_store($name, $data, &$error)
{
    $encoded = $name; //$encoded = name_encode($name);
    $data = json_encode($data);

    if (resource_store("pages/{$encoded}.json", $data)) {
        return true;
    } else {
        $error = 'There was a problem updating the page';
        return false;
    }
}


