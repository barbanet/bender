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

namespace Bender\System\Database;

use Symfony\Component\Console as Console;
use Bender\Core\Database as Database;
use Bender\Core as Core;

class Engine extends Core {
    
    private $_database;
    
    public function __construct($name = null) {
        parent::__construct($name);
        $this->setDescription('Display database engine name.');
        $this->_database = Database::getInstance();
    }

    protected function execute(Console\Input\InputInterface $input, Console\Output\OutputInterface $output) {
        if ($this->_database) {
            $output->writeln(sprintf('Database Engine: %s', $this->_database->getType()));
        }
    }
}

?>
