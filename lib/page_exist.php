<?php
function page_exists($name)
{
    //$name = name_encode($name);
    return file_exists(root("pages/{$name}.json"));
}

