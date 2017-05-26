<?php

namespace TheIconic\NameParser\Mapper;

use TheIconic\NameParser\Part\AbstractPart;
use TheIconic\NameParser\Part\Firstname;
use TheIconic\NameParser\Part\Lastname;
use TheIconic\NameParser\Part\Middlename;

class MiddlenameMapper extends AbstractMapper
{
    /**
     * map middlenames in the parts array
     *
     * @param array $parts the name parts
     * @return array the mapped parts
     */
    public function map(array $parts)
    {
        if (count($parts) < 3) {
            return $parts;
        }

        $length = count($parts);
        $start = $this->findFirstMapped(Firstname::class, $parts);

        if (false === $start) {
            return $parts;
        }

        for ($k = $start; $k < $length - 1; $k++) {
            $part = $parts[$k];

            if ($part instanceof Lastname) {
                break;
            }

            if ($part instanceof AbstractPart) {
                continue;
            }

            $parts[$k] = new Middlename($part);
        }

        return $parts;
    }
}
