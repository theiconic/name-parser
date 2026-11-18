<?php

declare(strict_types=1);

namespace TheIconic\NameParser\Mapper;

use TheIconic\NameParser\Part\AbstractPart;
use TheIconic\NameParser\Part\Firstname;
use TheIconic\NameParser\Part\Initial;
use TheIconic\NameParser\Part\Lastname;
use TheIconic\NameParser\Part\Salutation;

class FirstnameMapper extends AbstractMapper
{
    /**
     * map firstnames in parts array
     *
     * @param array<int, AbstractPart|string> $parts the parts
     * @return array<int, AbstractPart|string> the mapped parts
     */
    public function map(array $parts): array
    {
        if (count($parts) < 2) {
            return [$this->handleSinglePart($parts[0])];
        }

        $pos = $this->findFirstnamePosition($parts);

        if (null !== $pos) {
            $parts[$pos] = new Firstname($parts[$pos]);
        }

        return $parts;
    }

    protected function handleSinglePart(AbstractPart|string $part): AbstractPart
    {
        if ($part instanceof AbstractPart) {
            return $part;
        }

        return new Firstname($part);
    }

    /**
     * @param array<int, AbstractPart|string> $parts
     */
    protected function findFirstnamePosition(array $parts): ?int
    {
        $pos = null;

        $length = count($parts);
        $start = $this->getStartIndex($parts);

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

            return $k;
        }

        return $pos;
    }

    /**
     * @param array<int, AbstractPart|string> $parts
     */
    protected function getStartIndex(array $parts): int
    {
        $index = $this->findFirstMapped(Salutation::class, $parts);

        if (false === $index) {
            return 0;
        }

        if ($index === count($parts) - 1) {
            return 0;
        }

        return $index + 1;
    }
}
