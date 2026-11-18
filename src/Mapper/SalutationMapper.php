<?php

declare(strict_types=1);

namespace TheIconic\NameParser\Mapper;

use TheIconic\NameParser\Part\AbstractPart;
use TheIconic\NameParser\Part\Salutation;

class SalutationMapper extends AbstractMapper
{
    /**
     * @param array<string, string> $salutations lowercase lookup key => normalized salutation
     * @param int $maxIndex highest index a salutation may start at, 0 = first half of the name
     */
    public function __construct(
        protected readonly array $salutations,
        protected readonly int $maxIndex = 0,
    ) {
    }

    /**
     * map salutations in the parts array
     *
     * @param array<int, AbstractPart|string> $parts the name parts
     * @return array<int, AbstractPart|string> the mapped parts
     */
    public function map(array $parts): array
    {
        $max = ($this->maxIndex > 0) ? $this->maxIndex : intdiv(count($parts), 2);

        // count($parts) is re-evaluated because multi-word salutations shrink the array
        for ($k = 0; $k < $max && $k < count($parts); $k++) {
            if ($parts[$k] instanceof AbstractPart) {
                break;
            }

            $parts = $this->substituteWithSalutation($parts, $k);
        }

        return $parts;
    }

    /**
     * We pass the full parts array and the current position to allow
     * not only single-word matches but also combined matches with
     * subsequent words (parts).
     *
     * @param array<int, AbstractPart|string> $parts
     * @return array<int, AbstractPart|string>
     */
    protected function substituteWithSalutation(array $parts, int $start): array
    {
        if ($this->isSalutation($parts[$start])) {
            $parts[$start] = new Salutation($parts[$start], $this->salutations[$this->getKey($parts[$start])]);
            return $parts;
        }

        foreach ($this->salutations as $key => $salutation) {
            $keys = explode(' ', $key);
            $length = count($keys);

            $subset = array_slice($parts, $start, $length);

            if ($this->isMatchingSubset($keys, $subset)) {
                array_splice($parts, $start, $length, [new Salutation(implode(' ', $subset), $salutation)]);
                return $parts;
            }
        }

        return $parts;
    }

    /**
     * check if the given subset matches the given keys entry by entry,
     * which means word by word, except that we first need to key-ify
     * the subset words
     *
     * @param string[] $keys
     * @param array<int, AbstractPart|string> $subset
     */
    private function isMatchingSubset(array $keys, array $subset): bool
    {
        foreach ($subset as $i => $word) {
            // already mapped parts (e.g. nicknames) can't be part of a salutation
            if (!is_string($word) || $this->getKey($word) !== $keys[$i]) {
                return false;
            }
        }

        return true;
    }

    /**
     * check if the given word is a viable salutation
     */
    protected function isSalutation(string $word): bool
    {
        return array_key_exists($this->getKey($word), $this->salutations);
    }
}
