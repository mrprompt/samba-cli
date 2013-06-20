<?php
if (file_exists('samba.phar')) {
    unlink('samba.phar');
}

$app = new Phar("samba.phar", 0, "samba.phar");
$app->startBuffering();
$app->buildFromDirectory(__DIR__);
$app->setStub("#!/usr/bin/env php -q\n" . $app->createDefaultStub("console.php"));
$app->stopBuffering();
