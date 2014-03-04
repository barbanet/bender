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

namespace Bender\System\Database\Install;

class Mysql {
    
    public function getTables() {
        $_tables = array();
        $_tables[] = "CREATE TABLE IF NOT EXISTS options (
                        option_id INT NOT NULL AUTO_INCREMENT,
                        code VARCHAR(255) NOT NULL,
                        value VARCHAR(255) NULL,
                        PRIMARY KEY (option_id),
                        UNIQUE INDEX UQ_CORE_CODE (code ASC)
                      ) ENGINE = InnoDB;";
        $_tables[] = "CREATE TABLE IF NOT EXISTS logs (
                        log_id INT NOT NULL AUTO_INCREMENT,
                        date DATETIME NULL,
                        type CHAR(3) NULL,
                        activity VARCHAR(500) NULL,
                        PRIMARY KEY (log_id)
                      ) ENGINE = InnoDB;";
        $_tables[] = "CREATE TABLE IF NOT EXISTS actions (
                        action_id INT NOT NULL AUTO_INCREMENT,
                        class VARCHAR(200) NOT NULL,
                        alias VARCHAR(200) NOT NULL,
                        description VARCHAR(255) NULL,
                        is_cron SMALLINT UNSIGNED NOT NULL DEFAULT 1,
                        is_shell SMALLINT UNSIGNED NOT NULL DEFAULT 0,
                        available INT(1) NULL DEFAULT 1,
                        PRIMARY KEY (action_id),
                        UNIQUE INDEX UQ_ACTIONS_MODULE_NAME (alias ASC)
                      ) ENGINE = InnoDB;";
        $_tables[] = "CREATE TABLE IF NOT EXISTS tasks (
                        task_id INT NOT NULL AUTO_INCREMENT,
                        action_id INT NOT NULL,
                        name VARCHAR(255) NULL,
                        available INT(1) NULL DEFAULT 0,
                        year CHAR(4) NOT NULL DEFAULT '*',
                        month CHAR(2) NOT NULL DEFAULT '*',
                        day CHAR(2) NOT NULL DEFAULT '*',
                        hour CHAR(2) NOT NULL DEFAULT '*',
                        minute CHAR(2) NOT NULL DEFAULT '*',
                        dow CHAR(1) NOT NULL DEFAULT '*',
                        PRIMARY KEY (task_id),
                        INDEX FK_TASKS_ACTION (action_id ASC),
                        CONSTRAINT FK_TASKS_ACTION FOREIGN KEY (action_id)
                          REFERENCES actions (action_id)
                          ON DELETE NO ACTION ON UPDATE NO ACTION
                      ) ENGINE = InnoDB;";
        /*
        $_tables[] = 'CREATE TABLE IF NOT EXISTS actions_logs (
                        action_log_id INT NOT NULL AUTO_INCREMENT,
                        date DATETIME NULL,
                        action_id INT NULL,
                        type CHAR(3) NULL,
                        activity VARCHAR(500) NULL,
                        processed INT(1) NULL DEFAULT 0,
                        PRIMARY KEY (action_log_id),
                        INDEX FK_ACTIONS_LOGS_ACTION (action_id ASC),
                        CONSTRAINT FK_ACTIONS_LOGS_ACTION FOREIGN KEY (action_id)
                          REFERENCES actions (action_id)
                          ON DELETE NO ACTION ON UPDATE NO ACTION
                      ) ENGINE = InnoDB;';
        $_tables[] = 'CREATE TABLE IF NOT EXISTS reports (
                        report_id INT NOT NULL AUTO_INCREMENT,
                        date DATE NULL,
                        PRIMARY KEY (report_id)
                      ) ENGINE = InnoDB;';
        $_tables[] = 'CREATE TABLE IF NOT EXISTS reports_details (
                        repors_detail_id INT NOT NULL AUTO_INCREMENT,
                        report INT NOT NULL,
                        action INT NOT NULL,
                        detail VARCHAR(500) NULL,
                        PRIMARY KEY (repors_detail_id),
                        INDEX FK_REPORTS_DETAILS_ACTION (action ASC),
                        INDEX FK_REPORTS_DETAILS_REPORT (report ASC),
                        CONSTRAINT FK_REPORTS_DETAILS_ACTION FOREIGN KEY (action)
                          REFERENCES actions (action_id)
                          ON DELETE NO ACTION ON UPDATE NO ACTION,
                        CONSTRAINT FK_REPORTS_DETAILS_REPORT FOREIGN KEY (report)
                          REFERENCES reports (report_id)
                          ON DELETE NO ACTION ON UPDATE NO ACTION
                      ) ENGINE = InnoDB;';
        $_tables[] = 'CREATE TABLE IF NOT EXISTS actions_parameters (
                        action_parameter_id INT NOT NULL AUTO_INCREMENT,
                        action_id INT NULL,
                        parameter VARCHAR(255) NULL,
                        value TEXT NULL,
                        PRIMARY KEY (action_parameter_id),
                        INDEX FK_ACTIONS_PARAMETERS_ACTION (action_id ASC),
                        CONSTRAINT FK_ACTIONS_PARAMENETRS_ACTION FOREIGN KEY (action_id)
                          REFERENCES actions (action_id)
                          ON DELETE NO ACTION ON UPDATE NO ACTION
                      ) ENGINE = InnoDB;';
        */
        return $_tables;
    }
}

?>
