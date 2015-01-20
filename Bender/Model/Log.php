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

namespace Bender\Model;
use Bender\Core\Database as Database;
use \Exception;

class Log {
    
    private $_database;
    
    public function __construct() {
        $this->_database = Database::getInstance();
    }
    
    public function all() {
        $_logs = $this->_database->query('SELECT date, type, activity FROM logs ORDER BY date asc;');
        return $_logs;
    }
    
    public function delete($date) {
        $this->_database->query("DELETE FROM logs WHERE date < '" . $date . "';");
    }
    
}

?>
