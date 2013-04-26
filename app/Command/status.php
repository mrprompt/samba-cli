<?php
/**
 * Um daemon que n�o faz nada.
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
use Uecode\Daemon;

try {
	// Initialize daemon
	$daemon = new Daemon ( array (
			"appName" => "systemstatus",
			"appDescription" => "checagem de status de serviços",
			"appDir" => APPLICATION_PATH,
			"appExecutable" => basename ( __FILE__ ),
			"appPidLocation" => implode ( DIRECTORY_SEPARATOR, array (
					APPLICATION_PATH,
					"log",
					"systemstatus",
					"status.pid" 
			) ),
			"logVerbosity" => 3,
			"logPhpErrors" => true,
			"logTrimAppDir" => true,
			"logLocation" => implode ( DIRECTORY_SEPARATOR, array (
					APPLICATION_PATH,
					"log",
					"status.log" 
			) ),
			"authorName" => "Thiago Paes",
			"authorEmail" => "mrprompt@gmail.com",
			"sysMemoryLimit" => "128M",
			"appRunAsUID" => getmyuid (),
			"appRunAsGID" => getmygid (),
			"appUser" => get_current_user (),
			"appGroup" => "thiago" 
	) );
	$daemon->start ();
	
	while ( true ) {
		
		sleep ( 10 );
	}
} catch ( Exception $e ) {
	die ( $e->getMessage () . PHP_EOL );
}
