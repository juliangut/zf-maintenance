<?php
/**
 * Juliangut Zend Framework Maintenance Module Module (https://github.com/juliangut/zf-maintenance)
 *
 * @link https://github.com/juliangut/zf-maintenance for the canonical source repository
 * @license https://github.com/juliangut/zf-maintenance/blob/master/LICENSE
 */

namespace Jgut\Zf\MaintenanceTests\Provider;

use PHPUnit_Framework_TestCase;
use Jgut\Zf\Maintenance\Provider\CrontabProvider;

/**
 * @covers Jgut\Zf\Maintenance\Provider\ConfigScheduledProvider
 */
class CrontabProviderTest extends PHPUnit_Framework_TestCase
{
    protected $provider;

    public function setUp()
    {
        $this->provider = new CrontabProvider();
    }

    /**
     * @covers Jgut\Zf\Maintenance\Provider\CrontabProvider::isActive
     * @covers Jgut\Zf\Maintenance\Provider\CrontabProvider::isScheduled
     * @covers Jgut\Zf\Maintenance\Provider\CrontabProvider::getScheduleTimes
     */
    public function testDefaults()
    {
        $this->assertFalse($this->provider->isActive());
        $this->assertFalse($this->provider->isScheduled());
        $this->assertEquals(array(), $this->provider->getScheduleTimes());
    }

    /**
     * @covers Jgut\Zf\Maintenance\Provider\CrontabProvider::setExpression
     * @covers Jgut\Zf\Maintenance\Provider\CrontabProvider::getExpression
     * @expectedException InvalidArgumentException
     */
    public function testExpressionMutatorsAccessors()
    {
        $this->provider->setExpression('@yearly');
        $this->assertEquals('0 0 1 1 *', $this->provider->getExpression());

        $this->provider->setExpression('invalidExpression');
    }

    /**
     * @covers Jgut\Zf\Maintenance\Provider\CrontabProvider::setInterval
     * @covers Jgut\Zf\Maintenance\Provider\CrontabProvider::getInterval
     * @expectedException InvalidArgumentException
     */
    public function testIntervalMutatorsAccessors()
    {
        $this->provider->setInterval('P1M');
        $this->assertEquals('P1M', $this->provider->getInterval());

        $this->provider->setInterval('invalidDateInterval');
    }

    /**
     * @covers Jgut\Zf\Maintenance\Provider\CrontabProvider::isActive
     */
    public function testNotIsActive()
    {
        $time   = new \DateTime();
        $minute = $time->format('i');
        $hour   = $time->format('H');
        $day    = $time->format('d');
        $month  = $time->format('m');

        $this->provider->setInterval('PT10S');

        $this->provider->setExpression(sprintf('%s * * * *', $minute - 10 > -1 ? $minute - 10 : 50));
        $this->assertFalse($this->provider->isActive());

        $this->provider->setExpression(sprintf('* %s * * *', $hour - 1 > -1 ? $hour - 1 : 23));
        $this->assertFalse($this->provider->isActive());

        $this->provider->setExpression(sprintf('* * %s * *', $day - 1 > -1 ? $day - 1 : 28));
        $this->assertFalse($this->provider->isActive());

        $this->provider->setExpression(sprintf('* * * %s *', $month - 1 > -1 ? $month - 1 : 12));
        $this->assertFalse($this->provider->isActive());
    }

    /**
     * @covers Jgut\Zf\Maintenance\Provider\CrontabProvider::isActive
     */
    public function testIsActive()
    {
        $time = new \DateTime();
        $minute = $time->format('i');
        $hour   = $time->format('H');
        $day    = $time->format('d');
        $month  = $time->format('m');

        $this->provider->setInterval('PT1M');
        $this->provider->setExpression(sprintf('%s * * * *', $minute));
        $this->assertTrue($this->provider->isActive());

        $this->provider->setInterval('PT1H');
        $this->provider->setExpression(sprintf('* %s * * *', $hour));
        $this->assertTrue($this->provider->isActive());

        $this->provider->setInterval('P1D');
        $this->provider->setExpression(sprintf('* * %s * *', $day));
        $this->assertTrue($this->provider->isActive());

        $this->provider->setInterval('P1M');
        $this->provider->setExpression(sprintf('* * * %s *', $month));
        $this->assertTrue($this->provider->isActive());
    }

    /**
     * @covers Jgut\Zf\Maintenance\Provider\CrontabProvider::getScheduleTimes
     */
    public function testScheduleTimes()
    {
        $currentTime = new \DateTime();
        $currentTime->setTime($currentTime->format('H'), $currentTime->format('i'));
        $currentTime->add(new \DateInterval('PT1M')); //skip current minute

        $endTime = clone $currentTime;
        $endTime->add(new \DateInterval('PT1H'));

        $expected = array(
            'start' => $currentTime,
            'end'   => $endTime,
        );

        $this->provider->setInterval('PT1H');
        $this->provider->setExpression('* ' . $currentTime->format('H') . ' ' . $currentTime->format('d') . ' * *');

        $this->assertEquals($expected, $this->provider->getScheduleTimes());

        $this->provider->setExpression('* ' . $currentTime->format('H') . ' ' . $currentTime->format('D') . ' * *');
        $this->assertEquals(array(), $this->provider->getScheduleTimes());
    }
}
