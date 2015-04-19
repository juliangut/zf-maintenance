<?php
/**
 * Juliangut Zend Framework Maintenance Module Module (https://github.com/juliangut/zf-maintenance)
 *
 * @link https://github.com/juliangut/zf-maintenance for the canonical source repository
 * @license https://github.com/juliangut/zf-maintenance/blob/master/LICENSE
 */

namespace Jgut\Zf\Maintenance\Provider;

use Cron\CronExpression;

/**
 * Crontab syntax scheduled maintenance provider
 *
 * Maintenance mode is considered to be On if current date is in the interval
 * initiated by crontab expression
 */
class CrontabProvider extends AbstractProvider implements ScheduledProviderInterface
{
    /**
     * {@inheritDoc}
     */
    protected $maintenanceDescription =
        'Schdeuled maintenance mode active on Jgut\Zf\Maintenance\Provider\CrontabProvider';

    /**
     * @var \Cron\CronExpression
     */
    protected $cronExpression;

    /**
     * @var string
     */
    protected $interval = '';

    /**
     * CRON expression syntax:
     *   *    *    *    *    *    *
     *   |    |    |    |    |    |
     *   |    |    |    |    |    +--- Year [optional]
     *   |    |    |    |    +-------- Day of week (0-7) (Sunday=0|7)
     *   |    |    |    +------------- Month (1-12)
     *   |    |    +------------------ Day of month (1-31)
     *   |    +----------------------- Hour (0-23)
     *   +---------------------------- Minute (0-59)
     *
     * @param string $expression
     * @return void
     */
    public function setExpression($expression)
    {
        try {
            $this->cronExpression = CronExpression::factory($expression);
        } catch (\Exception $e) {
            throw new \InvalidArgumentException(
                sprintf('"%s" is not a valid CRON expression', $expression)
            );

        }
    }

    /**
     * @return string
     */
    public function getExpression()
    {
        return $this->cronExpression instanceof CronExpression ? $this->cronExpression->getExpression() : '';
    }

    /**
     * Sets a valid \DateInterval specification string
     *
     * @param string $interval
     * @return void
     */
    public function setInterval($interval)
    {
        try {
            new \DateInterval($interval);
            $this->interval = $interval;
        } catch (\Exception $e) {
            throw new \InvalidArgumentException(
                sprintf('Interval "%s" is not a valid \DateInterval string', $interval)
            );
        }
    }

    /**
     * @return string
     */
    public function getInterval()
    {
        return $this->interval;
    }

    /**
     * {@inheritDoc}
     */
    public function isScheduled()
    {
        return $this->interval !== '';
    }

    /**
     * {@inheritDoc}
     */
    public function isActive()
    {
        if (!$this->isScheduled()) {
            return false;
        }

        $currentTime = new \DateTime();

        $limitTime = $this->cronExpression->getPreviousRunDate('now', 0, true);
        $limitTime->add(new \DateInterval($this->interval));

        return $currentTime <= $limitTime;
    }

    /**
     * {@inheritDoc}
     */
    public function getScheduleTimes()
    {
        if (!$this->isScheduled()) {
            return array();
        }

        $currentTime = new \DateTime();

        try {
            $startTime = $this->cronExpression->getNextRunDate($currentTime);
        } catch (\RuntimeException $e) {
            return array();
        }

        $endTime = clone $startTime;
        $endTime->add(new \DateInterval($this->interval));

        return array(
            'start' => $startTime,
            'end'   => $endTime,
        );
    }
}
