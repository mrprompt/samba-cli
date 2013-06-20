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
 * @uses Guzzle\Http\Client
 */
use Guzzle\Http\Client;

/**
 * Search album
 * 
 * @author Thiago Paes <mrprompt@gmail.com>
 * @license http://gplv3.fsf.org GPL-3.0+
 */
class Busca extends Command
{
    /**
     * @uses Traits\WebClient
     */
    use \Traits\WebClient;
    
    /**
     * Construtor
     * 
     * @return void
     */
	protected function configure()
	{
		$this->setName('samba:busca')
             ->setDescription('Busca por um álbum')
             ->addArgument('palavra-chave', InputArgument::REQUIRED, 'Palavra-chave a buscar');
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
        $palavra = urlencode($input->getArgument('palavra-chave'));
        
        $url    = 'https://www.googleapis.com';
        $params = '/customsearch/v1element?'
             . 'key=AIzaSyCVAXiUzRYsML1Pv6RwSG1gunmMikTzQqY&'
             . 'rsz=filtered_cse&num=10&'
             . 'hl=en&'
             . 'source=gcsc&'
             . 'gss=.com&sig=5530b85faafd53e1d394092d8d1eb26a&'
             . 'cx=015489500250162257153:prhblavs8na&'
             . 'q=' . $palavra . '&googlehost=www.google.com&'
             . 'oq=' . $palavra . '&'
             . 'nocache=1371703833885&'
             . '&alt=json';
        
        try {
            $client   = new Client($url);
            $request  = $client->get($params);
            $response = $request->send();
            $results  = json_decode($response->getBody());
            
            foreach ($results->results as $result) {
                $msg = sprintf(
                    '<info>%s</info> - <comment>%s</comment>',
                    $result->titleNoFormatting,
                    substr(str_replace($this->base, '', $result->unescapedUrl), 1, -1)
                );
                
                $output->writeln($msg);
            }
        } catch (\Guzzle\Http\Exception\ClientErrorResponseException $e) {
            $output->writeln("<error>{$e->getMessage()}</error>");
        }
	}
}
