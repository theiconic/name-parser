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
        if (preg_match('/\p{L}(\p{Lu}*\p{Ll}\p{Ll}*\p{Lu}|\p{Ll}*\p{Lu}\p{Lu}*\p{Ll})\p{L}*/u', $word)) {
            return $word;
        }

        return preg_replace_callback('/[\p{L}0-9]+/ui', [$this, 'camelcaseReplace'], $word);
    }

    /**
     * camelcasing callback
     *
     * @param $matches
     * @return string
     */
    protected function camelcaseReplace($matches): string
    {
        if (function_exists('mb_convert_case')) {
            return mb_convert_case($matches[0], MB_CASE_TITLE, 'UTF-8');
        }
        
        return ucfirst(strtolower($matches[0]));
    }
}
