<?php

namespace TheIconic\NameParser;

use TheIconic\NameParser\Part\AbstractPart;
use TheIconic\NameParser\Part\GivenNamePart;

class Name
{
    private const PARTS_NAMESPACE = 'TheIconic\NameParser\Part';

    /**
     * @var array the parts that make up this name
     */
    protected $parts = [];

    /**
     * constructor takes the array of parts this name consists of
     *
     * @param array|null $parts
     */
    public function __construct(array $parts = null)
    {
        if (null !== $parts) {
            $this->setParts($parts);
        }
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return implode(' ', $this->getAll(true));
    }

    /**
     * set the parts this name consists of
     *
     * @param array $parts
     * @return $this
     */
    public function setParts(array $parts): Name
    {
        $this->parts = $parts;

        return $this;
    }

    /**
     * get the parts this name consists of
     *
     * @return array
     */
    public function getParts(): array
    {
        return $this->parts;
    }

    /**
     * @param bool $format
     * @return array
     */
    public function getAll(bool $format = false): array
    {
        $results = [];
        $keys = [
            'salutation' => [],
            'title' => [],
            'firstname' => [],
            'nickname' => [$format],
            'middlename' => [],
            'initials' => [],
            'extension' => [],
            'lastname' => [],
            'suffix' => [],
            'company' => [],
        ];

        foreach ($keys as $key => $args) {
            $method = sprintf('get%s', ucfirst($key));
            if ($value = call_user_func_array(array($this, $method), $args)) {
                $results[$key] = $value;
            };
        }

        return $results;
    }

    /**
     * get the given name (first name, middle names and initials)
     * in the order they were entered while still applying normalisation
     *
     * @return string
     */
    public function getGivenName(): string
    {
        return $this->export('GivenNamePart');
    }

    /**
     * get the given name followed by the last name (including any prefixes)
     *
     * @return string
     */
    public function getFullName(): string
    {
        return sprintf('%s %s', $this->getGivenName(), $this->getLastname());
    }

    /**
     * get the first name
     *
     * @return string
     */
    public function getFirstname(): string
    {
        return $this->export('Firstname');
    }

    /**
     * get the last name
     *
     * @param bool $pure
     * @return string
     */
    public function getLastname(bool $pure = false): string
    {
        return $this->export('Lastname', $pure);
    }

    /**
     * get the last name prefix
     *
     * @return string
     */
    public function getLastnamePrefix(): string
    {
        return $this->export('LastnamePrefix');
    }

    /**
     * get the initials
     *
     * @return string
     */
    public function getInitials(): string
    {
        return $this->export('Initial');
    }

    /**
     * get the suffix(es)
     *
     * @return string
     */
    public function getSuffix(): string
    {
        return $this->export('Suffix');
    }

    /**
     * get the salutation(s)
     *
     * @return string
     */
    public function getSalutation(): string
    {
        return $this->export('Salutation');
    }

    /**
     * get the nick name(s)
     *
     * @param bool $wrap
     * @return string
     */
    public function getNickname(bool $wrap = false): string
    {
        if ($wrap) {
            return sprintf('(%s)', $this->export('Nickname'));
        }

        return $this->export('Nickname');
    }

    /**
     * get the middle name(s)
     *
     * @return string
     */
    public function getMiddlename(): string
    {
        return $this->export('Middlename');
    }

    /**
     * get the company
     *
     * @return string
     */
    public function getCompany(): string
    {
        return $this->export('Company');
    }

    /**
     * get the extension
     *
     * @return string
     */
    public function getExtension(): string
    {
        return $this->export('Extension');
    }

    /**
     * get the titles(s)
     *
     * @return string
     */
    public function getTitle(): string
    {
        return $this->export('Title');
    }

    /**
     * get an array with well formated names and their separators,
     * where the keys are representing vCard properties
     * see: https://tools.ietf.org/html/rfc6350#section-6.2.2
     *
     * @return array
     */
    public function getVCardArray(): array
    {
        return [
            'FN' => implode(' ', array_diff_key($this->getAll(), [
                'nickname' => $this->getNickname(),     // fullname with stripped off nickname
                ])),
            'N' => implode(';', array_filter([          // RFC6350: five segments in sequence:
                $this->getLastname(true),               // 1. Family Names (also known as surnames)
                $this->getFirstname(),                  // 2. Given Names
                implode(',', array_filter([             // 3. Additional Names
                    str_replace(' ', ',', $this->getMiddlename()),
                    $this->getInitials(),
                ])),
                implode(',', array_filter([             // 4. Honorific Prefixes
                    $this->getSalutation(),
                    $this->getTitle(),
                ])),
                implode(',', array_filter([             // 5. Honorific Suffixes
                    $this->getExtension(),
                    $this->getLastnamePrefix(),
                    $this->getSuffix(),
                ])),
            ])),
            'NICKNAME' => $this->getNickname(),
            'ORG'      => $this->getCompany(),
        ];
    }

    /**
     * helper method used by getters to extract and format relevant name parts
     *
     * @param string $type
     * @param bool $strict
     * @return string
     */
    protected function export(string $type, bool $strict = false): string
    {
        $matched = [];

        foreach ($this->parts as $part) {
            if ($part instanceof AbstractPart && $this->isType($part, $type, $strict)) {
                $matched[] = $part->normalize();
            }
        }

        return implode(' ',  $matched);
    }

    /**
     * helper method to check if a part is of the given type
     *
     * @param AbstractPart $part
     * @param string $type
     * @param bool $strict
     * @return bool
     */
    protected function isType(AbstractPart $part, string $type, bool $strict = false): bool
    {
        $className = sprintf('%s\\%s', self::PARTS_NAMESPACE, $type);

        if ($strict) {
            return get_class($part) === $className;
        }

        return is_a($part, $className);
    }
}
