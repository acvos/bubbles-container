<?php

require_once('../vendor/autoload.php');
require_once('TestService.php');

// $configuration = [
//     'test.service' => [
//         'class' => 'Acvos\Bubbles\Example\TestService',
//         'type' => 'unique',
//         'dependencies' => [
//             'foo' => 100,
//             'bar' => 500
//         ]
//     ]
// ];

// $container = new \Acvos\Bubbles\Container();
// $container = $bubbles->spawn('test');
// var_dump($container);

// $service = $container->get('test.service');

$bubbles = new Acvos\Bubbles\ContainerManager();

$descriptor1 = $bubbles->getBuilder()
    ->clear()
    ->setClass('Acvos\Bubbles\Example\TestService')
    ->addDependency('constant', 'foo', 100)
    ->addDependency('constant', 'bar', 500)
    ->build();

$descriptor2 = $bubbles->getBuilder()
    ->clear()
    ->setClass('Acvos\Bubbles\Example\TestService')
    ->addDependency('reference', 'something', 'test.service')
    ->build();

$container = $bubbles->spawn();
$container->register('test.service', $descriptor1);
$container->register('test.another.service', $descriptor2);

$container->set('zzz', 200);
var_dump($container);

$service = $container->get('test.another.service');
var_dump($service);
$service = $container->get('test.service');
var_dump($service);