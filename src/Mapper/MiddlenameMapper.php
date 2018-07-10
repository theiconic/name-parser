<?php

namespace TheIconic\NameParser\Mapper;

use TheIconic\NameParser\Part\AbstractPart;
use TheIconic\NameParser\Part\Firstname;
use TheIconic\NameParser\Part\Lastname;
use TheIconic\NameParser\Part\Middlename;

class MiddlenameMapper extends AbstractMapper
{
    protected $mapWithoutLastname = false;

    public function __construct(bool $mapWithoutLastname = false)
    {
        $this->mapWithoutLastname = $mapWithoutLastname;
    }

    /**
     * map middlenames in the parts array
     *
     * @param array $parts the name parts
     * @return array the mapped parts
     */
    public function map(array $parts): array
    {
        // If we don't expect a lastname, match a mimimum of 2 parts
        $minumumParts = ($this->mapWithoutLastname ? 2 : 3);

        if (count($parts) < $minumumParts) {
            return $parts;
        }

        $start = $this->findFirstMapped(Firstname::class, $parts);

        if (false === $start) {
            return $parts;
        }

        return $this->mapFrom($start, $parts);
    }

    /**
     * @param $start
     * @param $parts
     * @return mixed
     */
    protected function mapFrom($start, $parts): array
    {
        // If we don't expect a lastname, include the last part,
        // otherwise skip the last (-1) because it should be a lastname
        $length = count($parts) - ($this->mapWithoutLastname ? 0 : 1);

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
