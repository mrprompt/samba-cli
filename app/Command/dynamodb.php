<?php
/**
 * Exemplos de uso do servi�o DynamoDB da Amazon
 *
 * @author Thiago Paes <mrprompt@gmail.com>
 * @copyright (c) 2013, Thiago Paes
 */

/**
 *
 * @see autoload
 */
require_once __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

// constantes de configuração
defined ( 'APPLICATION_PATH' ) || define ( 'APPLICATION_PATH', realpath ( __DIR__ . DIRECTORY_SEPARATOR . '..' ) );
defined ( 'XML_CONFIG' ) || define ( 'XML_CONFIG', APPLICATION_PATH . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'application.xml' );

// bibliotecas utilizadas.
use Aws\DynamoDb\DynamoDbClient;
use Aws\Common\Enum\Region;

try {
	// Read configuration file
	$config = new SimpleXMLElement ( file_get_contents ( XML_CONFIG ) );
	
	try {
		// Getting Amazon Web Service Credentials
		$credentials = $config->xpath ( "//services/service[@name='Amazon']" );
		$credentials = array_shift ( $credentials );
		
		// Instantiate the DynamoDB client with your AWS credentials
		$client = DynamoDbClient::factory ( array (
				'key' => $credentials->key,
				'secret' => $credentials->secret,
				'region' => Region::SAO_PAULO 
		) );
		
		// Create a "posts" table
		$result = $client->createTable ( array (
				'TableName' => 'posts',
				'KeySchema' => array (
						'HashKeyElement' => array (
								'AttributeName' => 'slug',
								'AttributeType' => 'S' 
						) 
				),
				'ProvisionedThroughput' => array (
						'ReadCapacityUnits' => 10,
						'WriteCapacityUnits' => 5 
				) 
		) );
		
		// Wait until the table is created and active
		$client->waitUntil ( 'TableExists', array (
				'TableName' => 'posts' 
		) );
		echo "The {$table} table has been created.\n";
		
		// List tables
		$tables = $client->listTables ();
		print_r ( $tables );
		
		// list 'usuarios' table content
		$usuarios = $client->scan ( array (
				'TableName' => 'usuario' 
		) );
		
		foreach ( $usuarios as $usuario ) {
			var_dump ( $usuario );
		}
	} catch ( Exception $e ) {
		echo $e->getMessage (), PHP_EOL;
	}
} catch ( Exception $e ) {
	die ( $e->getMessage () . PHP_EOL );
}

