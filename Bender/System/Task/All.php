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

namespace Bender\System\Task;

use Symfony\Component\Console as Console;
use Bender\Model\Task as Task;
use Bender\Core as Core;

class All extends Core {

    public function __construct($name = null) {
        parent::__construct($name);
        $this->setDescription('Return list of Tasks');
    }

    protected function execute(Console\Input\InputInterface $input, Console\Output\OutputInterface $output) {
        $_tasks = $this->_getTasks();
        if ($_tasks) {
            $_rows = array();
            $_table = $this->getHelperSet()->get('table');
            $_table->setHeaders(array('Name','Available', 'Year', 'Month', 'Day', 'Hour', 'Minute', 'Dow'));
            foreach ($_tasks as $_task) {
                $_rows[] = array($_task->name, $_task->available, $_task->year, $_task->month,
                                        $_task->day, $_task->hour, $_task->minute, $_task->dow);
            }
            $_table->setRows($_rows);
            $_table->render($output);
        } else {
            $output->writeln('<error>No tasks found.</error>');
        }
    }

    private function _getTasks() {
        $_task = new Task;
        return $_task->all();
    }

}

?>
