<?php

namespace TheIconic\NameParser\Mapper;

use TheIconic\NameParser\Part\AbstractPart;
use TheIconic\NameParser\Part\Extension;

/**
 * Mapper to identify lastname extensions (nobility predicates) in a name
 * @see /Language/German.php for more information
 */

class ExtensionMapper extends AbstractMapper
{
    protected $extensions = [];

    protected $matchSinglePart = false;

    protected $reservedParts = 2;

    public function __construct(array $extensions)
    {
        $this->extensions = $this->sortArrayDescending($extensions);
    }

    /**
     * map extensions in the parts array
     *
     * @param array $parts the name parts
     * @return array the mapped parts
     */
    public function map(array $parts): array
    {
        foreach ($parts as $key => $part) {
            if ($part instanceof AbstractPart) {
                continue;
            }
            if (in_array($part, $this->extensions)) {
                $parts[$key] = new Extension($parts[$key]);
            }
        }

        return $parts;
    }
}