<?php

declare(strict_types=1);

namespace TheIconic\NameParser\Mapper;

use TheIconic\NameParser\Part\AbstractPart;
use TheIconic\NameParser\Part\Lastname;
use TheIconic\NameParser\Part\LastnamePrefix;
use TheIconic\NameParser\Part\Nickname;
use TheIconic\NameParser\Part\Salutation;
use TheIconic\NameParser\Part\Suffix;

class LastnameMapper extends AbstractMapper
{
    /**
     * @param array<string, string> $prefixes lowercase lookup key => normalized prefix
     * @param bool $matchSinglePart whether a single part may be mapped as lastname
     */
    public function __construct(
        protected readonly array $prefixes,
        protected readonly bool $matchSinglePart = false,
    ) {
    }

    /**
     * map lastnames in the parts array
     *
     * @param array<int, AbstractPart|string> $parts the name parts
     * @return array<int, AbstractPart|string> the mapped parts
     */
    public function map(array $parts): array
    {
        if (!$this->matchSinglePart && count($parts) < 2) {
            return $parts;
        }

        return $this->mapParts($parts);
    }

    /**
     * we map the parts in reverse order because it makes more
     * sense to parse for the lastname starting from the end
     *
     * @param array<int, AbstractPart|string> $parts
     * @return array<int, AbstractPart|string>
     */
    protected function mapParts(array $parts): array
    {
        $k = $this->skipIgnoredParts($parts) + 1;
        $remapIgnored = true;

        while (--$k >= 0) {
            $part = $parts[$k];

            if ($part instanceof AbstractPart) {
                break;
            }

            if ($this->isFollowedByLastnamePart($parts, $k)) {
                if ($mapped = $this->mapAsPrefixIfPossible($parts, $k)) {
                    $parts[$k] = $mapped;
                    continue;
                }

                if ($this->shouldStopMapping($parts, $k)) {
                    break;
                }
            }

            $parts[$k] = new Lastname($part);
            $remapIgnored = false;
        }

        if ($remapIgnored) {
            $parts = $this->remapIgnored($parts);
        }

        return $parts;
    }

    /**
     * try to map this part as a lastname prefix or as a combined
     * lastname part containing a prefix
     *
     * @param array<int, AbstractPart|string> $parts
     */
    private function mapAsPrefixIfPossible(array $parts, int $k): ?Lastname
    {
        if ($this->isApplicablePrefix($parts, $k)) {
            return new LastnamePrefix($parts[$k], $this->prefixes[$this->getKey($parts[$k])]);
        }

        if ($this->isCombinedWithPrefix($parts[$k])) {
            return new Lastname($parts[$k]);
        }

        return null;
    }

    /**
     * check if the given part is a combined lastname part
     * that ends in a lastname prefix
     */
    private function isCombinedWithPrefix(string $part): bool
    {
        $pos = strpos($part, '-');

        if (false === $pos) {
            return false;
        }

        return $this->isPrefix(substr($part, $pos + 1));
    }

    /**
     * skip through the parts we want to ignore and return the start index
     *
     * @param array<int, AbstractPart|string> $parts
     */
    protected function skipIgnoredParts(array $parts): int
    {
        $k = count($parts);

        while (--$k >= 0) {
            if (!$this->isIgnoredPart($parts[$k])) {
                break;
            }
        }

        return $k;
    }

    /**
     * indicates if we should stop mapping at the given index $k
     *
     * the assumption is that lastname parts have already been found
     * but we want to see if we should add more parts
     *
     * @param array<int, AbstractPart|string> $parts
     */
    protected function shouldStopMapping(array $parts, int $k): bool
    {
        if ($k < 1) {
            return true;
        }

        $lastPart = $parts[$k + 1];

        if ($lastPart instanceof LastnamePrefix) {
            return true;
        }

        return strlen($lastPart->getValue()) >= 3;
    }

    /**
     * indicates if the given part should be ignored (skipped) during mapping
     */
    protected function isIgnoredPart(AbstractPart|string $part): bool
    {
        return $part instanceof Suffix || $part instanceof Nickname || $part instanceof Salutation;
    }

    /**
     * remap ignored parts as lastname
     *
     * if the mapping did not derive any lastname this is called to transform
     * any previously ignored parts into lastname parts
     *
     * @param array<int, AbstractPart|string> $parts
     * @return array<int, AbstractPart|string>
     */
    protected function remapIgnored(array $parts): array
    {
        $k = count($parts);

        while (--$k >= 0) {
            $part = $parts[$k];

            if (!$this->isIgnoredPart($part)) {
                break;
            }

            $parts[$k] = new Lastname($part);
        }

        return $parts;
    }

    /**
     * @param array<int, AbstractPart|string> $parts
     */
    protected function isFollowedByLastnamePart(array $parts, int $index): bool
    {
        $next = $this->skipNicknameParts($parts, $index + 1);

        return isset($parts[$next]) && $parts[$next] instanceof Lastname;
    }

    /**
     * Assuming that the part at the given index is matched as a prefix,
     * determines if the prefix should be applied to the lastname.
     *
     * We only apply it to the lastname if we already have at least one
     * lastname part and there are other parts left in
     * the name (this effectively prioritises firstname over prefix matching).
     *
     * This expects the parts array and index to be in the original order.
     *
     * @param array<int, AbstractPart|string> $parts
     */
    protected function isApplicablePrefix(array $parts, int $index): bool
    {
        if (!$this->isPrefix($parts[$index])) {
            return false;
        }

        return $this->hasUnmappedPartsBefore($parts, $index);
    }

    /**
     * check if the given word is a lastname prefix
     */
    protected function isPrefix(string $word): bool
    {
        return array_key_exists($this->getKey($word), $this->prefixes);
    }

    /**
     * find the next non-nickname index in parts
     *
     * @param array<int, AbstractPart|string> $parts
     */
    protected function skipNicknameParts(array $parts, int $startIndex): int
    {
        $total = count($parts);

        for ($i = $startIndex; $i < $total; $i++) {
            if (!($parts[$i] instanceof Nickname)) {
                return $i;
            }
        }

        return $total - 1;
    }
}
