<?php
/**
 * JgutZfMaintenance Module (https://github.com/juliangut/zf-maintenance)
 *
 * @link https://github.com/juliangut/zf-maintenance for the canonical source repository
 * @license https://raw.githubusercontent.com/juliangut/zf-maintenance/master/LICENSE
 */

namespace JgutZfMaintenanceTest\Collector;

use PHPUnit_Framework_TestCase;
use JgutZfMaintenance\Collector\MaintenanceCollector;

/**
 * @covers JgutZfMaintenance\Collector\MaintenanceCollector
 */
class MaintenanceCollectorTest extends PHPUnit_Framework_TestCase
{
    /**
     * @covers JgutZfMaintenance\Collector\MaintenanceCollector::getName
     * @covers JgutZfMaintenance\Collector\MaintenanceCollector::getPriority
     * @covers JgutZfMaintenance\Collector\MaintenanceCollector::collect
     * @covers JgutZfMaintenance\Collector\MaintenanceCollector::isActive
     * @covers JgutZfMaintenance\Collector\MaintenanceCollector::getScheduleTimes
     */
    public function testDefault()
    {
        $collector = new MaintenanceCollector();

        $this->assertEquals(MaintenanceCollector::NAME, $collector->getName());
        $this->assertEquals(MaintenanceCollector::PRIORITY, $collector->getPriority());

        $event  = $this->getMock('Zend\\Mvc\\MvcEvent', array(), array(), '', false);
        $collector->collect($event);

        $this->assertFalse($collector->isActive());
        $this->assertEquals(0, count($collector->getScheduleTimes()));
    }

    /**
     * @covers JgutZfMaintenance\Collector\MaintenanceCollector::collect
     * @covers JgutZfMaintenance\Collector\MaintenanceCollector::isActive
     * @covers JgutZfMaintenance\Collector\MaintenanceCollector::getScheduleTimes
     */
    public function testReturnActiveSchedule()
    {
        $scheduleTimes = array('start' => new \DateTime('now'), 'end' => null);

        $scheduledProvider =
            $this->getMock('JgutZfMaintenance\\Provider\\ConfigScheduledProvider', array(), array(), '', false);
        $scheduledProvider->expects($this->any())->method('isActive')->will($this->returnValue(false));
        $scheduledProvider->expects($this->once())->method('isScheduled')->will($this->returnValue(true));
        $scheduledProvider->expects($this->once())->method('getScheduleTimes')->will(
            $this->returnValue($scheduleTimes)
        );

        $configProvider = $this->getMock('JgutZfMaintenance\\Provider\\ConfigProvider', array(), array(), '', false);
        $configProvider->expects($this->once())->method('isActive')->will($this->returnValue(true));

        $serviceManager = $this->getMock('Zend\\ServiceManager\\ServiceManager', array(), array(), '', false);
        $serviceManager->expects($this->any())->method('has')->will($this->returnValue(true));
        $serviceManager->expects($this->any())->method('get')->will(
            $this->returnCallback(
                function () use ($configProvider, $scheduledProvider) {
                    $args = array(
                        'JgutZfMaintenance\\Provider\\ConfigProvider'          => $configProvider,
                        'JgutZfMaintenance\\Provider\\ConfigScheduledProvider' => $scheduledProvider
                    );
                    return $args[func_get_arg(0)];
                }
            )
        );

        $application = $this->getMock('Zend\\Mvc\\Application', array(), array(), '', false);
        $application->expects($this->once())->method('getServiceManager')->will($this->returnValue($serviceManager));

        $event  = $this->getMock('Zend\\Mvc\\MvcEvent', array(), array(), '', false);
        $event->expects($this->once())->method('getApplication')->will($this->returnValue($application));

        $providers = array(
            'JgutZfMaintenance\\Provider\\ConfigProvider'          => '',
            'JgutZfMaintenance\\Provider\\ConfigScheduledProvider' => '',
        );

        $collector = new MaintenanceCollector($providers);
        $collector->collect($event);

        $this->assertTrue($collector->isActive());
        $this->assertEquals(2, count($collector->getScheduleTimes()));
    }
}
