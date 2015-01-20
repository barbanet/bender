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

namespace Action\Sample;

use Symfony\Component\Console as Console;
use Bender\Core as Core;


class Email extends Core {

    public function __construct($name = null) {
        parent::__construct($name);
        $this->setDescription('Test action used on development');
        $this->setHelp('A simple send mail action example.');
    }

    protected function execute(Console\Input\InputInterface $input, Console\Output\OutputInterface $output) {
        $output->writeln(sprintf('Message sent: %s', $this->_getMessage()));
        /**
         * CHANGE THE RECIPIENT ADDRESS TO RECIEVE THE EMAIL
         */
        $this->_getMailer()->send('recipient@example.com', 'Bender says', sprintf('%s', $this->_getMessage()));
    }

    private function _getMessage() {
        return 'Bite my shiny metal ass!';
    }

}

?>
