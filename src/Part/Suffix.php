<?php

namespace TheIconic\NameParser\Part;

class Suffix extends AbstractPart
{
    /**
     * @var array possible suffixes
     */
    protected static $suffixes = [
        '1st' => '1st',
        '2nd' => '2nd',
        '3rd' => '3rd',
        '4th' => '4th',
        '5th' => '5th',
        'i' => 'I',
        'ii' => 'II',
        'iii' => 'III',
        'iv' => 'IV',
        'v' => 'V',
        'apr' => 'APR',
        'cme' => 'CME',
        'dmd' => 'DMD',
        'jr' => 'Jr',
        'junior' => 'Junior',
        'ma' => 'MA',
        'md' => 'MD',
        'pe' => 'PE',
        'phd' => 'PhD',
        'rph' => 'RPh',
        'senior' => 'Senior',
        'sr' => 'Sr',
    ];

    /**
     * check if the given word is a viable suffix
     *
     * @param string $word the word to check
     * @return bool
     */
    public static function isSuffix($word): bool
    {
        return (array_key_exists(self::getKey($word), static::$suffixes));
    }

    /**
     * get the registry lookup key for the given word
     *
     * @param string $word the word
     * @return string the key
     */
    protected static function getKey($word): string
    {
        return strtolower(str_replace('.', '', $word));
    }

    /**
     * lookup the normalized suffix from the registry
     *
     * @return string
     */
    public function normalize(): string
    {
        return static::$suffixes[self::getKey($this->getValue())];
    }
}
