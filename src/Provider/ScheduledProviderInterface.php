<?php
/**
 * JgutZfMaintenance Module (https://github.com/juliangut/zf-maintenance)
 *
 * @link https://github.com/juliangut/zf-maintenance for the canonical source repository
 * @license https://raw.githubusercontent.com/juliangut/zf-maintenance/master/LICENSE
 */

namespace JgutZfMaintenance\Provider;

interface ScheduledProviderInterface extends ProviderInterface
{
    /**
     * Determines if maintenance mode is scheduled.
     *
     * @return boolean
     */
    public function isScheduled();
}
