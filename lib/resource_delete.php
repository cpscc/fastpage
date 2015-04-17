<?php
function resource_delete($resource)
{
    return unlink(root($resource));
}

