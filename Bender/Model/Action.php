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

class Action {

    private $_database;
    
    public function __construct() {
        $this->_database = Database::getInstance();
    }

    //TODO: add variable validation
    public function load($alias) {
        $_action = $this->_database->query("SELECT action_id, class, alias, description, available FROM actions WHERE alias = '" . $alias . "';");
        if ($_action->rowCount() == 1) {
            return $_action;
        }
        return false;
    }
    
    //TODO: replace function is for mysql. Also the slash issue is a little bit sloppy.
    public function add($class, $alias) {
        $this->_database->query("INSERT INTO actions(class, alias) VALUES (REPLACE('" . $class . "','/','\\\'), '" . $alias . "');");
    }
    
    //TODO: is update a valid method?
    public function update() {}
    
    //TODO: add variable validation
    public function delete($alias) {
        $this->_database->query("DELETE FROM actions WHERE alias = '" . $alias . "';");
    }
    
    public function all() {
        $_actions = $this->_database->query('SELECT action_id, class, alias, description, available FROM actions;');
        return $_actions;
    }
    
}

?>
