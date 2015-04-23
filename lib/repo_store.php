<?php
function repo_store($repo_name, $data)
{
    return file_put_contents(root("$repo_name.yaml", $data)) !== false;
}

