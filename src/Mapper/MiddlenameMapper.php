<?php

declare(strict_types=1);

namespace TheIconic\NameParser\Mapper;

use TheIconic\NameParser\Part\AbstractPart;
use TheIconic\NameParser\Part\Firstname;
use TheIconic\NameParser\Part\Lastname;
use TheIconic\NameParser\Part\Middlename;

class MiddlenameMapper extends AbstractMapper
{
    /**
     * @param bool $mapWithoutLastname whether the last part may be mapped as a middlename
     */
    public function __construct(
        protected readonly bool $mapWithoutLastname = false,
    ) {
    }

    /**
     * map middlenames in the parts array
     *
     * @param array<int, AbstractPart|string> $parts the name parts
     * @return array<int, AbstractPart|string> the mapped parts
     */
    public function map(array $parts): array
    {
        // If we don't expect a lastname, match a minimum of 2 parts
        $minimumParts = $this->mapWithoutLastname ? 2 : 3;

        if (count($parts) < $minimumParts) {
            return $parts;
        }

        $start = $this->findFirstMapped(Firstname::class, $parts);

        if (false === $start) {
            return $parts;
        }

        return $this->mapFrom($start, $parts);
    }

    /**
     * @param array<int, AbstractPart|string> $parts
     * @return array<int, AbstractPart|string>
     */
    protected function mapFrom(int $start, array $parts): array
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
