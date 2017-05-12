<?php

namespace TheIconic\NameParser\Part;

class Salutation extends AbstractPart
{
    /**
     * @var array possible salutations
     */
    protected static $salutations = [
        'mr' => 'Mr.',
        'master' => 'Mr.',
        'mister' => 'Mr.',
        'mrs' => 'Mrs.',
        'miss' => 'Ms.',
        'ms' => 'Ms.',
        'dr' => 'Dr.',
        'rev' => 'Rev.',
        'fr' => 'Fr.',
    ];

    /**
     * check if the given word is a viable salutation
     *
     * @param string $word the word to check
     * @return bool
     */
    public static function isSalutation($word)
    {
        return (array_key_exists(self::getKey($word), static::$salutations));
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
     * normalize by looking up the wrapped value against the registry
     *
     * @return mixed
     */
    public function normalize()
    {
        return static::$salutations[self::getKey($this->getValue())];
    }
}
