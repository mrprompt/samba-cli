<?php
/**
 * @author Thiago Paes <mrprompt@gmail.com>
 * @license http://gplv3.fsf.org GPL-3.0+
 */
namespace Traits;

/**
 * @uses Guzzle\Http\Client
 */
use Guzzle\Http\Client;

/**
 * @author Thiago Paes <mrprompt@gmail.com>
 * @license http://gplv3.fsf.org GPL-3.0+
 */
trait WebClient
{
    /**
     * @var string
     */
	protected $base = 'http://www.sambaderaiz.net';
    
    /**
     * 
     * @return \Guzzle\Http\Client
     */
    public function getInstance()
    {
        $client = new Client($this->base);
        
        return $client;
    }
}