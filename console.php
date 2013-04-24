#!/usr/bin/env php
<?php
$autoload = require_once __DIR__ . '/vendor/autoload.php';
$autoload->add('mrprompt', __DIR__ . '/src');

use Symfony\Component\Console\Application,
	mrprompt\Command\SambaCommand;

$console = new Application;
$console->add(new SambaCommand);
$console->run();