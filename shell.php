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

$functions = array (
                array('name' => 'Bender\System\Action\Add', 'alias' => 'action:add'),
                array('name' => 'Bender\System\Action\All', 'alias' => 'action:all'),
                array('name' => 'Bender\System\Action\Delete', 'alias' => 'action:delete'),
                array('name' => 'Bender\System\Database\Engine', 'alias' => 'database:engine'),
                array('name' => 'Bender\System\Database\Install', 'alias' => 'database:install'),
                array('name' => 'Bender\System\Database\Version', 'alias' => 'database:version'),
                array('name' => 'Bender\System\Task\Add', 'alias' => 'task:add'),
                array('name' => 'Bender\System\Task\All', 'alias' => 'task:all'),
                array('name' => 'Bender\System\Task\Delete', 'alias' => 'task:delete'),
                array('name' => 'Bender\System\Task\Details', 'alias' => 'task:details'),
                array('name' => 'Bender\System\Task\Update', 'alias' => 'task:update'),
            );

$application = new Console\Application('Bender', '0.0.3');
foreach ($functions as $function) {
    $application->add(new $function['name']($function['alias']));
}

$shell = new Console\Shell($application);
$shell->run();

?>