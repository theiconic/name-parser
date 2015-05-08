<?php

namespace TheIconic\NameParser;

class Name
{

    protected $parts;

    public function __construct($parts = null)
    {
        if (null !== $parts) {
            $this->parts = $parts;
        }
    }

    public function getFirstname()
    {
        return $this->export('Firstname');
    }

    public function getLastname()
    {
        return $this->export('Lastname');
    }

    public function getInitials()
    {
        return $this->export('Initial');
    }

    public function getSuffix()
    {
        return $this->export('Suffix');
    }

    public function getSalutation()
    {
        return $this->export('Salutation');
    }

    protected function export($type)
    {
        $matched = [];

        foreach ($this->parts as $part) {
            if ($part instanceof AbstractPart && is_subclass_of($part, $type)) {
                $matched[] = $part->getValue();
            }
        }

        return implode(' ',  $matched);
    }

}
