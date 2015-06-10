<?php
function page_images($name, $page, &$error)
{
    $prev_page = page_fetch($name);

    foreach ($page['_images'] as $opts) {
        if ($image = page_upload_image($data['name'], $opts, $error)) {
            $page[$opts['name']] = $image;
        } elseif ($image == null) {
            $page[$opts['name']] = $prev_page->$opts['name'];
        } else {
            return false;
        }
    }

    return $page;
}
