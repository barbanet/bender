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

require_once __DIR__.'/Symfony/Component/ClassLoader/ClassLoader.php';

use Symfony\Component\ClassLoader\ClassLoader;

$loader = new ClassLoader();
$loader->addPrefix('Symfony', __DIR__.'/');
$loader->addPrefix('Bender', __DIR__.'/');
$loader->addPrefix('Plugin', __DIR__.'/');
$loader->addPrefix('Action', __DIR__.'/');
$loader->register();

use Symfony\Component\Console as Console;

$application = new Console\Application('Bender', '0.0.4');
$application->add(new Bender\Cron('system:cron'));
$application->run();

?>