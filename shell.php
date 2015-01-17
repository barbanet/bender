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
use Bender\Model\Action as Action;

$functions = array (
                array('name' => 'Bender\System\Action\Add', 'alias' => 'action:add'),
                array('name' => 'Bender\System\Action\All', 'alias' => 'action:all'),
                array('name' => 'Bender\System\Action\Delete', 'alias' => 'action:delete'),
                array('name' => 'Bender\System\Database\Engine', 'alias' => 'database:engine'),
                array('name' => 'Bender\System\Database\Install', 'alias' => 'database:install'),
                array('name' => 'Bender\System\Database\Upgrade', 'alias' => 'database:upgrade'),
                array('name' => 'Bender\System\Database\Version', 'alias' => 'database:version'),
                array('name' => 'Bender\System\Log\All', 'alias' => 'log:all'),
                array('name' => 'Bender\System\Log\Clean', 'alias' => 'log:clean'),
                array('name' => 'Bender\System\Task\Add', 'alias' => 'task:add'),
                array('name' => 'Bender\System\Task\All', 'alias' => 'task:all'),
                array('name' => 'Bender\System\Task\Delete', 'alias' => 'task:delete'),
                array('name' => 'Bender\System\Task\Details', 'alias' => 'task:details'),
                array('name' => 'Bender\System\Task\Update', 'alias' => 'task:update'),
            );

$_actions = new Action();
if ($_actions->shell()) {
    foreach ($_actions->shell() as $_action) {
        $functions[] = array('name' => $_action->class, 'alias' => 'custom:' . $_action->alias);
    }
}

$application = new Console\Application('Bender', '0.0.4');
foreach ($functions as $function) {
    $application->add(new $function['name']($function['alias']));
}

$shell = new Console\Shell($application);
$shell->run();

?>