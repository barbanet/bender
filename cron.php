<?php
/**
 * Bender
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 *
 * @category   Core
 * @package    Core
 * @copyright  Copyright (c) 2013 Damián Culotta. (http://www.damianculotta.com.ar/)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

require_once __DIR__.'/Symfony/Component/ClassLoader/UniversalClassLoader.php';

use Symfony\Component\ClassLoader\UniversalClassLoader;

$loader = new UniversalClassLoader();
$loader->registerNamespace('Symfony', __DIR__.'/');
$loader->registerNamespace('Bender', __DIR__.'/');
$loader->registerNamespace('Plugin', __DIR__.'/');
$loader->registerNamespace('Action', __DIR__.'/');
$loader->register();

use Symfony\Component\Console as Console;

$application = new Console\Application('Bender', '0.0.3');
$application->add(new Bender\Cron('system:cron'));
$application->run();

?>