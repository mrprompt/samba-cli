<?php
namespace Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class Samba extends Command
{
	const BASE = 'http://www.sambaderaiz.net';
	
	protected function configure()
	{
		$this
		->setName('samba:hello')
		->setDescription('Informe um álbum')
		->addArgument('album', InputArgument::REQUIRED, 'url do album')
		;
	}

	protected function execute(InputInterface $input, OutputInterface $output)
	{
		$albumUrl = $input->getArgument('album');
		
		$request = Request::create(self::BASE . '/' . $albumUrl . '/', 'GET');
		var_dump($request->headers->get('Content-Type'));exit;
		
		$output->writeln($text);
	}
}
