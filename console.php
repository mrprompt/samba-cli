<?php
/**
 * Run app
 * 
 * @author Thiago Paes <mrprompt@gmail.com>
 * @license http://gplv3.fsf.org GPL-3.0+
 */
// constantes de configuração
define('DS', DIRECTORY_SEPARATOR);
defined('APPLICATION_PATH') || define('APPLICATION_PATH', realpath(__DIR__));

$autoload = require_once __DIR__ . '/vendor/autoload.php';
$console  = new Symfony\Component\Console\Application;
$console->add(new Samba\Download);
$console->add(new Samba\Busca);
$console->add(new Samba\Recentes);
$console->run();
