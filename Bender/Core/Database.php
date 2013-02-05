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

use Bender\Core\Configuration;
use \PDO;
use \PDOException;
use \Exception;

class Database {
    
    private $_connection;
    private $_database;
    private $_type;
    private static $instance;
    
    public function __construct($type) {
        $this->_type = $type;
    }
    
    public function __destruct() {}
    
    
    public static function getInstance() {
        if (!isset(self::$instance)) {
            $configuration = Configuration::get();
            self::$instance = new Database($configuration['database']['type']);
            self::$instance->connect($configuration['database']['user'],
                                     $configuration['database']['password'],
                                     $configuration['database']['database'],
                                     $configuration['database']['host'],
                                     $configuration['database']['port']);
        }
        return self::$instance;
    }
    
    
    public function connect($user, $password, $database, $host = "localhost", $port = "3306") {
        switch ($this->_type) {
            case "mysql":
                $this->_connection = new PDO($this->_type . ':host=' . $host . ';dbname=' . $database . ';port=' . $port, $user, $password);
                $this->_connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $this->_connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
                $this->_connection->setAttribute(PDO::ATTR_PERSISTENT, true);
            break;
        }
        unset($user);
        unset($password);
        unset($database);
        unset($host);
        unset($port);
    }
    
    public function query($strsql) {
        switch ($this->_type) {
            case "mysql":
            case "postgresql":
                try {
                    $_result = $this->_connection->query($strsql);
                    if ($_result->rowCount() > 0) {
                        return $_result;
                    }
                    return false;
                } catch (PDOException $e) {
                    throw new Exception($e->getMessage());
                } catch (Exception $e) {
                    throw new Exception($e->getMessage());
                }
            break;
        }
    }
    
    /**
     * Deprecated
     * @deprecated 0.0.2 - 02/02/2013
     */
    public function getRows() {}
    
    /**
     * Deprecated
     * @deprecated 0.0.2 - 02/02/2013
     */
    public function freeResult() {}
    
    /**
     * Deprecated
     * @deprecated 0.0.2 - 02/02/2013
     */
    public function closeConnection() {}
    
    protected function _validateType($type) {
        $_types = array('mysql');
        if (!in_array($type, $_types)) {
            throw new Exception($type . ' is not a supported database type.');
        }
        return true;
    }
    
    public function getType() {
        switch ($this->_type) {
            case 'mysql':
                return 'Mysql';
            break;
            case 'postgresql':
                return 'PostgreSql';
            break;
        }
    }
    
    public function getVersion() {
        switch ($this->_type) {
            case 'mysql':
                $values = self::query('SELECT version() as version;');
                foreach ($values as $rs) {
                    return $rs->version;
                }
            break;
            case 'postgresql':
                //pg_close($this->connection);
            break;
        }
    }
    
}

?>
