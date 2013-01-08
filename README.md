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
require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

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
$console->run();


```

After create the console you are already enable to run the command: php app/console.php

You will check that we have two commands to use:

```bash
marsvin
  marsvin:generate:provider   Generate Provider code structure
  marsvin:request:provider    Request one specific Provider
```

**Marsvin use the following nomenclature:**

- **Provider:** It's the name of the operation that you will be doing, an example of provider would be: Facebook, Github, Google, etc..
- **Requester:** It's the layer responsible to make the requests of one provider, for example for Facebook would be one HTTP Request, for Github maybe it can be one GIT operation, for another provider it can be one FTP access etc...
- **Parser:** Once you the request operation has been done, the parser layers comes this layer will take care of the data, so if you want to setup some entities of doctrine, or do you want to create some array of datas, etc... Or you want to normalize some how the data, this is the layer that you will be using to do such a task.
- **Persister:** Once you have parsed your data, it goes to the Persister layer, here is where you will do forever you want with the data, in doctrine for example you will be able to persist and flush the data into database, or if you want to persists in file system, persists sending one email, or whatever the Persister layer will be handling that to you.


### Creating our first provider

To create our provider, marvins has one command that create the folder structure to you:

```bash
php app/console marsvin:generate:provider MyProject\\Github ./src/
```

You will check that Marsvin will generate the following folder tree to you:

```bash
.
└── MyProject
    └── Github
        ├── GithubParser.php
        ├── GithubPersister.php
        ├── GithubProvider.php
        └── GithubRequester.php
```

Now it's time to setup the adapters, Marsvin using the adapter pattern to define each one of the layers, so for example if you want to make HTTP Request you can setup one HttpAdapter to use in the requester layer.

By default Marvins comes with few adapters:

- **Requester:** DefaultAdapter.php BuzzAdapter.php
- **Parser:** DomAdapter.php
- **Persister:** DefaultAdapter.php DoctrineAdapter.php

So let's setup our provider:

```php
<?php
namespace MyProject\Github;

use Marsvin\Provider\AbstractProvider;
use Marsvin\Provider\ProviderInterface;
use Marsvin\Requester\Adapter\BuzzAdapter;
use Marsvin\Parser\Adapter\DomAdapter;
use Marsvin\Persister\Adapter\DefaultAdapter;

class GithubProvider extends AbstractProvider implements ProviderInterface
{

    public function getRequesterAdapter()
    {
        return new BuzzAdapter();
    }

    public function getParserAdapter()
    {
        return new DomAdapter();
    }

    public function getPersisterAdapter()
    {
        return new DefaultAdapter();
    }

}
```

The Requester:

```php
<?php
namespace MyProject\Github;

use Marsvin\Requester\AbstractRequester;
use Marsvin\Requester\RequesterInterface;
use Marsvin\Response;

class GithubRequester extends AbstractRequester implements RequesterInterface
{

    const GITHUB_URL = 'https://github.com/%s?tab=repositories';

    public function request()
    {
        $adapter = $this->getAdapter();

        $profiles = array(
            'krolow',
            'gquental',
            'moacirosa',
            'fabpot',
        );

        $self = $this;

        foreach ($profiles as $profile) {
            $this->process(function () use ($self, $adapter, $profile) {
                $self->done(
                    new Response(
                        $adapter->request(
                            sprintf(
                                GithubRequester::GITHUB_URL,
                                $profile
                            )
                        )
                    )
                );
            });
        }
    }

}
```

The Parser:

```php
<?php
namespace MyProject\Github;

use Marsvin\Parser\AbstractParser;
use Marsvin\Parser\ParserInterface;
use Marsvin\Response;
use Marsvin\ResponseInterface;
use DOMXPath;
use DOMDocument;

class GithubParser extends AbstractParser implements ParserInterface
{

    public function parse(ResponseInterface $response)
    {
        $adapter = $this->getAdapter();

        $dom = $adapter->parse($response->get());

        $xpath = new DOMXPath($dom);
        
        $nodes = $xpath->query('//span[@itemprop="name"]');
        $author = $nodes->item(0)->nodeValue;

        $nodes = $xpath->query('//li[contains(@class, "public")]');

        $projects = array();

        foreach ($nodes as $node) {
            array_push(
                $projects,
                $this->parseProject($node, $author)
            );
        }


        $this->done(new Response($projects));
    }

    protected function parseProject($node, $author)
    {
        $doc = new DOMDocument();
        $doc->appendChild($doc->importNode($node, true));

        $name = $doc->getElementsByTagName('h3');
        $url = $doc->getElementsByTagName('a');

        $project = array(
            'name' => trim($name->item(0)->nodeValue),
            'url' => 'http://github.com/' . $url->item(2)->getAttribute('href'),
            'author' => $author
        );
        
        return $project;
    }

}
```

The Persister:

```php
<?php
namespace MyProject\Github;

use Marsvin\Persister\AbstractPersister;
use Marsvin\Persister\PersisterInterface;
use Marsvin\Response;
use Marsvin\ResponseInterface;

class GithubPersister extends AbstractPersister implements PersisterInterface
{

    public function persists(ResponseInterface $response)
    {
        $adapter = $this->getAdapter();
        $adapter->persist($response->get());
        file_put_contents('/tmp/marsvin.log', var_export($adapter->flush(), true), FILE_APPEND);
    }

}
```

To run the command do the follow:

```bash
php app/console.php marsvin:request:provider MyProject\\Github\\GithubProvider
```

You can check what is happening here:

```bash
tail -f /tmp/marsvin.log
```
