<?php
/**
 * JgutZfMaintenance Module (https://github.com/juliangut/zf-maintenance)
 *
 * @link https://github.com/juliangut/zf-maintenance for the canonical source repository
 * @license https://raw.githubusercontent.com/juliangut/zf-maintenance/master/LICENSE
 */

namespace JgutZfMaintenance\Provider;

class TimeProvider implements ScheduledProviderInterface
{
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
    public function isScheduled()
    {
        return $this->start || $this->end;
    }
}
