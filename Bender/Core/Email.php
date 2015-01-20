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

namespace Bender\Core;

use Bender\Core\Configuration;
use \Exception;

class Email {
    
    private $_email;
    
    public function __construct() {
        $this->_configure();
    }
    
    public function send($recipient, $subject, $body) {
    	$list = explode(',', $recipient);
        $this->_email->to($list);
        $this->_email->subject($subject);
        $this->_email->message($body);
        $this->_email->set_alt_message(strip_tags($body));
        if($this->_email->send()) {
            //Log email sent
        } else {
            throw new Exception($this->_email->print_debugger());
        }
    }
    
    private function _configure() {
        $configuration = Configuration::get();
        if (is_array($configuration['email'])) {
            $this->_email = new \Plugin\Bender\Email;
            $config = array();
            $config['protocol'] = $configuration['email']['protocol'];
            $config['validate'] = $configuration['email']['validate'];
            $config['smtp_host'] = $configuration['email']['smtp_host'];
            $config['smtp_port'] = $configuration['email']['smtp_port'];
            $config['smtp_user'] = $configuration['email']['smtp_user'];
            $config['smtp_pass'] = $configuration['email']['smtp_pass'];
            $config['mailtype'] = $configuration['email']['mailtype'];
            $config['newline'] = $configuration['email']['newline'];
            $this->_email->initialize($config);
            $this->_email->from($configuration['email']['address'], $configuration['email']['name']);
        } else {
            throw new Exception('No email configuration was found.');
        }
    }
    
    
}

?>
