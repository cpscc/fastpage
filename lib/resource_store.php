<?php
function resource_store($resource, $data)
{
    $data = str_replace("\r\n","\n", $data);
    return file_put_contents(root($resource), $data) !== false;
}

