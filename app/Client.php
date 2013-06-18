<?php
use Guzzle\Http\Client;

trait Client
{
    /**
     * @var string
     */
	private $base = 'http://www.sambaderaiz.net';
    
    public function getInstance()
    {
        $client   = new Client($this->base);
        
        return $client;
    }
}