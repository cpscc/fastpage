<?php
function repo_load($repo_name)
{
    if ($r = file_get_contents(root("$repo_name.yaml")))
        return $r;
    else
        throw new RuntimeException("Could not find file: \"$repo_name.yaml\"");
}

