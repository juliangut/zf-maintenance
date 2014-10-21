<?php
/**
 * JgutZfMaintenance Module (https://github.com/juliangut/zf-maintenance)
 *
 * @link https://github.com/juliangut/zf-maintenance for the canonical source repository
 * @license https://raw.githubusercontent.com/juliangut/zf-maintenance/master/LICENSE
 */

namespace JgutZfMaintenance\Provider;

use Zend\Mvc\MvcEvent;

class ConfigScheduledProvider extends AbstractProvider implements ScheduledProviderInterface
{
    /**
     * {@inheritDoc}
     */
    protected $maintenanceDescription =
        'Schdeuled maintenance mode active on JgutZfMaintenance\Provider\ConfigScheduledProvider';

    /**
     * Maintenance start time.
     *
     * @var \DateTime
     */
    protected $start;

    /**
     * Maintenance end time.
     *
     * @var \DateTime
     */
    protected $end;

    /**
     * Set maintenance start time.
     *
     * @param \DateTime $start
     * @return void
     */
    public function setStart(\DateTime $start)
    {
        if ($this->end && $start > $this->end) {
            throw new \InvalidArgumentException('Start time should come before end time');
        }

        $this->start = $start;
    }

    /**
     * Get maintenance start time.
     *
     * @return \DateTime
     */
    public function getStart()
    {
        return $this->start;
    }

    /**
     * Set maintenance end time.
     *
     * @param \DateTime $end
     * @return void
     */
    public function setEnd(\DateTime $end)
    {
        if ($this->start && $end < $this->start) {
            throw new \InvalidArgumentException('End time should come after start time');
        }

        $this->end = $end;
    }

    /**
     * Get maintenance end time.
     *
     * @return \DateTime
     */
    public function getEnd()
    {
        return $this->end;
    }

    /**
     * {@inheritDoc}
     */
    public function isActive()
    {
        $now = new \DateTime('now');

        if (!$this->start && !$this->end) {
            return false;
        }

        if ($this->start && $now < $this->start) {
            return false;
        }
        if ($this->end && $now > $this->end) {
            return false;
        }

        return true;
    }

    /**
     * {@inheritDoc}
     */
    public function onRoute(MvcEvent $event)
    {
        if ($this->isActive()) {
            parent::onRoute($event);
        }
    }

    /**
     * {@inheritDoc}
     */
    public function isScheduled()
    {
        $now = new \DateTime('now');

        return $this->start && $now < $this->start;
    }

    /**
     * {@inheritDoc}
     */
    public function getScheduleTimes()
    {
        if (!$this->isScheduled()) {
            return array();
        }

        return array(
            'start' => $this->start,
            'end'   => $this->end,
        );
    }
}
