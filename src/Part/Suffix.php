<?php

namespace TheIconic\NameParser\Part;

class Suffix extends AbstractPart
{
    /**
     * @var array possible suffixes
     */
    protected static $suffixes = [
        'i' => 'I',
        'ii' => 'II',
        'iii' => 'III',
        'iv' => 'IV',
        'v' => 'V',
        '1st' => '1st',
        '2nd' => '2nd',
        '3rd' => '3rd',
        '4th' => '4th',
        '5th' => '5th',
        'senior' => 'Senior',
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

    /**
     * check if the given word is a viable suffix
     *
     * @param string $word the word to check
     * @return bool
     */
    public static function isSuffix($word)
    {
        return (array_key_exists(self::getKey($word), static::$suffixes));
    }

    /**
     * get the registry lookup key for the given word
     *
     * @param string $word the word
     * @return string the key
     */
    protected static function getKey($word)
    {
        return strtolower(str_replace('.', '', $word));
    }

    /**
     * lookup the normalized suffix from the registry
     *
     * @return mixed
     */
    public function normalize()
    {
        return static::$suffixes[self::getKey($this->getValue())];
    }
}
