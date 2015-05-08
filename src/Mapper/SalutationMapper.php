<?php

namespace TheIconic\NameParser\Mapper;

use TheIconic\NameParser\Part\AbstractPart;
use TheIconic\NameParser\Part\Salutation;

class SalutationMapper
{

    protected $salutations = [
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

    function map(array $parts) {
        foreach ($parts as $k => $part) {
            if ($part instanceof AbstractPart) {
                break;
            }

            $part = str_replace('.', '', $part);
            $part = strtolower($part);

            if (array_key_exists($part, $this->salutations)) {
                $parts[$k] = new Salutation($this->salutations[$part]);
            }
        }

        return $parts;
    }

}
