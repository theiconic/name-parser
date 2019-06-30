<?php

namespace TheIconic\NameParser\Mapper;

use TheIconic\NameParser\Part\AbstractPart;
use TheIconic\NameParser\Part\Firstname;
use TheIconic\NameParser\Part\Lastname;
use TheIconic\NameParser\Part\Middlename;
use TheIconic\NameParser\Part\Fullgivenname;

class FullgivennameMapper extends AbstractMapper
{

    /**
     * map middlenames in the parts array
     *
     * @param array $parts the name parts
     * @return array the mapped parts
     */
    public function map(array $parts): array
    {
        $givenNameParts = [];
        foreach ($parts as $part) {
            if (
                ($part instanceof \TheIconic\NameParser\Part\Firstname)
                || ($part instanceof \TheIconic\NameParser\Part\Middlename)
                || ($part instanceof \TheIconic\NameParser\Part\Initial)
            ) {
                $givenNameParts[] = $part->normalize();
            }
        }
        if (count($givenNameParts) > 0) {
            $parts[] = new Fullgivenname(implode(' ', $givenNameParts));
        }
        return $parts;
    }
}
