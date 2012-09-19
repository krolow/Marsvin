<?php
namespace Marsvin\Command;

use Cilex\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Marsvin\ImportFactory;

class ImportCommand extends Command
{

    public function configure()
    {
        $this->setName('Marsvin:import')
            ->setDescription('Import')
            ->addArgument(
                'provider', 
                InputArgument::REQUIRED, 
                'Name of class to be imported'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $provider = ImportFactory::load(
            $input->getArgument('provider'),
            $this->getContainer()
        );
        $provider->import();
    }

}