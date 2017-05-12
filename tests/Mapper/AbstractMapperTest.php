<?php

namespace TheIconic\NameParser\Mapper;

use PHPUnit\Framework\TestCase;

abstract class AbstractMapperTest extends TestCase
{
    /**
     * @dataProvider provider
     *
     * @param $input
     * @param $expectation
     */
    public function testMap($input, $expectation)
    {
        $classname = substr(get_class($this), 0, -4);
        $mapper = new $classname();

        $this->assertEquals($expectation, $mapper->map($input));
    }
}
