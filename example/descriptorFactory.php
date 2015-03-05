<?php

require_once('../vendor/autoload.php');
require_once('TestService.php');

$constantFactory  = new Acvos\Bubbles\Descriptor\GenericDescriptorFactory('Acvos\Bubbles\Descriptor\Constant');
$defaultStrategy  = new Acvos\Bubbles\Descriptor\FallbackStrategy($constantFactory);

$serviceFactory   = new Acvos\Bubbles\Descriptor\GenericDescriptorFactory('Acvos\Bubbles\Descriptor\ServiceDescriptor');
$serviceStrategy  = new Acvos\Bubbles\Descriptor\KnownClassStrategy($serviceFactory);

$referenceFactory = new Acvos\Bubbles\Descriptor\GenericDescriptorFactory('Acvos\Bubbles\Descriptor\Reference');
$referenceStrategy  = new Acvos\Bubbles\Descriptor\RegexMatchStrategy($referenceFactory, '/^@.*/');

$strategies = [$referenceStrategy, $serviceStrategy];

$factory = new Acvos\Bubbles\Descriptor\PolymorphicDescriptorFactory($strategies, $defaultStrategy);

$constant = $factory->create(100);
var_dump($constant);

$constant = $factory->create('abcdefg');
var_dump($constant);

$reference = $factory->create('@some.service');
var_dump($reference);

$service = $factory->create('Acvos\Bubbles\Example\TestService');
var_dump($service);
