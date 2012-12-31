#Marsvin


## What is it?

Have you ever write a crawler or parser? 

If yes, you must know that is always a trivial task, but we have always to think how structure our code to do such a thing...

So... to solve that Marvins was created, Marvins provide a simple API and structure to be followed to you create your parsers or crawler. The main focus is to facilitate the task of parser data from external resources, to extract data from websites or import data from XML, CSV files etc...


## How to use it?

**Create a composer.json**

```javascript
{
  "name" : "your/projectname",
  "require" : {
    "cobaia/marsvin" : "dev-master"
  },
  "minimum-stability" : "dev"
}
```

**Run the command:**

```bash
composer.phar install
```

**Create your console command:**


**File:** console.php

```php
<?php
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Helper\HelperSet;

$console = new Application('Your Project', '1.0');
$console->addCommands(
    array(
            new Marsvin\Command\GenerateProviderCommand(),
            new Marsvin\Command\RequestProviderCommand(),
    )
);

//You are able to pass as much helper set you want, like Doctrine, Monolog, etc...
//$console->setHelperSet($helperSet);
ConsoleRunner::addCommands($console);

$console->run();

```
