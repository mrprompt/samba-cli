<?php
/**
 * Search album
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
 * @uses Symfony\Component\Console\Input\InputInterface
 */
use Symfony\Component\Console\Input\InputInterface;

/**
 * @uses Symfony\Component\Console\Output\OutputInterface
 */
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Search album
 * 
 * @author Thiago Paes <mrprompt@gmail.com>
 * @license http://gplv3.fsf.org GPL-3.0+
 */
class Recentes extends Command
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
		$this->setName('samba:recentes')
             ->setDescription('Lista os últimos álbuns publicados no site.');
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
		$text     = 'boo';
        
		$output->writeln(sprintf('<info>%s</info>', $text));
	}
}
