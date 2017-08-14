<?php

namespace TheIconic\NameParser\Mapper;

use TheIconic\NameParser\Part\AbstractPart;
use TheIconic\NameParser\Part\Lastname;
use TheIconic\NameParser\Part\Suffix;

class LastnameMapper extends AbstractMapper
{
    /**
     * @var array options
     */
    protected $options = [
        'match_single' => false,
    ];

    /**
     * map lastnames in the parts array
     *
     * @param array $parts the name parts
     * @return array the mapped parts
     */
    public function map(array $parts)
    {
        if (!$this->options['match_single'] && count($parts) < 2) {
            return $parts;
        }

        if (count($parts) === 2 && $parts[0] instanceof AbstractPart) {
            $parts[1] = new Lastname($parts[1]);
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
        foreach ($parts as $k => $part) {
            if ($part instanceof Suffix) {
                continue;
            }

            if ($part instanceof AbstractPart) {
                break;
            }

            $originalIndex = count($parts) - $k - 1;
            $originalParts = array_reverse($parts);

            if ($this->isFollowedByLastnamePart($originalParts, $originalIndex)) {
                if ($this->isApplicablePrefix($originalParts, $originalIndex)) {
                    $lastname = new Lastname($part);
                    $lastname->setApplyPrefix(true);
                    $parts[$k] = $lastname;
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
        $next = $index + 1;

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
        if (!Lastname::isPrefix($parts[$index])) {
            return false;
        }

        return $this->hasUnmappedPartsBefore($parts, $index);
    }
}
