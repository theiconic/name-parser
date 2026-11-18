<?php

namespace TheIconic\NameParser\Mapper;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

abstract class AbstractMapperTestCase extends TestCase
{
    /**
     * @param array $input
     * @param array $expectation
     * @param array $arguments arguments passed to getMapper()
     */
    #[DataProvider('provider')]
    public function testMap(array $input, array $expectation, array $arguments = []): void
    {
        $mapper = $this->getMapper(...$arguments);

        $this->assertEquals($expectation, $mapper->map($input));
    }

    abstract public static function provider(): array;

    abstract protected function getMapper();
}
