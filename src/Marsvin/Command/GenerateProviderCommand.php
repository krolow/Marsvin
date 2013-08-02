<?php
/*
 * This file is part of the Marsvin package.
 *
 * (c) Vinícius Krolow <krolow@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Marsvin\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Marsvin\Generator\Generator;
use Marsvin\Generator\ProviderGenerator;
use Marsvin\Generator\RequesterGenerator;
use Marsvin\Generator\ParserGenerator;
use Marsvin\Generator\PersisterGenerator;

/**
 * Command to Generate template files for a given Provider
 * 
 * @author Vinícius Krolow <krolow@gmail.com>
 */
class GenerateProviderCommand extends Command
{
    /**
     * Configure command
     * 
     * @return void
     */
    public function configure()
    {
        $this->setName('marsvin:generate:provider')
            ->setDescription('Generate Provider code structure')
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

One provider consist of:
    - Provider Class
    - Requester Class
    - Parser Class
    - Persister class.

You must inform the namespace of your provider and the dir:

<info>php app/console marsvin:generate:provider --namespace=Cobaia\\Crawler --dir=src</info>
EOT
            );
    }

    /**
     * Execute the command to generate the provider template
     * 
     * @param InputInterface $input
     * @param OutputInterface $output
     * 
     * @return void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $generator = new Generator($input->getArgument('namespace'), $input->getArgument('dir'));
        $generator->generate(new ProviderGenerator());
        $generator->generate(new RequesterGenerator());
        $generator->generate(new ParserGenerator());
        $generator->generate(new PersisterGenerator());

        $output->writeln(sprintf('Provider %s created!', $input->getArgument('namespace')));
    }

}
