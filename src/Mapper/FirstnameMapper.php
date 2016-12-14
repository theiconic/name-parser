<?php

namespace TheIconic\NameParser\Mapper;

use TheIconic\NameParser\Part\AbstractPart;
use TheIconic\NameParser\Part\Firstname;
use TheIconic\NameParser\Part\Lastname;
use TheIconic\NameParser\Part\Initial;
use TheIconic\NameParser\Part\Salutation;

class FirstnameMapper extends AbstractMapper
{
    /**
     * map firstnames in parts array
     *
     * @param array $parts the parts
     * @return array the mapped parts
     */
    public function map(array $parts) {
        if (count($parts) < 2) {
            return [$this->handleSinglePart($parts[0])];
        }

        $length = count($parts);
        $start = $this->getStartIndex($parts, $length);

        $pos = null;

        for ($k = $start; $k < $length; $k++) {
            $part = $parts[$k];

            if ($part instanceof Lastname) {
                break;
            }

            if ($part instanceof Initial && null === $pos) {
                $pos = $k;
            }

            if ($part instanceof AbstractPart) {
                continue;
            }

            $pos = $k;
            break;
        }

        if (null !== $pos) {
            $parts[$pos] = new Firstname($parts[$pos]);
        }

        return $parts;
    }

    /**
     * @param $part
     * @return Firstname
     */
    protected function handleSinglePart($part)
    {
        if ($part instanceof AbstractPart) {
            return $part;
        }

        return new Firstname($part);
    }

    /**
     * @param array $parts
     * @param int $total
     * @return int
     */
    protected function getStartIndex(array $parts, $total)
    {
        // skip to after salutation
        $start = 0;

        for ($i = 0; $i < $total; $i++) {
            if ($parts[$i] instanceof Salutation) {
                $start = $i + 1;
            }
        }

        return $start;
    }
}
