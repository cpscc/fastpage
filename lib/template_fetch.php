<?php
function template_fetch($name)
{
    $encoded = name_encode($name);

    $css = resource_fetch("public/{$encoded}_view.css");
    $view = resource_fetch("templates/{$encoded}_view.mustache");
    $data = resource_fetch("templates/{$encoded}_data.json");
    $edit = resource_fetch("templates/{$encoded}_edit.mustache");
    return compact('name','css','view','data','edit');
}

