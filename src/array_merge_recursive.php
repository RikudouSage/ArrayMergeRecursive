<?php

namespace Rikudou\ArrayMergeRecursive;

function array_merge_recursive(array $array1, array $array2, array ...$arrays)
{
    // where is the array spread operator when you need it?
    array_unshift($arrays, $array2);
    array_unshift($arrays, $array1);

    $merged = [];
    while ($arrays) {
        $array = array_shift($arrays);
        assert(is_array($array));
        if (!$array) {
            continue;
        }

        foreach ($array as $key => $value) {
            if (is_string($key)) {
                if (is_array($value) && array_key_exists($key, $merged) && is_array($merged[$key])) {
                    $merged[$key] = array_merge_recursive($merged[$key], $value);
                } else {
                    $merged[$key] = $value;
                }
            } else {
                $merged[] = $value;
            }
        }
    }

    return $merged;
}
