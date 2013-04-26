#!/usr/bin/env php
<?php
// constantes de configuração
define('DS', DIRECTORY_SEPARATOR);
defined('APPLICATION_PATH') || define('APPLICATION_PATH', realpath(__DIR__));
defined('XML_CONFIG') || define('XML_CONFIG', APPLICATION_PATH . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'application.xml');

$autoload = require_once __DIR__ . '/vendor/autoload.php';
$autoload->add('Command', __DIR__ . '/app');

use Symfony\Component\Console\Application;
use Command\Samba;
use Command\Mail;

$console = new Application;
$console->add(new Samba);
$console->add(new Mail);
$console->run();
