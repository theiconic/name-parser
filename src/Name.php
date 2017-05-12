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
     * set the parts this name consists of
     *
     * @param array $parts
     * @return $this
     */
    public function setParts(array $parts)
    {
        $this->parts = $parts;

        return $this;
    }

    /**
     * get the parts this name consists of
     *
     * @return array
     */
    public function getParts()
    {
        return $this->parts;
    }

    /**
     * @return array
     */
    public function getAll()
    {
        $results = [];
        $keys = [
            'salutation',
            'firstname',
            'middlename',
            'lastname',
            'nickname',
            'initials',
            'suffix'
        ];

        foreach ($keys as $key) {
            $method = sprintf('get%s', ucfirst($key));
            if ($value = call_user_func(array($this, $method))) {
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
    public function getFirstname()
    {
        return $this->export('Firstname');
    }

    /**
     * get the last name
     *
     * @return string
     */
    public function getLastname()
    {
        return $this->export('Lastname');
    }

    /**
     * get the initials
     *
     * @return string
     */
    public function getInitials()
    {
        return $this->export('Initial');
    }

    /**
     * get the suffix(es)
     *
     * @return string
     */
    public function getSuffix()
    {
        return $this->export('Suffix');
    }

    /**
     * get the salutation(s)
     *
     * @return string
     */
    public function getSalutation()
    {
        return $this->export('Salutation');
    }

    /**
     * get the nick name(s)
     *
     * @return string
     */
    public function getNickname()
    {
        return $this->export('Nickname');
    }

    /**
     * get the middle name(s)
     *
     * @return string
     */
    public function getMiddlename()
    {
        return $this->export('Middlename');
    }

    /**
     * helper method used by getters to extract and format relevant name parts
     *
     * @param string $type the part type to export
     * @return string the exported parts
     */
    protected function export($type)
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
