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
    public function map(array $parts) {
        if (count($parts) < 3) {
            return $parts;
        }

        // skip to after salutation
        $length = count($parts);
        $start = 0;
        for ($i = 0; $i < $length; $i++) {
            if ($parts[$i] instanceof Firstname) {
                $start = $i + 1;
            }
        }

        for ($k = $start; $k < $length; $k++) {
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
