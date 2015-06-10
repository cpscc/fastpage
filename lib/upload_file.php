<?php
/*
 * Uploads a file. Rules and options are:
 *
 * - size: Exact file size in bytes.
 * - min_size: Minimum file size in bytes.
 * - max_size: Maximum file size in bytes.
 * - types: Allowed mime types, e.g., "image/gif", "image/png".
 *
 * @param string $name File input field name
 * @param string $path Either a directory or the destination file path
 * @param array  $opts Rules and options
 * @param string $error In the case of an error, this is set as the message
 *
 * @return bool Boolean true on success, false otherwise
 */
function upload_file($name, $dest, $opts = array(), &$error = null)
{
    if (!isset($_FILES[$name])) return false;

    if (isset($opts['size'])) {
        $min_size = $max_size = $opts['size'];
    } else {
        $min_size = isset($opts['min_size']) ? $opts['min_size'] : null;
        $max_size = isset($opts['max_size']) ? $opts['max_size'] : null;
    }

    $types = isset($opts['types']) ? array_convert($opts['types']) : array();

    $file = $_FILES[$name];

    if ($file['error'] != 0) {
        $error = "Unable to upload file";
        goto error;
    }
    if (isset($min_size) && $file['size'] < $min_size) {
        $error = "File is smaller than $min_size";
        goto error;
    }
    if (isset($max_size) && $file['size'] > $max_size) {
        $error = "File is larger than $max_size";
        goto error;
    }
    if ($types && !in_array($file['type'], $types)) {
        $error = "Invalid file type - must be " . implode(", ", $types);
        goto error;
    }

    if (rename($file['tmp_name'], $dest)) {
        return true;
    } else {
        $error = "Unable to save the file on our server";
        exit;
    }

error:
    remove($file['tmp_name']);
    return false;
}
