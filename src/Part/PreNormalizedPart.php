<?php

namespace TheIconic\NameParser\Part;

abstract class PreNormalizedPart extends AbstractPart
{
    protected $normalized = '';

    public function __construct(string $value, string $normalized = null)
    {
        $this->normalized = $normalized ?? $value;

        parent::__construct($value);
    }

    /**
     * if this is a lastname prefix, look up normalized version from registry
     * otherwise camelcase the lastname
     *
     * @return string
     */
    public function normalize(): string
    {
        return $this->normalized;
    }
}
