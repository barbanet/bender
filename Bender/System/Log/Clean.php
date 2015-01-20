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

namespace Bender\System\Log;

use Symfony\Component\Console as Console;
use Bender\Model\Log as Log;
use Bender\Core as Core;
use \Exception;

class Clean extends Core {

    public function __construct($name = null) {
        parent::__construct($name);
        $this->setDescription('Clean app logs');
        $this->setHelp('Deletes application logs.');
        $this->addOption('q', null, Console\Input\InputOption::VALUE_OPTIONAL, 'Quantity of t to be maintained.', 1);
        $this->addOption('t', null, Console\Input\InputOption::VALUE_OPTIONAL, 'Type of meassure. Possible values: days, hours, minutes.', 'days');
    }

    protected function execute(Console\Input\InputInterface $input, Console\Output\OutputInterface $output) {
        $_quantity = $input->getOption('q');
        $_type = $input->getOption('t');
        $this->_cleanLogs($_quantity, $_type);
        $output->writeln('Logs deleted.');
    }

    private function _cleanLogs($quantity, $type) {
        $_date = $this->_calculateDate($quantity, $type);
        $_log = new Log;
        $_log->delete($_date);
    }
    
    private function _calculateDate($quantity, $type) {
        $_types = array('days', 'hours', 'minutes');
        if (!in_array($type, $_types)) {
            $type = 'days';
        }
        return date('Y-m-d H:i:s', strtotime('-' . $quantity . ' ' . $type));
    }

}

?>
