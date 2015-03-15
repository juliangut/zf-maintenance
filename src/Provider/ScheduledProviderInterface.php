<?php
/**
 * Juliangut Zend Framework Maintenance Module Module (https://github.com/juliangut/zf-maintenance)
 *
 * @link https://github.com/juliangut/zf-maintenance for the canonical source repository
 * @license https://raw.githubusercontent.com/juliangut/zf-maintenance/master/LICENSE
 */

namespace Jgut\Zf\Maintenance\Provider;

interface ScheduledProviderInterface extends ProviderInterface
{
    /**
     * Determines if maintenance mode is scheduled.
     *
     * @return boolean
     */
    public function isScheduled();

    /**
     * Get schedule time span.
     *
     * @return array()
     */
    public function getScheduleTimes();
}
