<?php

declare(strict_types=1);

namespace TheIconic\NameParser\Mapper;

use TheIconic\NameParser\Part\AbstractPart;

abstract class AbstractMapper
{
    /**
     * implements the mapping of parts
     *
     * @param array<int, AbstractPart|string> $parts the name parts
     * @return array<int, AbstractPart|string> the mapped parts
     */
    abstract public function map(array $parts): array;

    /**
     * checks if there are still unmapped parts left before the given position
     *
     * @param array<int, AbstractPart|string> $parts
     */
    protected function hasUnmappedPartsBefore(array $parts, int $index): bool
    {
        foreach ($parts as $k => $part) {
            if ($k === $index) {
                break;
            }

            if (!($part instanceof AbstractPart)) {
                return true;
            }
        }

        return false;
    }

    /**
     * find the index of the first part of the given type
     *
     * @param class-string<AbstractPart> $type
     * @param array<int, AbstractPart|string> $parts
     */
    protected function findFirstMapped(string $type, array $parts): int|false
    {
        $total = count($parts);

        for ($i = 0; $i < $total; $i++) {
            if ($parts[$i] instanceof $type) {
                return $i;
            }
        }

        return false;
    }

    /**
     * get the registry lookup key for the given word
     */
    protected function getKey(string $word): string
    {
        return strtolower(str_replace('.', '', $word));
    }
}
