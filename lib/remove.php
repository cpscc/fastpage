<?php
/*
 * Removes files and directories recursively.
 *
 * From https://github.com/nramenta/webcetera
 *
 * @param string $path File or directory path
 *
 * @return bool Boolean true on success, false otherwise
 */
function remove($path)
{
    if (is_file($path) || is_link($path)) {
        unlink($path);
    } elseif (is_dir($path)) {
        $objects = scandir($path);
        foreach ($objects as $object) {
            if ($object != '.' && $object != '..') {
                remove($path . '/' . $object);
            }
        }
        reset($objects);
        rmdir($path);
    }
}
