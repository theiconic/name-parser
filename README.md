# TheIconic Name Parser

## Usage

```
<?php

$parser = new TheIconic\NameParser\Parser();

$name = $parser->parse($name);

echo $name->getSalutation();
echo $name->getFirstname();
echo $name->getLastname();
echo $name->getMiddlename();
echo $name->getNickname();
echo $name->getInitials();
echo $name->getSuffix();
```
