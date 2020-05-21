<?php

namespace TheIconic\NameParser\Definition;

use PHPUnit\Framework\TestCase;

class ConfigurableTest extends TestCase
{
    public function testGetSalutationsReturnsConfiguredSaluations(): void
    {
        $definition = new Configurable(
            [
                'mr' => 'Mr.',
                'Mrs' => 'Mrs.',
            ],
            [
                '1st' => '1st',
                '2nd' => '2nd',
                '3rd' => '3rd',
            ],
            [
                'de' => 'de',
                'del' => 'del',
            ]
        );

        $definition->addSalutations([
            'Mrs' => 'Mrs.',
            'MS' => 'Ms.',
        ]);

        $definition->addSuffixes([
            '3rd' => '3rd',
            '4th' => '4th',
            '5th' => '5th',
        ]);

        $definition->addLastnamePrefixes([
            'Del' => 'del',
            'du' => 'du',
        ]);

        $this->assertEquals([
            'mr' => 'Mr.',
            'mrs' => 'Mrs.',
            'ms' => 'Ms.',
        ], $definition->getSalutations());

        $this->assertEquals([
            '1st' => '1st',
            '2nd' => '2nd',
            '3rd' => '3rd',
            '4th' => '4th',
            '5th' => '5th',
        ], $definition->getSuffixes());

        $this->assertEquals([
            'de' => 'de',
            'del' => 'del',
            'du' => 'du',
        ], $definition->getLastnamePrefixes());
    }
}
