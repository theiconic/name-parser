<?php

namespace TheIconic\NameParser\Mapper;

use TheIconic\NameParser\Part\AbstractPart;
use TheIconic\NameParser\Part\Suffix;

class SuffixMapper
{

    protected $suffixes = [
        'i' => 'I',
        'ii' => 'II',
        'iii' => 'III',
        'iv' => 'IV',
        'v' => 'V',
        'seniour' => 'Senior',
        'junior' => 'Junior',
        'jr' => 'Jr',
        'sr' => 'Sr',
        'phd' => 'PhD',
        'apr' => 'APR',
        'rph' => 'RPh',
        'pe' => 'PE',
        'md' => 'MD',
        'ma' => 'MA',
        'dmd' => 'DMD',
        'cme' => 'CME',
    ];

    function map(array $parts) {
        $parts = array_reverse($parts);
        foreach ($parts as $k => $part) {
            if ($part instanceof AbstractPart) {
                break;
            }

            $part = str_replace('.', '', $part);
            $part = strtolower($part);

            if (array_key_exists($part, $this->suffixes)) {
                $parts[$k] = new Suffix($this->suffixes[$part]);
            }
        }

        return array_reverse($parts);
    }

}
