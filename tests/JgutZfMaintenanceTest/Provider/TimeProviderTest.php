<?php
/**
 * JgutZfMaintenance Module (https://github.com/juliangut/zf-maintenance)
 *
 * @link https://github.com/juliangut/zf-maintenance for the canonical source repository
 * @license https://raw.githubusercontent.com/juliangut/zf-maintenance/master/LICENSE
 */

namespace JgutZfMaintenanceTest\Exclusion;

use PHPUnit_Framework_TestCase;
use JgutZfMaintenance\Provider\TimeProvider;

/**
 * @covers JgutZfMaintenance\Provider\TimeProvider
 */
class TimeProviderTest extends PHPUnit_Framework_TestCase
{
    /**
     * @covers JgutZfMaintenance\Provider\TimeProvider::isActive
     * @covers JgutZfMaintenance\Provider\TimeProvider::setStart
     * @covers JgutZfMaintenance\Provider\TimeProvider::getStart
     * @covers JgutZfMaintenance\Provider\TimeProvider::isScheduled
     * @covers JgutZfMaintenance\Provider\TimeProvider::setEnd
     * @covers JgutZfMaintenance\Provider\TimeProvider::getEnd
     */
    public function testDefaults()
    {
        $provider = new TimeProvider();

        $this->assertFalse($provider->isActive());
        $this->assertFalse($provider->isScheduled());

        $now = new \DateTime('now');

        $provider->setStart($now);
        $this->assertEquals($now, $provider->getStart());
        $this->assertTrue($provider->isScheduled());

        $provider = new TimeProvider();

        $provider->setEnd($now);
        $this->assertEquals($now, $provider->getEnd());
        $this->assertTrue($provider->isScheduled());

        $provider->setStart($now);
        $this->assertTrue($provider->isScheduled());
    }

    /**
     * @covers JgutZfMaintenance\Provider\TimeProvider::setStart
     * @covers JgutZfMaintenance\Provider\TimeProvider::setEnd
     * @covers JgutZfMaintenance\Provider\TimeProvider::isActive
     */
    public function testBeforeTime()
    {
        $provider = new TimeProvider();

        $start = new \DateTime('now');
        $start->add(new \DateInterval('P1D'));
        $provider->setStart($start);

        $this->assertFalse($provider->isActive());

        $end = new \DateTime('now');
        $end->add(new \DateInterval('P2D'));
        $provider->setStart($end);

        $this->assertFalse($provider->isActive());
    }

    /**
     * @covers JgutZfMaintenance\Provider\TimeProvider::setStart
     * @covers JgutZfMaintenance\Provider\TimeProvider::setEnd
     * @covers JgutZfMaintenance\Provider\TimeProvider::isActive
     */
    public function testAfterTime()
    {
        $provider = new TimeProvider();

        $end = new \DateTime('now');
        $end->sub(new \DateInterval('P1D'));
        $provider->setEnd($end);

        $this->assertFalse($provider->isActive());

        $start = new \DateTime('now');
        $start->sub(new \DateInterval('P2D'));
        $provider->setStart($start);

        $this->assertFalse($provider->isActive());
    }

    /**
     * @covers JgutZfMaintenance\Provider\TimeProvider::setStart
     * @covers JgutZfMaintenance\Provider\TimeProvider::setEnd
     * @covers JgutZfMaintenance\Provider\TimeProvider::isActive
     */
    public function testInTime()
    {
        $provider = new TimeProvider();

        $start = new \DateTime('now');
        $start->sub(new \DateInterval('P1D'));
        $provider->setStart($start);

        $end = new \DateTime('now');
        $end->add(new \DateInterval('P1D'));
        $provider->setEnd($end);

        $this->assertTrue($provider->isActive());
    }
}
