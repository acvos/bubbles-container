# Bubbles DI
[![Build Status](https://travis-ci.org/acvos/bubbles-container.svg?branch=master)](https://travis-ci.org/acvos/bubbles-container)

Minimalistic, extensible, lazy dependency injection container.

### Why?
It's always good to follow best practices even when you don't use a full-stack framework. If you are writing a small, focused back-end service or script, but still want the full power of DI, Bubbles would help turning your plain old PHP classes into injectable services.

### How?
Installation
```bash
composer require acvos/bubbles
```
Usage
```php
// Instantiating Bubbles facade
$bubbles = new Acvos\Bubbles\ContainerManager();

// Obtaining new DI container
$container = $bubbles->spawn();

// Configuring dependencies
$container
    ->register('zzz', 200)
    ->register('test.service', 'Acvos\Bubbles\Example\TestService')
        ->addDependency('Setter injection example', 'bob')
        ->addDependency('@zzz', 'bar')
        ->addDependency(100, 'foo')
    ->register('test.another.service', 'Acvos\Bubbles\Example\TestService')
        ->addDependency('@test.service')
        ->addDependency('zzz');

// Getting our class instance as a DI service
$service = $container->get('test.another.service');
```
