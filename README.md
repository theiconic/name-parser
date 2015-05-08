# TheIconic Name Parser

## Usage

```
<?php

$parser = new TheIconic\NameParser\Parser();
$parser->init();
$name = $parser->parse($name);
echo $name->getSalutation();
echo $name->getFirstname();
echo $name->getLastname();
```
