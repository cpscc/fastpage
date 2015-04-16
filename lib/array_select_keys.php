<?php
function array_select_keys(array $dict, array $keys)
{
    $result = array();
    foreach ($keys as $key) {
        if (array_key_exists($key, $dict)) {
            $result[$key] = $dict[$key];
        }
    }
    return $result;
}
