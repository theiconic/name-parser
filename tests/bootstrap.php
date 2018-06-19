<?php

use phpmock\phpunit\PHPMock;

PHPMock::defineFunctionMock('TheIconic\NameParser\Part', 'function_exists');

require dirname(__DIR__) . '/vendor/autoload.php';
