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

namespace Bender\Core;

use Bender\Core\Database as Database;
use \Exception;

class Logger {
    
    private $_database;
    
    public function __construct() {
        $this->_database = Database::getInstance();
    }
    
    public function save($message, $type = 'INF') {
        try {
            $this->_database->query("INSERT INTO logs(date,type,activity) VALUES ('" . date("Y-m-d H:i:s") . "', '" . $type . "', '" . $message . "');");
        } catch (Exception $e) {
            self::_failback($e->getMessage());
        }
    }
    
    private function _failback($message) {
        error_log($message, 0, 'error.log');
    }
    
}

?>
