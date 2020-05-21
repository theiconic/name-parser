<?php

namespace TheIconic\NameParser;

if (!function_exists('TheIconic\NameParser\strlen')) {
    function strlen(string $string): int
    {
        return \mb_strlen($string, 'UTF-8');
    }
}

if (!function_exists('TheIconic\NameParser\tcword')) {
    function tcword(string $string): string
    {
        return \mb_convert_case($string, MB_CASE_TITLE, 'UTF-8');
    }
}

if (!function_exists('TheIconic\NameParser\characters')) {
    function characters(string $string): array
    {
        return $charactersAsArray = \preg_split('//u', $string, null, PREG_SPLIT_NO_EMPTY);
    }
}

if (!function_exists('TheIconic\NameParser\substr')) {
    function substr(string $string, int $start, int $length = null): string
    {
        return \mb_substr($string, $start, $length, 'UTF-8');
    }
}
