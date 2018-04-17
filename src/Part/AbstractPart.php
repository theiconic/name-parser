<?php

namespace TheIconic\NameParser\Part;

abstract class AbstractPart
{
    /**
     * @var string the wrapped value
     */
    protected $value;

    /**
     * constructor allows passing the value to wrap
     *
     * @param $value
     */
    public function __construct($value)
    {
        $this->setValue($value);
    }

    /**
     * set the value to wrap
     * (can take string or part instance)
     *
     * @param string|AbstractPart $value
     * @return $this
     */
    public function setValue($value): AbstractPart
    {
        if ($value instanceof AbstractPart) {
            $value = $value->getValue();
        }

        $this->value = $value;

        return $this;
    }

    /**
     * get the wrapped value
     *
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * get the normalized value
     *
     * @return string
     */
    public function normalize(): string
    {
        return $this->getValue();
    }

    /**
     * helper for camelization of values
     * to be used during normalize
     *
     * @param $word
     * @return mixed
     */
    protected function camelcase($word): string
    {
        if (preg_match('/[A-Za-z]([A-Z]*[a-z][a-z]*[A-Z]|[a-z]*[A-Z][A-Z]*[a-z])[A-Za-z]*/', $word)) {
            return $word;
        }

        return preg_replace_callback('/[a-z0-9]+/i', [$this, 'camelcaseReplace'], $word);
    }

    /**
     * camelcasing callback
     *
     * @param $matches
     * @return string
     */
    protected function camelcaseReplace($matches): string
    {
        return ucfirst(strtolower($matches[0]));
    }
}
