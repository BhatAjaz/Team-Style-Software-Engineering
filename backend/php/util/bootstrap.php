<?php
/**
 * @author Beng
 */
require_once __DIR__ . '/../../../vendor/autoload.php';
require_once __DIR__ . '/Container.php';

$config = require __DIR__ . '/config.php';

use backend\php\util\Container;

$container = Container::getInstance();

foreach ($config['interfaces'] as $interface => $concrete) $container->bind($interface, $concrete);
