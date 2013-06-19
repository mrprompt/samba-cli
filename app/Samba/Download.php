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
 * @uses Guzzle\Http\Client
 */
use Guzzle\Http\Client;

/**
 * Download an album
 *
 * @author Thiago Paes <mrprompt@gmail.com>
 * @license http://gplv3.fsf.org GPL-3.0+
 */
class Download extends Command
{
    /**
     * @uses Traits\WebClient
     */
    use \Traits\WebClient;
    
    /**
     * @const integer
     */
    const OGG = 0;
    
    /**
     * @const integer
     */
    const MP3 = 1;
    
    /**
     * @const string
     */
    const QUERY = '//section[@class="post_content"]/section/ol/li';
    
    /**
     *
     * @var Guzzle\Http\Client
     */
    protected $client;

    /**
     * Construtor
     *
     * @return void
     */
	protected function configure()
	{
		$this->setName('samba:download')
             ->setDescription('Efetua o download de um álbum')
             ->addArgument('album', InputArgument::REQUIRED, 'url do album')
             ->addArgument('destino', InputArgument::OPTIONAL, 'pasta de destino')
             ->addArgument('tipo', InputArgument::OPTIONAL, '(mp3 | ogg)', 'ogg');
	}
    
    /**
     * 
     * @param string $tipo
     * @return integer
     * @throws \InvalidArgumentException
     */
    private function getTipo($tipo = 'ogg') 
    {
        switch (strtolower($tipo)) {
            case 'ogg':
                return self::OGG;
                break;
            
            case 'mp3':
                return self::MP3;
                break;
            
            default:
                throw new \InvalidArgumentException('Tipo inválido.');
        }
    }
    
    /**
     * 
     * @param string $album
     * @return string
     */
    private function getAlbum($album)
    {
        try { 
            $request  = $this->client->get('/' . $album . '/');
            $response = $request->send();
            
            return $response->getBody();
        } catch (\Guzzle\Http\Exception\ClientErrorResponseException $e) {
            throw new \InvalidArgumentException('Álbum não encontrado.', 404);
        }
    }
    
    /**
     * 
     * @param string $album
     * @return \DOMNodeList 
     * @throws \OutOfRangeException
     */
    private function getMusicas($album)
    {
		$doc = new \DOMDocument;
        $doc->preserveWhiteSpace = false;
		$doc->loadHTML($album);
        
		$xpath   = new \DOMXPath($doc);
        $total   = $xpath->evaluate(sprintf('count(%s)', self::QUERY));
        
        if (0 === $total) {
            throw new \OutOfRangeException('Músicas não encontradas.', 404);
        }

		$musicas = $xpath->query(self::QUERY);
        
        return $musicas;
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
		$album   = $input->getArgument('album');
        $destino = $input->getArgument('destino');
        $tipo    = $this->getTipo($input->getArgument('tipo'));

        if (strlen($destino) !== 0 && !is_dir($destino)) {
            mkdir($destino, 0755, true);
        }
        
        // desabilito a checagem de erros, pq o html externo, ja sabe...
        libxml_use_internal_errors(true);
        
        $this->client = new Client($this->base);

        $response = $this->getAlbum($album);
        $musicas  = $this->getMusicas($response);
        
        foreach ($musicas as $arquivo) {
            $uri = $arquivo->getElementsByTagName('source')
                           ->item($tipo)
                           ->getAttribute('src');

            $paths = explode('/', $uri);
            $track = substr(array_pop($paths), 0, -4);
            
            $titulo = $arquivo->getElementsByTagName('b')
                              ->item(0)
                              ->nodeValue;
            
            $arquivo = $track . '-' . strtolower(
                str_replace(
                    ' ', 
                    '-', 
                    filter_var(
                        $titulo, 
                        FILTER_SANITIZE_SPECIAL_CHARS
                    )
                ) . '.' . $input->getArgument('tipo')
            );
            
            $output->writeln('<info>Baixando: '. $titulo . ' para ' . $arquivo . '</info>');
            
            $request  = $this->client->get($uri);
            $response = $request->send();
            
            file_put_contents(
                $destino . DS . $arquivo, 
                $response->getBody(),
                LOCK_EX
            );
        }

        $output->writeln('<comment>Baixado!</comment>');
	}
}
