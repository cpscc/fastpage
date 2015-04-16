<?php
function repo_initialize($repo_name)
{
    if (!file_exists($d=root($repo_name))) {
        mkdir($d);
    }
    return file_exists($d);
}
