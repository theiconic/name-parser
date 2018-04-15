<?php

namespace TheIconic\NameParser;

use TheIconic\NameParser\Part\AbstractPart;

class Name
{
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
            'firstname' => [],
            'nickname' => [$format],
            'middlename' => [],
            'initials' => [],
            'lastname' => [],
            'suffix' => [],
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
     * @return string
     */
    public function getLastname(): string
    {
        return $this->export('Lastname');
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
     * helper method used by getters to extract and format relevant name parts
     *
     * @param string $type the part type to export
     * @return string the exported parts
     */
    protected function export($type): string
    {
        $matched = [];

        foreach ($this->parts as $part) {
            if ($part instanceof AbstractPart && is_a($part, 'TheIconic\\NameParser\\Part\\' . $type)) {
                $matched[] = $part->normalize();
            }
        }

        return implode(' ',  $matched);
    }
}
