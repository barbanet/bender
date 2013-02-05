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

namespace Bender\System\Action;

use Symfony\Component\Console as Console;
use Bender\Model\Action as Action;
use Bender\Core as Core;
use \Exception;

class Add extends Core
{
    public function __construct($name = null)
    {
        parent::__construct($name);
        $this->setDescription('Add an action');
        $this->setHelp('Adds a new action to the application.');
        $this->addArgument('alias', Console\Input\InputArgument::REQUIRED, 'Suggested alias');
        $this->addArgument('class', Console\Input\InputArgument::REQUIRED, 'Class path');
    }

    protected function execute(Console\Input\InputInterface $input, Console\Output\OutputInterface $output)
    {
        $class = $input->getArgument('class');
        $alias = $input->getArgument('alias');
        try {
            $this->_createAction($class, $alias);
            $output->writeln(sprintf('Action <comment>%s</comment> added', $alias));
        } catch (Exception $e) {
            $output->writeln(sprintf('<error>%s</error>', $e->getMessage()));
        }
    }
    
    private function _createAction($class, $alias)
    {
        if (file_exists(__DIR__ . '/../../../Action/'. $class . '.php')) {
            $class = 'Action/' . $class;
            $_action = new Action;
            $_action->add($class, $alias);
        } else {
            throw new Exception('Action class does not exists');
        }
    }
    
}

?>
