<?php
namespace Marsvin\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;

class GenerateProviderCommand extends Command
{

    public function configure()
    {
        $this->setName('marsvin:generate:provider')
            ->setDescription('Request one specific Provider')
            ->setDefinition(
                array(
                    new InputArgument(
                        'namespace',
                        InputArgument::REQUIRED
                    ),
                    new InputArgument(
                        'dir',
                        InputArgument::REQUIRED
                    ),
                )
            )->setHelp(
<<<EOT
The command <info>marsvin:generate:provider</info> will create one provider for you.

One provider consist of one Provider, one Requester, one Parser and one Persister class.

You must inform the namespace of your provider and the dir:

<info>php app/console marsvin:generate:provider --namespace=Cobaia/Crawler --dir=src</info>
EOT
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $provider = new ProviderGenerator(
            $input->getArgument('namespace'),
            $input->getArgument('dir')
        );

        $requester = new RequesterGenerator(
            $input->getArgument('namespace'),
            $input->getArgument('dir')
        );

        $parser = new ParserGenerator(
            $input->getArgument('namespace'),
            $input->getArgument('dir')
        );

        $persister = new PersisterGenerator(
            $input->getArgument('namespace'),
            $input->getArgument('dir')
        );
    }

}
