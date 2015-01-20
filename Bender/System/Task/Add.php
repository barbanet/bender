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

class Add extends Core {

    public function __construct($name = null) {
        parent::__construct($name);
        $this->setDescription('Add a task');
        $this->setHelp('Adds a new task to the application.');
        $this->addArgument('action', Console\Input\InputArgument::REQUIRED, 'Action alias');
        $this->addArgument('name', Console\Input\InputArgument::REQUIRED, 'Task name');
    }

    protected function execute(Console\Input\InputInterface $input, Console\Output\OutputInterface $output) {
        $action = $input->getArgument('action');
        $name = $input->getArgument('name');
        try {
            $this->_createTask($action, $name);
            $output->writeln(sprintf('Task <comment>%s</comment> created', $name));
            $output->writeln('<info>You will need to activate the action and set the schedule.</info>');
        } catch (\Exception $e) {
            $output->writeln(sprintf('<error>%s</error>', $e->getMessage()));
        }
    }

    private function _createTask($action, $name) {
        $_task = new Task;
        $_task->add($action, $name);
    }

}

?>
