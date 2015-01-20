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

use Symfony\Component\Yaml\Parser as Yaml;
use \Exception;

class Configuration {
    
    protected static $_configuration;
    
    private static function _initialize() {
        try {
            $yaml = new Yaml();
            self::$_configuration = $yaml->parse(file_get_contents('config.yml'));
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public static function get() {
        self::_initialize();
        return self::$_configuration;
    }
    
}

?>
