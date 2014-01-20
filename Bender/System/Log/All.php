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

namespace Bender\System\Log;

use Symfony\Component\Console as Console;
use Bender\Model\Log as Log;
use Bender\Core as Core;

class All extends Core {

    public function __construct($name = null) {
        parent::__construct($name);
        $this->setDescription('Return app logs');
    }

    protected function execute(Console\Input\InputInterface $input, Console\Output\OutputInterface $output) {
        $_logs = $this->_getLogs();
        if ($_logs) {
            $_rows = array();
            $_table = $this->getHelperSet()->get('table');
            $_table->setHeaders(array('Date','Type', 'Activity'));
            foreach ($_logs as $_log) {
                $_rows[] = array($_log->date, $_log->type, $_log->activity);
            }
            $_table->setRows($_rows);
            $_table->render($output);
        } else {
            $output->writeln('<error>No logs found.</error>');
        }
    }

    private function _getLogs() {
        $_log = new Log;
        return $_log->all();
    }

}

?>
