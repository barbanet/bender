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

namespace Bender;

use Symfony\Component\Console as Console;
use Symfony\Component\Yaml\Parser as Yaml;
use Bender\Core\Logger as Logger;
use Bender\Core\Email as Email;

class Core extends Console\Command\Command {
    
    protected $_logger;
    protected $_mailer;

    public function __construct($name = null) {
        parent::__construct($name);
        $this->_validateInstaller();
    }
        
    private function _validateInstaller() {
        $yaml = new Yaml();
        if (!$yaml->parse(file_get_contents('config.yml'))) {
            //Throw exception message
        }
    }
    
    protected function _getLogger() {
        if (!$this->_logger) {
            $this->_logger = new Logger;
        }
        return $this->_logger;
    }
    
    protected function _getMailer() {
        if (!$this->_mailer) {
            $this->_mailer = new Email;
        }
        return $this->_mailer;
    }
    
    

}

?>
