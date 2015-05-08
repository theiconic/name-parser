<?php

namespace TheIconic\NameParser\Mapper;

use TheIconic\NameParser\Part\AbstractPart;
use TheIconic\NameParser\Part\Lastname;
use TheIconic\NameParser\Part\Suffix;

class FirstnameMapper
{

    protected $prefixes = [
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

    public function map(array $parts) {
        if (count($parts) < 2) {
            return $parts;
        }

        if (count($parts) === 2 && $parts[0] instanceof AbstractPart) {
            $parts[1] = new Lastname($parts[1]);
        }

        $parts = array_reverse($parts);

        $lastNames = [];

        foreach ($parts as $k => $part) {
            if ($part instanceof Suffix) {
                continue;
            }

            if ($part instanceof AbstractPart) {
                break;
            }

            if (false !== $prefix = $this->isPrefix($part)) {
                $lastNames[] = $prefix;
            }

            $parts[$k] = new Lastname(array_reverse($lastNames));
        }

        return array_reverse($parts);
    }

    protected function isPrefix($part)
    {
        if (array_key_exists($part, $this->prefixes)) {
            return $this->prefixes[$part];
        }

        return false;
    }

}
