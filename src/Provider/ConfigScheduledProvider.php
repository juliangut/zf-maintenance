<?php
/**
 * Juliangut Zend Framework Maintenance Module Module (https://github.com/juliangut/zf-maintenance)
 *
 * @link https://github.com/juliangut/zf-maintenance for the canonical source repository
 * @license https://github.com/juliangut/zf-maintenance/blob/master/LICENSE
 */

namespace Jgut\Zf\Maintenance\Provider;

/**
 * Scheduled maintenance provider.
 *
 * Maintenance mode is considered to be On if current date is
 *   - higher than start if only start is defined
 *   - lower than end if only end is defined
 *   - higher than start and lower than end if both are defined
 */
class ConfigScheduledProvider extends AbstractProvider implements ScheduledProviderInterface
{
    /**
     * {@inheritDoc}
     */
    protected $maintenanceDescription =
        'Schdeuled maintenance mode active on Jgut\Zf\Maintenance\Provider\ConfigScheduledProvider';

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
     * @return \DateTime
     */
    public function getStart()
    {
        return $this->start;
    }

    /**
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
