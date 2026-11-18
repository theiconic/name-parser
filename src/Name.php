<?php

declare(strict_types=1);

namespace TheIconic\NameParser;

use TheIconic\NameParser\Part\AbstractPart;
use TheIconic\NameParser\Part\Firstname;
use TheIconic\NameParser\Part\GivenNamePart;
use TheIconic\NameParser\Part\Initial;
use TheIconic\NameParser\Part\Lastname;
use TheIconic\NameParser\Part\LastnamePrefix;
use TheIconic\NameParser\Part\Middlename;
use TheIconic\NameParser\Part\Nickname;
use TheIconic\NameParser\Part\Salutation;
use TheIconic\NameParser\Part\Suffix;

class Name
{
    /**
     * @var array<int, AbstractPart|string> the parts that make up this name
     */
    protected array $parts = [];

    /**
     * constructor takes the array of parts this name consists of
     *
     * @param array<int, AbstractPart|string>|null $parts
     */
    public function __construct(?array $parts = null)
    {
        if (null !== $parts) {
            $this->setParts($parts);
        }
    }

    public function __toString(): string
    {
        return implode(' ', $this->getAll(true));
    }

    /**
     * set the parts this name consists of
     *
     * @param array<int, AbstractPart|string> $parts
     */
    public function setParts(array $parts): static
    {
        $this->parts = $parts;

        return $this;
    }

    /**
     * get the parts this name consists of
     *
     * @return array<int, AbstractPart|string>
     */
    public function getParts(): array
    {
        return $this->parts;
    }

    /**
     * get all non-empty name components keyed by component name
     *
     * @return array<string, string>
     */
    public function getAll(bool $format = false): array
    {
        return array_filter([
            'salutation' => $this->getSalutation(),
            'firstname' => $this->getFirstname(),
            'nickname' => $this->getNickname($format),
            'middlename' => $this->getMiddlename(),
            'initials' => $this->getInitials(),
            'lastname' => $this->getLastname(),
            'suffix' => $this->getSuffix(),
        ]);
    }

    /**
     * get the given name (first name, middle names and initials)
     * in the order they were entered while still applying normalisation
     */
    public function getGivenName(): string
    {
        return $this->export(GivenNamePart::class);
    }

    /**
     * get the given name followed by the last name (including any prefixes)
     */
    public function getFullName(): string
    {
        return sprintf('%s %s', $this->getGivenName(), $this->getLastname());
    }

    public function getFirstname(): string
    {
        return $this->export(Firstname::class);
    }

    /**
     * get the last name
     *
     * @param bool $pure only return the lastname itself, without any prefixes
     */
    public function getLastname(bool $pure = false): string
    {
        return $this->export(Lastname::class, $pure);
    }

    public function getLastnamePrefix(): string
    {
        return $this->export(LastnamePrefix::class);
    }

    public function getInitials(): string
    {
        return $this->export(Initial::class);
    }

    public function getSuffix(): string
    {
        return $this->export(Suffix::class);
    }

    public function getSalutation(): string
    {
        return $this->export(Salutation::class);
    }

    /**
     * get the nick name(s)
     *
     * @param bool $wrap wrap the nickname in parentheses
     */
    public function getNickname(bool $wrap = false): string
    {
        if ($wrap) {
            return sprintf('(%s)', $this->export(Nickname::class));
        }

        return $this->export(Nickname::class);
    }

    public function getMiddlename(): string
    {
        return $this->export(Middlename::class);
    }

    /**
     * helper method used by getters to extract and format relevant name parts
     *
     * @param class-string<AbstractPart> $type
     */
    protected function export(string $type, bool $strict = false): string
    {
        $matched = [];

        foreach ($this->parts as $part) {
            if ($part instanceof AbstractPart && $this->isType($part, $type, $strict)) {
                $matched[] = $part->normalize();
            }
        }

        return implode(' ', $matched);
    }

    /**
     * helper method to check if a part is of the given type
     *
     * @param class-string<AbstractPart> $type
     * @param bool $strict match the exact class only (no subclasses)
     */
    protected function isType(AbstractPart $part, string $type, bool $strict = false): bool
    {
        if ($strict) {
            return $part::class === $type;
        }

        return $part instanceof $type;
    }
}
