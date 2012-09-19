<?php
namespace Marsvin\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Marsvin\ImportFactory;

class RequestProviderCommand extends Command
{

    public function configure()
    {
        $this->setName('marsvin:request:provider')
            ->setDescription('Request one specific Provider')
            ->setDefinition(
                array(
                    new InputArgument(
                        'provider',
                        InputArgument::REQUIRED,
                        'The provider name to be requested'
                    )
                )
            )->setHelp('This command will request the given provider');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $loader = new Loader();
        $loader->load($input->getArgument('provider'));
    }

}