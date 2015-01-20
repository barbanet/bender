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

class Update extends Core {

    public function __construct($name = null) {
        parent::__construct($name);
        $this->setDescription('Manage task status');
        $this->setHelp('Check or change values of a given task.');
        $this->addArgument('name', Console\Input\InputArgument::REQUIRED, 'Task name');
        $this->addArgument('property', Console\Input\InputArgument::OPTIONAL, 'Property to be changed', 'true');
        $this->addArgument('value', Console\Input\InputArgument::OPTIONAL, 'New value for the property called', 'true');
    }

    protected function execute(Console\Input\InputInterface $input, Console\Output\OutputInterface $output) {
        $name = $input->getArgument('name');
        $property = $input->getArgument('property');
        $value = $input->getArgument('value');

        $this->_updateTask($name, $property, $value);

        $output->writeln(sprintf('<info>%s</info> was updated.', $name));
    }

    private function _updateTask($name, $property, $value) {
        $_task = new Task;
        $_task->update($name, $property, $value);
    }

}

?>
