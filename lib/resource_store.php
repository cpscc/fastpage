<?php
function resource_store($resource, $data)
{
    return file_put_contents(root($resource), $data) !== false;
}

