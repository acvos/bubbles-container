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

$builder = new Acvos\Bubbles\ServiceDescriptorBuilder([
    'constant'  => 'Acvos\Bubbles\Constant',
    'service'   => 'Acvos\Bubbles\ServiceDescriptor',
    'reference' => 'Acvos\Bubbles\Reference'
]);

$descriptor1 = $builder
    ->startNew('Acvos\Bubbles\Example\TestService')
    ->addDependency('constant', 'foo', 100)
    ->addDependency('constant', 'bar', 500)
    ->build();

$descriptor2 = $builder
    ->startNew('Acvos\Bubbles\Example\TestService')
    ->addDependency('reference', 'something', 'test.service')
    ->build();

$container = new Acvos\Bubbles\Container();
$container->describe('test.service', $descriptor1);
$container->describe('test.another.service', $descriptor2);

$service = $container->get('test.another.service');
var_dump($service);
$service = $container->get('test.service');
var_dump($service);