<?php

require_once('../vendor/autoload.php');
require_once('TestService.php');

$bubbles = new Acvos\Bubbles\ContainerManager();
$container = $bubbles->spawn();

$container
    ->register('zzz', 200)
    ->register('test.service', 'Acvos\Bubbles\Example\TestService')
        ->addDependency('Setter injection example', 'bob')
        ->addDependency('@zzz', 'bar')
        ->addDependency(100, 'foo')
    ->register('test.another.service', 'Acvos\Bubbles\Example\TestService')
        ->addDependency('@test.service')
        ->addDependency('zzz');

var_dump($container);

$service = $container->get('test.another.service');
var_dump($service);

$service = $container->get('test.service');
var_dump($service);
