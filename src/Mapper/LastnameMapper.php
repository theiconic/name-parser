<?php

namespace TheIconic\NameParser\Mapper;

use TheIconic\NameParser\Part\AbstractPart;
use TheIconic\NameParser\Part\Lastname;
use TheIconic\NameParser\Part\Suffix;

class LastnameMapper
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

        foreach ($parts as $k => $part) {
            if ($part instanceof Suffix) {
                continue;
            }

            if ($part instanceof AbstractPart) {
                break;
            }

            if (false !== $prefix = $this->isPrefix($part)) {
                if (isset($parts[$k-1]) && $parts[$k-1] instanceof Lastname) {
                    $parts[$k] = new Lastname($prefix);
                }
            } else if (!isset($parts[$k-1]) || !($parts[$k-1] instanceof Lastname)) {
                $parts[$k] = new Lastname($part);
            } else {
                break;
            }
        }

        return array_reverse($parts);
    }

    protected function isPrefix($part)
    {
        $part = str_replace('.', '', $part);
        $part = strtolower($part);

        if (array_key_exists($part, $this->prefixes)) {
            return $this->prefixes[$part];
        }

        return false;
    }

}
