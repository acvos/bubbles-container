<?php

require_once('../vendor/autoload.php');
require_once('TestService.php');

$bubbles = new Acvos\Bubbles\ContainerManager();
$container = $bubbles->spawn();

$container
    ->register('zzz', 200)
    ->register('test.service', 'Acvos\Bubbles\Example\TestService')
        ->addDependency('foo', 100)
        ->addDependency('bar', '@zzz')
    ->register('test.another.service', 'Acvos\Bubbles\Example\TestService')
        ->addDependency('something', '@test.service')
        ->addDependency('something_more', '@zzz');

$service = $container->get('test.another.service');
var_dump($service);

$service = $container->get('test.service');
var_dump($service);

var_dump($container);