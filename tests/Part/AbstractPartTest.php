<?php

namespace TheIconic\NameParser\Part;

use PHPUnit\Framework\TestCase;

class AbstractPartTest extends TestCase
{
    /**
     * make sure the placeholder normalize() method returns the original value
     */
    public function testNormalize()
    {
        $part = $this->getMockForAbstractClass(AbstractPart::class, ['abc']);
        $this->assertEquals('abc', $part->normalize());
    }

    /**
     * make sure we unwrap any parts during setValue() calls
     */
    public function testSetValueUnwraps()
    {
        $part = $this->getMockForAbstractClass(AbstractPart::class, ['abc']);
        $this->assertEquals('abc', $part->getValue());

        $part = $this->getMockForAbstractClass(AbstractPart::class, [$part]);
        $this->assertEquals('abc', $part->getValue());
    }
}
