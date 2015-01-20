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
use \Exception;

class Details extends Core {

    public function __construct($name = null) {
        parent::__construct($name);
        $this->setDescription('Get values of a given task');
        $this->addArgument('name', Console\Input\InputArgument::REQUIRED, 'Task name');
    }

    protected function execute(Console\Input\InputInterface $input, Console\Output\OutputInterface $output) {
        $name = $input->getArgument('name');
        $_task = $this->_getTask($name);
        if ($_task) {
            $_table = $this->getHelperSet()->get('table');
            $_table->setHeaders(array('Name','Available', 'Year', 'Month', 'Day', 'Hour', 'Minute', 'Dow'));
            $_rows = array(array($_task->name, $_task->available, $_task->year, $_task->month,
                                    $_task->day, $_task->hour, $_task->minute, $_task->dow));
            $_table->setRows($_rows);
            $_table->render($output);
        } else {
            $output->writeln(sprintf('Task <error>%s</error> not exists.', $name));
        }
    }

    private function _getTask($name) {
        $_task = new Task;
        return $_task->load($name);
    }

}

?>
