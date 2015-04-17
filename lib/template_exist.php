<?php
function template_exists($name)
{
    $encoded = name_encode($name);
    return file_exists(root("templates/{$encoded}_view.mustache"));
}
