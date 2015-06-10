<?php
/*
 * Converts any type of value to an array.
 *
 * @param mixed $value   Any type of array-convertible value
 * @param mixed $default Default return value; defaults to array()
 *
 * @return array
 */
function array_convert($value, $default = array())
{
    if (is_array($value)) return $value;

    if ($value instanceof \Traversable) {
        return iterator_to_array($value);
    } elseif (is_object($value)) {
        return get_object_vars($value);
    } elseif (is_string($value)) {
        return str_split($value);
    } elseif (is_scalar($value) || is_null($value)) {
        return array($value);
    }

    return $default;
}
