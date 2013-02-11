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
            $output->writeln(sprintf('Task: <info>%s</info>', $_task->name));
            $output->writeln(sprintf('<comment>available</comment>: %s', $_task->available));
            $output->writeln(sprintf('<comment>year</comment>: %s', $_task->year));
            $output->writeln(sprintf('<comment>month</comment>: %s', $_task->month));
            $output->writeln(sprintf('<comment>day</comment>: %s', $_task->day));
            $output->writeln(sprintf('<comment>hour</comment>: %s', $_task->hour));
            $output->writeln(sprintf('<comment>minute</comment>: %s', $_task->minute));
            $output->writeln(sprintf('<comment>dow</comment>: %s', $_task->dow));
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
