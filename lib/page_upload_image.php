<?php
function page_upload_image($page_name, $opts = [], &$error = null)
{
    $input_label = $opts['label'];

    if (!isset($_FILES[$opts['name']]) || $_FILES[$opts['name']]['error'] == UPLOAD_ERR_NO_FILE)
        return null;

    if (!file_exists($path = '../public/images/page_'.name_encode($page_name)))
        mkdir($path);

    $name = md5_file($_FILES[$opts['name']]['tmp_name']) .  $_FILES[$opts['name']]['name'];

    if (upload_file($opts['name'], "$path/$name", $opts, $error)) {
        return "/images/page_$page_name/$name";
    } else {
        $error = "{$opts['label']}: $error";
        return false;
    }
}
