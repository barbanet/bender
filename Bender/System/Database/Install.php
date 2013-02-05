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
use Bender\Core\Configuration;
use Bender\Core\Database as Database;
use Bender\Core as Core;
use Bender\System\Database\Install\Mysql as Mysql;

class Install extends Core
{
    
    private $_database;
    
    public function __construct($name = null) {
        parent::__construct($name);
        $this->setDescription("Creates Bender's tables.");
        $this->_database = Database::getInstance();
    }

    protected function execute(Console\Input\InputInterface $input, Console\Output\OutputInterface $output) {
        $_tables = $this->_getTables();
        foreach ($_tables as $_table) {
            $this->_database->query($_table);
        }
        $output->writeln(sprintf('<info>%s tables created</info>', count($_tables)));
    }
    
    private function _getTables() {
        $_configuration = Configuration::get();
        switch($_configuration['database']['type']) {
            case 'mysql':
                return Mysql::getTables();
            break;
        }
    }
}

?>
