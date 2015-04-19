<?php
/**
 * Juliangut Zend Framework Maintenance Module Module (https://github.com/juliangut/zf-maintenance)
 *
 * @link https://github.com/juliangut/zf-maintenance for the canonical source repository
 * @license https://github.com/juliangut/zf-maintenance/blob/master/LICENSE
 */

namespace Jgut\Zf\MaintenanceTests\Collector;

use PHPUnit_Framework_TestCase;
use Jgut\Zf\Maintenance\Collector\MaintenanceCollector;

/**
 * @covers Jgut\Zf\Maintenance\Collector\MaintenanceCollector
 */
class MaintenanceCollectorTest extends PHPUnit_Framework_TestCase
{
    /**
     * @covers Jgut\Zf\Maintenance\Collector\MaintenanceCollector::getName
     * @covers Jgut\Zf\Maintenance\Collector\MaintenanceCollector::getPriority
     * @covers Jgut\Zf\Maintenance\Collector\MaintenanceCollector::collect
     * @covers Jgut\Zf\Maintenance\Collector\MaintenanceCollector::isActive
     * @covers Jgut\Zf\Maintenance\Collector\MaintenanceCollector::getScheduleTimes
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
     * @covers Jgut\Zf\Maintenance\Collector\MaintenanceCollector::collect
     * @covers Jgut\Zf\Maintenance\Collector\MaintenanceCollector::isActive
     * @covers Jgut\Zf\Maintenance\Collector\MaintenanceCollector::getScheduleTimes
     */
    public function testReturnActiveSchedule()
    {
        $startTime = new \DateTime();
        $startTime->add(new \DateInterval('P1D'));
        $endTime = new \DateTime();
        $endTime->add(new \DateInterval('P10D'));
        $cronTimes = array('start' => $startTime, 'end' => $endTime);

        $cronProvider =$this->getMock('Jgut\\Zf\\Maintenance\\Provider\\CrontabProvider', array(), array(), '', false);
        $cronProvider->expects($this->any())->method('isActive')->will($this->returnValue(false));
        $cronProvider->expects($this->any())->method('isScheduled')->will($this->returnValue(true));
        $cronProvider->expects($this->any())->method('getScheduleTimes')->will(
            $this->returnValue($cronTimes)
        );

        $startTime = new \DateTime();
        $startTime->add(new \DateInterval('P5D'));
        $scheduleTimes = array('start' => $startTime, 'end' => null);

        $scheduledProvider =
            $this->getMock('Jgut\\Zf\\Maintenance\\Provider\\ConfigScheduledProvider', array(), array(), '', false);
        $scheduledProvider->expects($this->any())->method('isActive')->will($this->returnValue(false));
        $scheduledProvider->expects($this->once())->method('isScheduled')->will($this->returnValue(true));
        $scheduledProvider->expects($this->once())->method('getScheduleTimes')->will(
            $this->returnValue($scheduleTimes)
        );

        $configProvider = $this->getMock(
            'Jgut\\Zf\\Maintenance\\Provider\\ConfigProvider',
            array(),
            array(),
            '',
            false
        );
        $configProvider->expects($this->once())->method('isActive')->will($this->returnValue(true));

        $serviceManager = $this->getMock('Zend\\ServiceManager\\ServiceManager', array(), array(), '', false);
        $serviceManager->expects($this->any())->method('has')->will($this->returnValue(true));
        $serviceManager->expects($this->any())->method('get')->will(
            $this->returnCallback(
                function () use ($configProvider, $scheduledProvider, $cronProvider) {
                    $args = array(
                        'Jgut\\Zf\\Maintenance\\Provider\\ConfigProvider'           => $configProvider,
                        'Jgut\\Zf\\Maintenance\\Provider\\ConfigScheduledProvider'  => $scheduledProvider,
                        'Jgut\\Zf\\Maintenance\\Provider\\CrontabProvider'          => $cronProvider,
                        'Jgut\\Zf\\Maintenance\\Provider\\DuplicateCrontabProvider' => $cronProvider,
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
            'Jgut\\Zf\\Maintenance\\Provider\\ConfigProvider'           => '',
            'Jgut\\Zf\\Maintenance\\Provider\\ConfigScheduledProvider'  => '',
            'Jgut\\Zf\\Maintenance\\Provider\\CrontabProvider'          => '',
            'Jgut\\Zf\\Maintenance\\Provider\\DuplicateCrontabProvider' => '',
        );

        $collector = new MaintenanceCollector($providers);
        $collector->collect($event);

        $this->assertTrue($collector->isActive());
        $this->assertEquals(3, count($collector->getScheduleTimes()));
    }
}
