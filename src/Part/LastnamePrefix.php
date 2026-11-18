<?php

declare(strict_types=1);

namespace TheIconic\NameParser\Part;

class LastnamePrefix extends Lastname
{
    protected readonly string $normalized;

    /**
     * @param string $normalized normalized form of the prefix, defaults to the value itself
     */
    public function __construct(string $value, ?string $normalized = null)
    {
        $this->normalized = $normalized ?? $value;

        parent::__construct($value);
    }

    /**
     * return the normalized prefix looked up from the language registry
     * (prefixes are not camelcased like the rest of the lastname)
     */
    public function normalize(): string
    {
        return $this->normalized;
    }
}
