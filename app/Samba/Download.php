<?php
/**
 * Download an album
 * 
 * @author Thiago Paes <mrprompt@gmail.com>
 * @license http://gplv3.fsf.org GPL-3.0+
 */
namespace Samba;

/**
 * @uses Symfony\Component\Console\Command\Command
 */
use Symfony\Component\Console\Command\Command;

/**
 * @uses Symfony\Component\Console\Input\InputArgument
 */
use Symfony\Component\Console\Input\InputArgument;

/**
 * @uses Symfony\Component\Console\Input\InputInterface
 */
use Symfony\Component\Console\Input\InputInterface;

/**
 * @uses Symfony\Component\Console\Output\OutputInterface
 */
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Download an album
 * 
 * @author Thiago Paes <mrprompt@gmail.com>
 * @license http://gplv3.fsf.org GPL-3.0+
 */
class Download extends Command
{
    /**
     * @const string
     */
	const BASE = 'http://www.sambaderaiz.net';
	
    /**
     * Construtor
     * 
     * @return void
     */
	protected function configure()
	{
		$this->setName('samba:download')
             ->setDescription('Informe um álbum')
             ->addArgument('album', InputArgument::REQUIRED, 'url do album');
	}

    /**
     * Execute the command
     * 
     * @param \Symfony\Component\Console\Input\InputInterface $input
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     * @return void
     */
	protected function execute(InputInterface $input, OutputInterface $output)
	{
		$albumUrl = $input->getArgument('album');
        $text     = 'boo';
        
		$output->writeln(sprintf('<info>%s</info>', $text));
	}
}
