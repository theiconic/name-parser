<?php

namespace TheIconic\NameParser\Part;

class Lastname extends AbstractPart
{
    /**
     * @var array possible lastname prefixes
     */
    static protected $prefixes = [
        'vere' => 'vere',
        'von' => 'von',
        'van' => 'van',
        'de' => 'de',
        'der' => 'der',
        'del' => 'del',
        'della' => 'della',
        'di' => 'di',
        'da' => 'da',
        'pietro' => 'pietro',
        'vanden' => 'vanden',
        'du' => 'du',
        'st' => 'st.',
        'la' => 'la',
        'ter' => 'ter'
    ];

    /**
     * check if the given word is a lastname prefix
     *
     * @param string $word the word to check
     * @return bool
     */
    static public function isPrefix($word)
    {
        return (array_key_exists(self::getKey($word), static::$prefixes));
    }

    /**
     * get the prefix registry key for the given word
     *
     * @param string $word the word
     * @return string the key
     */
    static protected function getKey($word)
    {
        return strtolower(str_replace('.', '', $word));
    }

    /**
     * if this is a lastname prefix, look up normalized version from registry
     * otherwise camelcase the lastname
     *
     * @return mixed
     */
    public function normalize()
    {
        $value = $this->getValue();

        if (self::isPrefix($value)) {
            return static::$prefixes[self::getKey($value)];
        }

        return $this->camelcase($this->getValue());
    }
}
