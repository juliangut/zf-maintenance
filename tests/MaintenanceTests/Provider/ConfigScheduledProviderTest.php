<?php
/**
 * Juliangut Zend Framework Maintenance Module Module (https://github.com/juliangut/zf-maintenance)
 *
 * @link https://github.com/juliangut/zf-maintenance for the canonical source repository
 * @license https://github.com/juliangut/zf-maintenance/blob/master/LICENSE
 */

namespace Jgut\Zf\MaintenanceTests\Provider;

use PHPUnit_Framework_TestCase;
use Jgut\Zf\Maintenance\Provider\ConfigScheduledProvider;

/**
 * @covers Jgut\Zf\Maintenance\Provider\ConfigScheduledProvider
 */
class ConfigScheduledProviderTest extends PHPUnit_Framework_TestCase
{
    protected $provider;

    public function setUp()
    {
        $this->provider = new ConfigScheduledProvider();
    }

    /**
     * @covers Jgut\Zf\Maintenance\Provider\ConfigScheduledProvider::isActive
     * @covers Jgut\Zf\Maintenance\Provider\ConfigScheduledProvider::isScheduled
     * @covers Jgut\Zf\Maintenance\Provider\ConfigScheduledProvider::getScheduleTimes
     * @covers Jgut\Zf\Maintenance\Provider\AbstractProvider::onRoute
     */
    public function testDefaults()
    {
        $event = $this->getMock('Zend\\Mvc\\MvcEvent', array(), array(), '', false);

        $this->assertFalse($this->provider->isActive());
        $this->assertFalse($this->provider->isScheduled());
        $this->assertEquals(array(), $this->provider->getScheduleTimes());
        $this->assertNull($this->provider->onRoute($event));
    }

    /**
     * @covers Jgut\Zf\Maintenance\Provider\ConfigScheduledProvider::setStart
     * @covers Jgut\Zf\Maintenance\Provider\ConfigScheduledProvider::getStart
     * @covers Jgut\Zf\Maintenance\Provider\ConfigScheduledProvider::setEnd
     * @covers Jgut\Zf\Maintenance\Provider\ConfigScheduledProvider::getEnd
     * @covers Jgut\Zf\Maintenance\Provider\ConfigScheduledProvider::isActive
     * @covers Jgut\Zf\Maintenance\Provider\ConfigScheduledProvider::isScheduled
     * @covers Jgut\Zf\Maintenance\Provider\ConfigScheduledProvider::getScheduleTimes
     */
    public function testTimes()
    {
        $start = new \DateTime();
        $start->add(new \DateInterval('P1D'));

        $this->provider->setStart($start);
        $this->assertEquals($start, $this->provider->getStart());
        $this->assertFalse($this->provider->isActive());
        $this->assertTrue($this->provider->isScheduled());
        $this->assertEquals(array('start' => $start, 'end' => null), $this->provider->getScheduleTimes());

        $this->provider = new ConfigScheduledProvider();

        $end = new \DateTime();
        $end->add(new \DateInterval('P2D'));

        $this->provider->setEnd($end);
        $this->assertEquals($end, $this->provider->getEnd());
        $this->assertTrue($this->provider->isActive());
        $this->assertFalse($this->provider->isScheduled());
        $this->assertEquals(array(), $this->provider->getScheduleTimes());

        $this->provider->setStart($start);
        $this->assertFalse($this->provider->isActive());
        $this->assertTrue($this->provider->isScheduled());
        $this->assertEquals(array('start' => $start, 'end' => $end), $this->provider->getScheduleTimes());

        $this->provider = new ConfigScheduledProvider();

        $end = new \DateTime();
        $end->sub(new \DateInterval('P2D'));

        $this->provider->setEnd($end);
        $this->assertEquals($end, $this->provider->getEnd());
        $this->assertFalse($this->provider->isActive());
        $this->assertFalse($this->provider->isScheduled());
        $this->assertEquals(array(), $this->provider->getScheduleTimes());
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testInvalidEndDate()
    {
        $start = new \DateTime();
        $this->provider->setStart($start);

        $end = new \DateTime();
        $end->sub(new \DateInterval('P2D'));
        $this->provider->setEnd($end);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testInvalidStartDate()
    {
        $end = new \DateTime();
        $this->provider->setEnd($end);

        $start = new \DateTime();
        $start->add(new \DateInterval('P2D'));
        $this->provider->setStart($start);
    }

    /**
     * @covers Jgut\Zf\Maintenance\Provider\ConfigScheduledProvider::setStart
     * @covers Jgut\Zf\Maintenance\Provider\ConfigScheduledProvider::setEnd
     * @covers Jgut\Zf\Maintenance\Provider\ConfigScheduledProvider::isActive
     */
    public function testBeforeTime()
    {
        $start = new \DateTime();
        $start->add(new \DateInterval('P1D'));
        $this->provider->setStart($start);

        $this->assertFalse($this->provider->isActive());

        $end = new \DateTime();
        $end->add(new \DateInterval('P2D'));
        $this->provider->setStart($end);

        $this->assertFalse($this->provider->isActive());
    }

    /**
     * @covers Jgut\Zf\Maintenance\Provider\ConfigScheduledProvider::setStart
     * @covers Jgut\Zf\Maintenance\Provider\ConfigScheduledProvider::setEnd
     * @covers Jgut\Zf\Maintenance\Provider\ConfigScheduledProvider::isActive
     */
    public function testAfterTime()
    {
        $end = new \DateTime();
        $end->sub(new \DateInterval('P1D'));
        $this->provider->setEnd($end);

        $this->assertFalse($this->provider->isActive());

        $start = new \DateTime();
        $start->sub(new \DateInterval('P2D'));
        $this->provider->setStart($start);

        $this->assertFalse($this->provider->isActive());
    }
}
