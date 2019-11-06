<?php

namespace TheIconic\NameParser\Mapper;

use TheIconic\NameParser\LanguageInterface;
use TheIconic\NameParser\Part\AbstractPart;
use TheIconic\NameParser\Part\Lastname;
use TheIconic\NameParser\Part\LastnamePrefix;
use TheIconic\NameParser\Part\Nickname;
use TheIconic\NameParser\Part\Salutation;
use TheIconic\NameParser\Part\Suffix;

class LastnameMapper extends AbstractMapper
{
    protected $prefixes = [];

    protected $matchSinglePart = false;

    public function __construct(array $prefixes, bool $matchSinglePart = false)
    {
        $this->prefixes = $prefixes;
        $this->matchSinglePart = $matchSinglePart;
    }

    /**
     * map lastnames in the parts array
     *
     * @param array $parts the name parts
     * @return array the mapped parts
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
     * @param array $parts
     * @return array
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
     * @param array $parts
     * @param int $k
     * @return Lastname|null
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
     *
     * @param string $part
     * @return bool
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
     * @param array $parts
     * @return int
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
     * @param array $parts
     * @param int $k
     * @return bool
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
     *
     * @param $part
     * @return bool
     */
    protected function isIgnoredPart($part) {
        return $part instanceof Suffix || $part instanceof Nickname || $part instanceof Salutation;
    }

    /**
     * remap ignored parts as lastname
     *
     * if the mapping did not derive any lastname this is called to transform
     * any previously ignored parts into lastname parts
     *
     * @param array $parts
     * @return array
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
     * @param array $parts
     * @param int $index
     * @return bool
     */
    protected function isFollowedByLastnamePart(array $parts, int $index): bool
    {
        $next = $this->skipNicknameParts($parts, $index + 1);

        return (isset($parts[$next]) && $parts[$next] instanceof Lastname);
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
     * @param array $parts
     * @param int $index
     * @return bool
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
     *
     * @param string $word the word to check
     * @return bool
     */
    protected function isPrefix($word): bool
    {
        return (array_key_exists($this->getKey($word), $this->prefixes));
    }

    /**
     * find the next non-nickname index in parts
     *
     * @param $parts
     * @param $startIndex
     * @return int|void
     */
    protected function skipNicknameParts($parts, $startIndex)
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
