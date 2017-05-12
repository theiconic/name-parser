<?php

namespace TheIconic\NameParser\Mapper;

use TheIconic\NameParser\Part\AbstractPart;
use TheIconic\NameParser\Part\Salutation;

class SalutationMapper extends AbstractMapper
{
    /**
     * map salutations in the parts array
     *
     * @param array $parts the name parts
     * @return array the mapped parts
     */
    public function map(array $parts)
    {
        foreach ($parts as $k => $part) {
            if ($part instanceof AbstractPart) {
                break;
            }

            if (Salutation::isSalutation($part)) {
                $parts[$k] = new Salutation($part);
            }
        }

        return $parts;
    }
}
