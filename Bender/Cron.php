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
 * @copyright  Copyright (c) 2015 Damián Culotta. (http://www.damianculotta.com.ar/)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

namespace Bender;

use Symfony\Component\Console as Console;
use Bender\Model\Task as Task;
use Bender\Core as Core;

class Cron extends Core {

    public function __construct($name = null) {
        parent::__construct($name);
        $this->setDescription('Core execution.');
    }

    protected function execute(Console\Input\InputInterface $input, Console\Output\OutputInterface $output) {
        $_tasks = $this->_getTasks();
        if ($_tasks) {
            $functions = array();
            foreach ($_tasks as $_task) {
                $functions[] = array('name' => $_task->class, 'alias' => $_task->alias);
            }
            $_tasks = array();
            foreach ($functions as $function) {
                $this->getApplication()->add(new $function['name']($function['alias']));
                $_tasks[] = $function['alias'];
            }
            foreach ($_tasks as $_task) {
                $command = $this->getApplication()->find($_task);
                $this->_getLogger()->save($command->getName() . ' starts.');
                $command->run($input, $output);
                $this->_getLogger()->save($command->getName() . ' ends.');
            }
        }
    }

    private function _getTasks() {
        $_year = date('Y');
        $_month = date('n');
        $_day = date('j');
        $_hour = date('G');
        $_minute = (int) date('i');
        $_dow = date('w');
        $_tasks = new Task();
        return $_tasks->available($_year, $_month, $_day, $_hour, $_minute, $_dow);
    }

}

?>
