<?php
function template_store($data, $error)
{
    $encoded = name_encode($data['name']);
    $results = 0;
    $results += (int)resource_store("public/{$encoded}_view.css", $data['css']);
    $results += (int)resource_store("templates/{$encoded}_view.mustache", $data['view']);
    $results += (int)resource_store("templates/{$encoded}_data.json", $data['data']);
    $results += (int)resource_store("templates/{$encoded}_edit.mustache", $data['edit']);

    if ($results == 4) {
        return true;
    } else {
        $error = 'There was a problem updating the template';
        return false;
    }
}

