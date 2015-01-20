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

namespace Bender\System\Action;

use Symfony\Component\Console as Console;
use Bender\Model\Action as Action;
use Bender\Core as Core;

class Delete extends Core {
    
    public function __construct($name = null) {
        parent::__construct($name);
        $this->setDescription('Delete an action');
        $this->setHelp('Deletes an existing action from the application.');
        $this->addArgument('alias', Console\Input\InputArgument::REQUIRED, 'Action alias');
    }

    protected function execute(Console\Input\InputInterface $input, Console\Output\OutputInterface $output) {
        $alias = $input->getArgument('alias');
        $this->_deleteAction($alias);
        $output->writeln(sprintf('Action <comment>%s</comment> deleted', $alias));
    }
    
    private function _deleteAction($alias) {
        $_action = new Action;
        $_action->delete($alias);
    }
    
}

?>
