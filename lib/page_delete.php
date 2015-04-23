<?php
function page_delete($name, &$error)
{
    //$name = name_encode($name);

    if (resource_delete("pages/{$name}.json")) {
        return true;
    } else {
        $error = 'There was a problem updating the page';
        return false;
    }
}


