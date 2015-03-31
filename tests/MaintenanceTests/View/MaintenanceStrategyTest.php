<?php
/**
 * Juliangut Zend Framework Maintenance Module Module (https://github.com/juliangut/zf-maintenance)
 *
 * @link https://github.com/juliangut/zf-maintenance for the canonical source repository
 * @license https://github.com/juliangut/zf-maintenance/blob/master/LICENSE
 */

namespace Jgut\Zf\MaintenanceTests\View;

use PHPUnit_Framework_TestCase;
use Jgut\Zf\Maintenance\View\MaintenanceStrategy;
use Jgut\Zf\Maintenance\Provider\ProviderInterface;

/**
 * @covers Jgut\Zf\Maintenance\View\MaintenanceStrategy
 */
class MaintenanceStrategyTest extends PHPUnit_Framework_TestCase
{
    protected $strategy;

    public function setUp()
    {
        $this->strategy = new maintenanceStrategy('zf-maintenance/maintenance');
    }

    /**
     * @covers Jgut\Zf\Maintenance\View\MaintenanceStrategy::setTemplate
     * @covers Jgut\Zf\Maintenance\View\MaintenanceStrategy::getTemplate
     */
    public function testTemplate()
    {
        $this->assertEquals('zf-maintenance/maintenance', $this->strategy->getTemplate());

        $this->strategy->setTemplate('myTemplate');
        $this->assertEquals('myTemplate', $this->strategy->getTemplate());
    }

    /**
     * @covers Jgut\Zf\Maintenance\View\MaintenanceStrategy::attach
     * @covers Jgut\Zf\Maintenance\View\MaintenanceStrategy::detach
     */
    public function testAttachDetach()
    {
        $eventManager = $this->getMock('Zend\\EventManager\\EventManagerInterface');
        $callbackMock = $this->getMock('Zend\\Stdlib\\CallbackHandler', array(), array(), '', false);

        $eventManager
            ->expects($this->once())
            ->method('attach')
            ->with()
            ->will($this->returnValue($callbackMock));
        $this->strategy->attach($eventManager);

        $eventManager
            ->expects($this->once())
            ->method('detach')
            ->with($callbackMock)
            ->will($this->returnValue(true));
        $this->strategy->detach($eventManager);
    }

    /**
     * @covers Jgut\Zf\Maintenance\View\MaintenanceStrategy::onDispatchError
     */
    public function testAlreadyResponse()
    {
        $result = $this->getMock('Zend\\Http\\Response', array(), array(), '', false);
        $event  = $this->getMock('Zend\\Mvc\\MvcEvent', array(), array(), '', false);
        $event->expects($this->once())->method('getResult')->will($this->returnValue($result));
        $event->expects($this->once())->method('getResponse')->will($this->returnValue(null));

        $event->expects($this->never())->method('setResponse');
        $this->strategy->onDispatchError($event);
    }

    /**
     * @covers Jgut\Zf\Maintenance\View\MaintenanceStrategy::onDispatchError
     */
    public function testWrongError()
    {
        $event  = $this->getMock('Zend\\Mvc\\MvcEvent', array(), array(), '', false);
        $event->expects($this->once())->method('getResult')->will($this->returnValue(null));
        $event->expects($this->once())->method('getResponse')->will($this->returnValue(null));
        $event->expects($this->once())->method('getError')->will($this->returnValue('not_correct_error'));

        $event->expects($this->never())->method('setResponse');
        $this->strategy->onDispatchError($event);
    }

    /**
     * @covers Jgut\Zf\Maintenance\View\MaintenanceStrategy::onDispatchError
     */
    public function testSetResponse()
    {
        $viewModel = $this->getMock('Zend\\View\\Model\\ViewModel', array(), array(), '', false);
        $viewModel->expects($this->once())->method('clearChildren');
        $viewModel->expects($this->once())->method('addChild');

        $event  = $this->getMock('Zend\\Mvc\\MvcEvent', array(), array(), '', false);
        $event->expects($this->once())->method('getResult')->will($this->returnValue(null));
        $event->expects($this->once())->method('getResponse')->will($this->returnValue(null));
        $event->expects($this->once())->method('getError')->will($this->returnValue(ProviderInterface::ERROR));
        $event->expects($this->any())->method('getViewModel')->will($this->returnValue($viewModel));

        $event->expects($this->once())->method('setResponse');
        $this->strategy->onDispatchError($event);
    }
}
