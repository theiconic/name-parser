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
    public function testMap($input, $expectation, $arguments = [])
    {
        $mapper = call_user_func_array([$this, 'getMapper'], $arguments);

        $this->assertEquals($expectation, $mapper->map($input));
    }

    abstract protected function getMapper();
}
