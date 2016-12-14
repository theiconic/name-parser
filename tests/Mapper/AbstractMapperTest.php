<?php

namespace TheIconic\NameParser\Mapper;

use PHPUnit_Framework_TestCase;

abstract class AbstractMapperTest extends PHPUnit_Framework_TestCase
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