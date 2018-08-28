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

        $parts = array_reverse($parts);

        $parts = $this->mapReversedParts($parts);

        return array_reverse($parts);
    }

    /**
     * @param array $parts
     * @return array
     */
    protected function mapReversedParts(array $parts): array
    {
        $length = count($parts);

        foreach ($parts as $k => $part) {
            if ($part instanceof Suffix || $part instanceof Nickname || $part instanceof Salutation) {
                continue;
            }

            if ($part instanceof AbstractPart) {
                break;
            }

            $originalIndex = $length - $k - 1;
            $originalParts = array_reverse($parts);

            if ($this->isFollowedByLastnamePart($originalParts, $originalIndex)) {
                if ($this->isApplicablePrefix($originalParts, $originalIndex)) {
                    $parts[$k] = new LastnamePrefix($part, $this->prefixes[$this->getKey($part)]);
                    continue;
                }
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
