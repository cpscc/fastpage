<?php
function user_exists($name)
{
    $name = name_encode($name);
    return file_exists(root("users/{$name}.json"));
}

