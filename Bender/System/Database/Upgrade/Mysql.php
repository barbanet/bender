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

namespace Bender\System\Database\Upgrade;

class Mysql {
    
    protected $_upgrades = array();
    
    public function getUpgrades($db, $app) {
        //TODO: Change this, it's too sloppy.
        $_db = (integer) str_replace('.', '', $db);
        $_app = (integer) str_replace('.', '', $app);
        while ($_db <= $_app) {
            self::_getUpgrade($_db);
            $_db++;
        }
        return $this->_upgrades;
    }
    
    private function _getUpgrade($version) {
        switch ($version) {
            case '4':
                $this->_upgrades[] = "ALTER TABLE actions ADD is_cron smallint
                      unsigned NOT NULL default 1 AFTER description;";
                $this->_upgrades[] = "ALTER TABLE actions ADD is_shell smallint
                      unsigned NOT NULL default 0 AFTER is_cron;";
            break;
            default:
                return false;
        }
    }

}

?>
