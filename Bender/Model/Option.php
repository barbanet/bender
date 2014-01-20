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

class Option {

    private $_database;
    
    public function __construct() {
        $this->_database = Database::getInstance();
    }

    //TODO: add variable validation
    public function load($code) {
        $_options = $this->_database->query("SELECT option_id, code, value FROM options WHERE code = '" . $code . "';");
        if ($_options) {
            foreach ($_options as $_option) {
                return $_option;
            }
        }
        return false;
    }
    
    //TODO: add variable validation
    public function add($code, $value) {
        $this->_database->query("INSERT INTO options(code, value) VALUES ('" . $code . "', '" . $value . "');");
    }
    
    //TODO: add variable validation
    public function update($code, $value) {
        $this->_database->query("UPDATE options SET value = '" . $value . "' WHERE code = '" . $code . "';");
    }
    
    //TODO: add variable validation
    public function delete($code) {
        $this->_database->query("DELETE FROM options WHERE code = '" . $code . "';");
    }
    
}

?>
