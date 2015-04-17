<?php
function template_delete($name, &$error)
{
    $encoded = name_encode($name);
    $results = 0;
    $results += (int)resource_delete("public/{$encoded}_view.css");
    $results += (int)resource_delete("templates/{$encoded}_view.mustache");
    $results += (int)resource_delete("templates/{$encoded}_data.json");
    $results += (int)resource_delete("templates/{$encoded}_edit.mustache");

    if ($results == 4) {
        return true;
    } else {
        $error = 'There was a problem updating the template';
        return false;
    }
}

