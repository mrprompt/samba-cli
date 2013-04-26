#!/usr/bin/env php
<?php
$autoload = require_once __DIR__ . '/vendor/autoload.php';
$autoload->add('Command', __DIR__ . '/app');

use Symfony\Component\Console\Application;
use Command\Samba;

$console = new Application;
$console->add(new Samba);
$console->run();
