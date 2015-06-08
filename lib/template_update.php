<?php
function template_update($name, $data, &$error)
{
    // ensure valid Mustache and JSON inputs
    // make sure, if name is being changed, it doesn't overwrite another template

    $mustaches = ['view'=>'Layout Template','edit'=>'Editing Template'];

    foreach ($mustaches as $field=>$label) {
        verify_mustache($data[$field], $error);
        if ($error) {
            $error = "($label) $error";
            return false;
        }
    }

    $jsons = ['data'=>'Data Template'];

    foreach ($jsons as $field=>$label) {
        verify_json($data[$field], $error);
        if ($error) {
            $error = "($label) $error";
            return false;
        }
    }

    if ($data['name'] !== $name) {
        if (template_exists($data['name'])) {
            $error = "Cannot rename to '{$data['name']}', that template already exists. Please delete the template '{$data['name']}' first.";
            return false;
        }
        template_delete($name);
    }

    return template_store($data, $error);
}
