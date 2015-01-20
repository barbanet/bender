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

class Delete extends Core {

    public function __construct($name = null) {
        parent::__construct($name);
        $this->setDescription('Delete a task');
        $this->setHelp('Deletes an existing task from the application.');
        $this->addArgument('name', Console\Input\InputArgument::REQUIRED, 'Task name');
    }

    protected function execute(Console\Input\InputInterface $input, Console\Output\OutputInterface $output) {
        $name = $input->getArgument('name');
        $this->_deleteTask($name);
        $output->writeln(sprintf('Task <comment>%s</comment> deleted', $name));
    }

    private function _deleteTask($name) {
        $_task = new Task;
        $_task->delete($name);
    }

}

?>
