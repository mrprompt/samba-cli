<?php
/**
 * Exemplo de uso da integração com o Twillio
*
* @author Thiago Paes <mrprompt@gmail.com>
* @copyright (c) 2013, Thiago Paes
*/

/**
 *
 * @see autoload
 *
 */
require_once __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

// constantes de configuraÃ§Ã£o
defined ( 'APPLICATION_PATH' ) || define ( 'APPLICATION_PATH', realpath ( __DIR__ . DIRECTORY_SEPARATOR . '..' ) );
defined ( 'XML_CONFIG' ) || define ( 'XML_CONFIG', APPLICATION_PATH . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'application.xml' );

// bibliotecas utilizadas.
use Twilio\Twilio;

// Read configuration file
$config = new SimpleXMLElement ( file_get_contents ( XML_CONFIG ) );

try {
	// Getting credentials from Twilio to use as SMS Sender
	$credentials = $config->xpath ( "//services/service[@name='Twilio']" );
	$credentials = array_shift ( $credentials );
	
	$twilio = new Twilio ( $credentials->key, $credentials->secret );
	$message = $twilio->account->sms_messages->create ( 
			'+15714140095', 	// From a valid Twilio number
			'+554891858982', 	// Text this number
			'saldo de e-mails insuficiente' 
	);
} catch ( Exception $e ) {
	die ( $e->getMessage () . PHP_EOL );
}

