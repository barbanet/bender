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
use Bender\System\Database\Upgrade\Mysql as Mysql;

class Upgrade extends Core {
    
    private $_database;
    
    public function __construct($name = null) {
        parent::__construct($name);
        $this->setDescription("Upgrade Bender's tables.");
        $this->_database = Database::getInstance();
    }

    protected function execute(Console\Input\InputInterface $input, Console\Output\OutputInterface $output) {
        
        $_formatter = $this->getHelperSet()->get('formatter');
        $_question = $this->getHelperSet()->get('question');

        if ($this->_getDbVersion() != $this->_getAppVersion()) {
            $_message = $_formatter->formatSection(
                'Bender says',
                'This action will update your database. Do you want to continue? [y/N]'
            );
            $_ask = new ConfirmationQuestion($_message, false);
            if (!$_question->ask(
                $input,
                $output,
                $_ask
            )) {
                return;
            }

            $_upgrades = $this->_getUpgrades();

            $_progress = new ProgressBar($output, count($_upgrades));
            foreach ($_upgrades as $_upgrade) {
                $this->_database->query($_upgrade);
                $_progress->advance();
            }
            $_progress->finish();

            $_message = $_formatter->formatSection(
                'Bender says',
                sprintf('%s upgrades were made. I feel like a new Bender.', count($_upgrades))
            );
            $output->writeln($_message);

            $this->_updateVersion();
        } else {
            $_message = $_formatter->formatSection(
                'Bender says',
                'I am completely upgraded. No actions needed.'
            );
            $output->writeln($_message);
        }
        
        
        
    }
    
    private function _getUpgrades() {
        $_configuration = Configuration::get();
        switch($_configuration['database']['type']) {
            case 'mysql':
                return Mysql::getUpgrades($this->_getDbVersion(), $this->_getAppVersion());
            break;
        }
        return false;
    }
    
    private function _getDbVersion() {
        $_option = new Option;
        return $_option->load('bender/version')->value;
    }
    
    private function _getAppVersion() {
        return $this->getApplication()->getVersion();
    }
    
    private function _updateVersion() {
        $_option = new Option;
        $_option->update('bender/version', $this->getApplication()->getVersion());
    }
    
}

?>
