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
use Bender\Model\Action as Action;
use \Exception;

class Task {
    
    private $_database;
    
    public function __construct() {
        $this->_database = Database::getInstance();
    }
    
    //TODO: add variable validation
    public function load($name) {
        $_tasks = $this->_database->query("SELECT task_id, action_id, name, available, year, month, day, hour, minute, dow FROM tasks WHERE name = '" . $name . "';");
        if ($_tasks) {
            foreach ($_tasks as $_task) {
                return $_task;
            }
        }
        return false;
    }
    
    //TODO: add variable validation
    public function add($alias, $name) {
        $_action = new Action;
        $_data = $_action->load($alias);
        if ($_data) {
            $this->_database->query("INSERT INTO tasks(action_id, name) VALUES ('" . $_data->action_id . "', '" . $name . "');");
        } else {
            return false;
        }
    }
    
    //TODO: add variable validation
    public function update($name, $property, $value) {
        $_properties = array('available', 'year', 'month', 'day', 'hour', 'minute', 'dow');
        if (in_array($property, $_properties)) {
            $_task = self::load($name);
            if ($_task) {
                $this->_database->query("UPDATE tasks SET " . $property . " = '" . $value . "' WHERE task_id = " . $_task->task_id . ";");
            }
        }
    }
    
    //TODO: add variable validation
    public function delete($name) {
        $this->_database->query("DELETE FROM tasks WHERE name = '" . $name . "';");
    }
    
    public function all() {
        $_tasks = $this->_database->query('SELECT task_id, action_id, name, available, year, month, day, hour, minute, dow FROM tasks;');
        return $_tasks;
    }
    
    public function available($year, $month, $day, $hour, $minute, $dow) {
        $_tasks = $this->_database->query("SELECT class, alias FROM tasks, actions WHERE
                                            tasks.action_id = actions.action_id AND tasks.available = 1
                                            AND (tasks.year = '" . $year . "' OR tasks.year = '*')
                                            AND (tasks.month = '" . $month . "' OR tasks.month = '*')
                                            AND (tasks.day = '" . $day . "' OR tasks.day = '*')
                                            AND (tasks.hour = '" . $hour . "' OR tasks.hour = '*')
                                            AND (tasks.minute = '" . $minute . "' OR tasks.minute = '*')
                                            AND (tasks.dow = '" . $dow . "' OR tasks.dow = '*')
                                            AND actions.is_cron = 1;");
        return $_tasks;
    }
    
}

?>
