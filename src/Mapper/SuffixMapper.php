<?php

declare(strict_types=1);

namespace TheIconic\NameParser\Mapper;

use TheIconic\NameParser\Part\AbstractPart;
use TheIconic\NameParser\Part\Suffix;

class SuffixMapper extends AbstractMapper
{
    /**
     * @param array<string, string> $suffixes lowercase lookup key => normalized suffix
     * @param bool $matchSinglePart whether a single part may be mapped as suffix
     * @param int $reservedParts number of leading parts that are never mapped as suffix
     */
    public function __construct(
        protected readonly array $suffixes,
        protected readonly bool $matchSinglePart = false,
        protected readonly int $reservedParts = 2,
    ) {
    }

    /**
     * map suffixes in the parts array
     *
     * @param array<int, AbstractPart|string> $parts the name parts
     * @return array<int, AbstractPart|string> the mapped parts
     */
    public function map(array $parts): array
    {
        if ($this->isMatchingSinglePart($parts)) {
            $parts[0] = new Suffix($parts[0], $this->suffixes[$this->getKey($parts[0])]);
            return $parts;
        }

        $start = count($parts) - 1;

        for ($k = $start; $k > $this->reservedParts - 1; $k--) {
            $part = $parts[$k];

            if (!$this->isSuffix($part)) {
                break;
            }

            $parts[$k] = new Suffix($part, $this->suffixes[$this->getKey($part)]);
        }

        return $parts;
    }

    /**
     * @param array<int, AbstractPart|string> $parts
     */
    protected function isMatchingSinglePart(array $parts): bool
    {
        if (!$this->matchSinglePart) {
            return false;
        }

        if (1 !== count($parts)) {
            return false;
        }

        return $this->isSuffix($parts[0]);
    }

    protected function isSuffix(AbstractPart|string $part): bool
    {
        if ($part instanceof AbstractPart) {
            return false;
        }

        return array_key_exists($this->getKey($part), $this->suffixes);
    }
}
