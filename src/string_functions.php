<?php

if (!function_exists('TheIconic\NameParser\strlen')) {
    if (extension_loaded('mbstring')) {
        require __DIR__ . '/string_functions_mbstring.php';
    } else {
        require __DIR__ . '/string_functions_native.php';
    }
}
