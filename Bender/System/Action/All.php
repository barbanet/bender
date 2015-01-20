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

class All extends Core {

    public function __construct($name = null) {
        parent::__construct($name);
        $this->setDescription('Return list of Actions');
    }

    protected function execute(Console\Input\InputInterface $input, Console\Output\OutputInterface $output) {
        $_actions = $this->_getActions();
        if ($_actions) {
            $_rows = array();
            $_table = $this->getHelperSet()->get('table');
            $_table->setHeaders(array('Name', 'Class'));
            foreach ($_actions as $_action) {
                $_rows[] = array($_action->alias, $_action->class);
            }
            $_table->setRows($_rows);
            $_table->render($output);
        } else {
            $output->writeln('<error>No actions found.</error>');
        }
    }
    
    private function _getActions() {
        $_action = new Action;
        return $_action->all();
    }
    
}

?>
