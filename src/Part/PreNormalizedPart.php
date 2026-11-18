<?php

declare(strict_types=1);

namespace TheIconic\NameParser\Part;

abstract class PreNormalizedPart extends AbstractPart
{
    protected readonly string $normalized;

    /**
     * @param string $normalized normalized form of the value, defaults to the value itself
     */
    public function __construct(string $value, ?string $normalized = null)
    {
        $this->normalized = $normalized ?? $value;

        parent::__construct($value);
    }

    /**
     * return the normalized version looked up from the language registry
     */
    public function normalize(): string
    {
        return $this->normalized;
    }
}
