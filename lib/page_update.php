<?php
function page_update($name, $data, &$error)
{
    # Renaming
    if ($data['name'] !== $name) {
        if (page_exists($data['name'])) {
            $error = "Cannot rename to '{$data['name']}', that page already exists. Please delete the page '{$data['name']}' first.";
            return false;
        }
        page_delete($name);
    }

    # Appending new info to template json
    $page = json_decode(template_fetch($data['theme'])['data'], true);
    foreach ($page as $k=>&$v) {
        if (isset($data[$k])) $v = $data[$k];
    }

    return page_store($data['name'], $page, $error);
}
