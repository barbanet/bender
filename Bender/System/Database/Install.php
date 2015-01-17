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
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Bender\Core\Configuration;
use Bender\Core\Database as Database;
use Bender\Model\Option as Option;
use Bender\Core as Core;
use Bender\System\Database\Install\Mysql as Mysql;

class Install extends Core {
    
    private $_database;
    
    public function __construct($name = null) {
        parent::__construct($name);
        $this->setDescription("Creates Bender's tables.");
        $this->_database = Database::getInstance();
    }

    protected function execute(Console\Input\InputInterface $input, Console\Output\OutputInterface $output) {
        
        $_formatter = $this->getHelperSet()->get('formatter');
        $_question = $this->getHelperSet()->get('question');
        $_message = $_formatter->formatSection(
            'Bender says',
            'This action will create the tables into your database. Do you want to continue? [y/N]'
        );
        $_ask = new ConfirmationQuestion($_message, false);
        if (!$_question->ask(
                $input,
                $output,
                $_ask
            )) {
            return;
        }

        $_tables = $this->_getTables();
        
        $_progress = new ProgressBar($output, count($_tables));
        foreach ($_tables as $_table) {
            $this->_database->query($_table);
            $_progress->advance();
        }
        $_progress->finish();
        
        $_message = $_formatter->formatSection(
            'Bender says',
            sprintf('%s tables created', count($_tables))
        );
        $output->writeln($_message);
        
        $this->_addVersion();
        $this->_addOptions();
        
    }
    
    private function _getTables() {
        $_configuration = Configuration::get();
        switch($_configuration['database']['type']) {
            case 'mysql':
                return Mysql::getTables();
            break;
        }
    }
    
    private function _addVersion() {
        $_option = new Option;
        $_option->add('bender/version', $this->getApplication()->getVersion());
    }
    
    private function _addOptions() {
        $_option = new Option;
        $_option->add('bender/custom_actions', '1');
    }
    
}

?>
