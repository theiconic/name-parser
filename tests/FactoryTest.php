<?php

namespace TheIconic\NameParser;

use PHPUnit\Framework\TestCase;

class FactoryTest extends TestCase
{

    public function testFactory()
    {
        $factory = new Factory();
        $name = $factory->createName();
        $this->assertInstanceOf(Name::class, $name);
    }
}
