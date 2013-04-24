#!/usr/bin/env php
<?php
$autoload = require_once __DIR__ . '/vendor/autoload.php';
$autoload->add('mrprompt', __DIR__ . '/src');

use Symfony\Component\Console\Application,
	mrprompt\Command\Samba;

$console = new Application;
$console->add(new Samba);
$console->run();