<?php
function permissions_fetch($name, $as_array = false)
{
    $permissions = resource_fetch("permissions/" . name_encode($name));
    if ($as_array) {
        $permissions = preg_split('/[,; ]\\+/', $permissions);
    }
    return $permissions;
}

