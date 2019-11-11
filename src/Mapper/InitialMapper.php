<?php

namespace TheIconic\NameParser\Mapper;

use TheIconic\NameParser\Part\AbstractPart;
use TheIconic\NameParser\Part\Initial;

/**
 * single letter, possibly followed by a period
 */
class InitialMapper extends AbstractMapper
{
    protected $matchLastPart = false;

    private $combinedMax = 2;

    public function __construct(int $combinedMax = 2, bool $matchLastPart = false)
    {
        $this->matchLastPart = $matchLastPart;
        $this->combinedMax = $combinedMax;
    }

    /**
     * map intials in parts array
     *
     * @param array $parts the name parts
     * @return array the mapped parts
     */
    public function map(array $parts): array
    {
        $last = count($parts) - 1;

        for ($k = 0; $k < count($parts); $k++) {
            $part = $parts[$k];

            if ($part instanceof AbstractPart) {
                continue;
            }

            if (!$this->matchLastPart && $k === $last) {
                continue;
            }

            if (strtoupper($part) === $part) {
                $stripped = str_replace('.', '', $part);
                $length = strlen($stripped);

                if (1 < $length && $length <= $this->combinedMax) {
                    array_splice($parts, $k, 1, str_split($stripped));
                    $last = count($parts) - 1;
                    $part = $parts[$k];
                }
            }

            if ($this->isInitial($part)) {
                $parts[$k] = new Initial($part);
            }
        }

        return $parts;
    }

    /**
     * @param string $part
     * @return bool
     */
    protected function isInitial(string $part): bool
    {
        $length = strlen($part);

        if (1 === $length) {
            return true;
        }

        return ($length === 2 && substr($part, -1) ===  '.');
    }
}
