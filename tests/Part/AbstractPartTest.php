<?php

namespace TheIconic\NameParser\Part;

use PHPUnit\Framework\TestCase;

class AbstractPartTest extends TestCase
{
    /**
     * make sure the placeholder normalize() method returns the original value
     */
    public function testNormalize(): void
    {
        $part = $this->createPart('abc');
        $this->assertEquals('abc', $part->normalize());
    }

    /**
     * make sure we unwrap any parts during setValue() calls
     */
    public function testSetValueUnwraps(): void
    {
        $part = $this->createPart('abc');
        $this->assertEquals('abc', $part->getValue());

        $part = $this->createPart($part);
        $this->assertEquals('abc', $part->getValue());
    }

    /**
     * concrete AbstractPart without any overrides
     * (replaces getMockForAbstractClass(), removed in PHPUnit 12)
     */
    private function createPart(string|AbstractPart $value): AbstractPart
    {
        return new class($value) extends AbstractPart {
        };
    }
}
