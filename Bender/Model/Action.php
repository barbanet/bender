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

namespace Bender\Model;
use Bender\Core\Database as Database;
use Bender\Model\Option as Option;

class Action {

    private $_database;
    
    public function __construct() {
        $this->_database = Database::getInstance();
    }

    //TODO: add variable validation
    public function load($alias) {
        $_actions = $this->_database->query("SELECT action_id, class, alias, description, available FROM actions WHERE alias = '" . $alias . "';");
        if ($_actions) {
            foreach ($_actions as $_action) {
                return $_action;
            }
        }
        return false;
    }
    
    //TODO: replace function is for mysql. Also the slash issue is a little bit sloppy.
    public function add($class, $alias, $is_cron, $is_shell) {
        $this->_database->query("INSERT INTO actions(class, alias, is_cron, is_shell) VALUES
                                (REPLACE('" . $class . "','/','\\\'), '" . $alias . "',
                                '" . $is_cron . "', '" . $is_shell . "');");
    }
    
    //TODO: is update a valid method?
    public function update() {}
    
    //TODO: add variable validation
    public function delete($alias) {
        $this->_database->query("DELETE FROM actions WHERE alias = '" . $alias . "';");
    }
    
    public function all() {
        $_actions = $this->_database->query('SELECT action_id, class, alias, description, is_cron, is_shell, available FROM actions;');
        return $_actions;
    }
    
    public function shell() {
        try {
            $_option = new Option;
            if ($_option->load('bender/custom_actions') && $_option->load('bender/custom_actions')->value == 1) {
                $_actions = $this->_database->query('SELECT class, alias FROM actions WHERE is_shell = 1;');
                return $_actions;
            }
        } catch (\Exception $e) {
            return false;
        }
        return false;
    }
    
}

?>
