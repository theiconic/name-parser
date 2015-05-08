<?php

namespace TheIconic\NameParser\Mapper;

use TheIconic\NameParser\Part\AbstractPart;
use TheIconic\NameParser\Part\Firstname;
use TheIconic\NameParser\Part\Lastname;
use TheIconic\NameParser\Part\Initial;
use TheIconic\NameParser\Part\Salutation;

class FirstnameMapper
{

    public function map($parts) {
        if (count($parts) < 2) {
            if ($parts[0] instanceof AbstractPart) {
                return $parts;
            }

            $parts[0] = new Firstname($parts[0]);

            return $parts;
        }

        // skip to after salutation
        $length = count($parts);
        $start = 0;
        for ($i = 0; $i < $length; $i++) {
            if ($parts[$i] instanceof Salutation) {
                $start = $i + 1;
            }
        }

        for ($k = $start; $k < $length; $k++) {
            $part = $parts[$k];

            if ($part instanceof Lastname) {
                break;
            }

            if ($part instanceof Initial) {
                if (!isset($parts[$k-1]) || $parts[$k-1] instanceof Firstname || $parts[$k-1] instanceof Initial) {
                    continue;
                }

                $parts[$k] = new Firstname($part);
            }

            if ($part instanceof AbstractPart) {
                break;
            }

            $parts[$k] = new Firstname($part);
        }

        return $parts;
    }

}
